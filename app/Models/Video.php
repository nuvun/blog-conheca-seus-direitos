<?php

namespace App\Models;

use App\Traits\Auditable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Video extends Model implements HasMedia, Viewable
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use InteractsWithViews;

    public $table = 'videos';

    public static array $searchable = [
        'title',
    ];

    protected $appends = [
        'featured_image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'external_link',
        'content',
        'duration',
    ];

    protected static function booted(): void
    {
        static::saving(function() {
            Cache::forget('lastVideos');
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ContentCategory::class, 'category_id');
    }

    public function getFeaturedImageAttribute()
    {
        $file = $this->getMedia('featured_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        } else if (!empty($this->youtubeId)) {
            $file = new \stdClass();
            $file->url       = "https://i.ytimg.com/vi/"."{$this->youtubeId}"."/hqdefault.jpg";
            $file->preview   = "https://i.ytimg.com/vi/"."{$this->youtubeId}"."/hqdefault.jpg";
            $file->file_name = "hqdefault.jpg";
        }

        return $file;
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn() => route('site.videos.show', ['slug' => str()->slug($this->title), 'video' => $this->id])
        )->shouldCache();
    }

    public function youtubeId(): Attribute
    {
        return Attribute::make(
            get: function () {
                $patterns = [
                    '/youtube\.com\/watch\?v=([^\&\?\/]+)/',  // Padrão para links do tipo youtube.com/watch?v=
                    '/youtube\.com\/embed\/([^\&\?\/]+)/',    // Padrão para links do tipo youtube.com/embed/
                    '/youtube\.com\/v\/([^\&\?\/]+)/',        // Padrão para links do tipo youtube.com/v/
                    '/youtu\.be\/([^\&\?\/]+)/',              // Padrão para links do tipo youtu.be/
                    '/youtube\.com\/shorts\/([^\&\?\/]+)/',   // Padrão para links do tipo youtube.com/shorts/
                    '/youtube\.com\/live\/([^\&\?\/]+)/'      // Padrão para links do tipo youtube.com/live/
                ];

                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $this->external_link, $matches)) {
                        $idVideoYoutube = $matches[1];
                    }
                }

                return $idVideoYoutube ?? null;
            }
        )->shouldCache();
    }

}
