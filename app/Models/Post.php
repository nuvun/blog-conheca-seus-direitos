<?php

namespace App\Models;

use App\Enums\FeaturedPositionPostEnum;
use App\Enums\StatusEnum;
use App\Jobs\InvalidatePostCacheJob;
use App\Jobs\SendPushNotificationJob;
use App\Traits\Auditable;
use App\Traits\HasSchemalessAttributes;
use App\Traits\HasScopeActive;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class Post extends Model implements HasMedia, Viewable
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasSchemalessAttributes;
    use HasScopeActive;
    use InteractsWithViews;

    public $table = 'posts';

    public static array $searchable = [
        'title',
        'subtitle',
    ];

    public const STATUS_RADIO = [
        'ACTIVE'   => 'Ativo',
        'INACTIVE' => 'Inativo',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'image_id',
        'featured_position',
        'title',
        'subtitle',
        'content',
        'source',
        'published_at',
        'status',
        'attributes',
    ];

    protected static function booted(): void
    {
        static::saving(function($post) {
            if (isset($post->id)) {
                Cache::forget('post_' . $post->id);
                Cache::forget('post_' . $post->id . '_related');
            }

            Cache::forget('lastPosts');
        });

        static::saved(function($post) {
            if ($post->published_at && $post->published_at->isFuture()) {
                InvalidatePostCacheJob::dispatch($post->id)
                    ->delay($post->published_at);
            }
        });

        static::created(function($post) {
            if (!$post->getValueSchemalessAttributes('crawler') && $post->isActive) {
                SendPushNotificationJob::dispatch(
                    title: $post->title,
                    url: $post->url
                )->delay($post->published_at);
            }
        });

        static::deleted(function($post) {
            if (isset($post->id)) {
                Cache::forget('post_' . $post->id);
                Cache::forget('post_' . $post->id . '_related');
            }

            Cache::forget('lastPosts');
        });
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 50, 50);
        $this->addMediaConversion('preview')->fit(Fit::Crop, 120, 120);
        $this->addMediaConversion('webp')->format('webp');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ContentCategory::class);
    }

    public function category(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->categories->first()
        )->shouldCache();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ContentTag::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class)->with('media');
    }

    public function featuredImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->hasMedia('image_featured')
                    ? $this->getMedia('image_featured')->last()->getUrl()
                    : (!empty($this->migration_image_url)
//                        ? 'https://arquivo1.com' . $this->migration_image_url
                        ? 'https://arquivo1.com' . str_replace("/migration", "", $this->migration_image_url)
                        : $this->image?->photo?->url);
                })->shouldCache();
            }

    public function featuredPosition(): Attribute
    {
        return Attribute::make(
            get: fn() => FeaturedPositionPostEnum::fromName($this->attributes['featured_position'] ?? '')
        )->shouldCache();
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!empty($this->migration_slug) && !str($this->migration_slug)->startsWith('/')) {
                    return '/noticia/' . $this->migration_slug. '.html';
                }

                return route('site.posts.show', ['slug' => str()->slug($this->title), 'post' => $this->id]);
            }
        )->shouldCache();
    }

    public function urlAmp(): Attribute
    {
        return Attribute::make(
            get: fn() => route('site.posts.showAmp', ['slug' => str()->slug($this->title), 'post' => $this->id])
        )->shouldCache();
    }

    public function scopeValidPeriod(Builder $query): Builder
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeFilterByFeaturedPosition(Builder $query, $position, int $take): Builder
    {
        return $query->where('featured_position', $position)
            ->active()
            ->validPeriod()
            ->latest('published_at')
            ->take($take);
    }

    public function scopeFilterByCategoryId(Builder $query, int $categoryId, int $take): Builder
    {
        return $query->whereHas('categories', fn($query) => $query->where('content_category_id', $categoryId))
            ->active()
            ->validPeriod()
            ->latest('published_at')
            ->take($take);
    }

    public function scopeSearchTerm(Builder $query, string $term): Builder
    {
        return $query->whereAny(
            ['title', 'subtitle'],
            'LIKE',
            "%$term%"
        );
    }

    public function scopeFilterPeriod(Builder $query, string $period): Builder
    {
        [$start, $end] = explode(' - ', $period);

        return $query->whereBetween('published_at', [
            Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
            Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
        ]);
    }

    public function scopeIsFromBlog(Builder $builder): Builder
    {
        return $builder->whereHas('categories.type_category', function ($query) {
            $query->where('name', 'Blogs');
        });
    }

    public function isFromBlog(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->categories->contains('type_category.name', 'Blogs')
        )->shouldCache();
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->published_at && $this->published_at->isPast()
        )->shouldCache();
    }

}
