<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSchemalessAttributes;
use App\Traits\HasScopeActive;
use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContentCategory extends Model implements HasMedia
{
    use SoftDeletes;
    use Auditable;
    use InteractsWithMedia;
    use HasScopeActive;
    use HasSchemalessAttributes;

    public $table = 'content_categories';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public const STATUS_RADIO = [
        'active'   => 'Ativo',
        'inactive' => 'Inativo',
    ];

    protected $fillable = [
        'type_category_id',
        'name',
        'description',
        'slug',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = str($model->name)->slug();
            }
        });

        static::saving(function() {
            Cache::deleteMultiple(['listCategoriesNews', 'listBlogs']);
        });

        static::created(function() {
            Cache::deleteMultiple(['listCategoriesNews', 'listBlogs']);
        });
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')->format('webp');
    }

    public function type_category(): BelongsTo
    {
        return $this->belongsTo(TypeCategory::class, 'type_category_id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'content_category_post');
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => route('site.posts.category', ['categoryPost' => $this->slug])
        )->shouldCache();
    }

    public function photo(): Attribute
    {
        return Attribute::make(
            get: function () {
                $file = $this->getMedia('photo')->last();
                if ($file) {
//                    $file->url = $file->getUrl('webp') ?? $file->getUrl();
                    $file->url = $file->getUrl();
                } else {
                    $file = new Media();
                    $file->url  = asset('images/site/favicon.png');
                    $file->webp = asset('images/site/favicon.png');
                }

                return $file;
            }
        )->shouldCache();
    }

    public function scopeIsNews(Builder $query): Builder
    {
        return $query->whereHas('type_category', fn($query) => $query->where('id', 1));
    }

    public function scopeIsBlog(Builder $query): Builder
    {
        return $query->whereHas('type_category', fn($query) => $query->where('id', 2));
    }

}
