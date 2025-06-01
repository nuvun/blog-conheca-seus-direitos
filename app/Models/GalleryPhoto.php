<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryPhoto extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable;

    public $table = 'gallery_photos';

    protected $appends = [
        'images',
    ];

    public static array $searchable = [
        'title',
    ];

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
        'title',
        'description',
        'status',
    ];

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

    public function getImagesAttribute()
    {
        $files = $this->getMedia('images');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function iframeToIncorporate(): Attribute
    {
        return Attribute::make(
            get: function () {
                $route = route('site.gallery-photos.iframe', $this->id);

                return "<iframe class=\"iframeGalleryPhoto\" width=\"100%\" height=\"650\" frameborder=\"0\" scrolling=\"no\" src=\"{$route}\"></iframe>";
            },
        )->shouldCache();
    }

}
