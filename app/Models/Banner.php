<?php

namespace App\Models;

use App\Enums\FormatBannerEnum;
use App\Traits\Auditable;
use App\Traits\HasScopeActive;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Banner extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasScopeActive;

    public $table = 'banners';

    protected $appends = [
        'image',
    ];

    public static $searchable = [
        'name',
    ];

    public const STATUS_RADIO = [
        'active'   => 'Ativo',
        'Inactive' => 'Inativo',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'type_banner_id',
        'name',
        'format',
        'code',
        'start_at',
        'end_at',
        'link',
        'position',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function() {
            Cache::forget('banners');
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

        if (in_array($media->extension, ['png', 'jpg', 'jpeg'])) {
            $this->addMediaConversion('webp')->format('webp');
        }
    }

    public function type_banner(): BelongsTo
    {
        return $this->belongsTo(TypeBanner::class, 'type_banner_id');
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function scopeValidPeriod(Builder $query): Builder
    {
        return $query->where('start_at', '<=', Carbon::now())
            ->where('end_at', '>=', Carbon::now());
    }

    public function formatTranslated(): Attribute
    {
        return Attribute::make(
            get: fn() => FormatBannerEnum::fromName($this->format)
        )->shouldCache();
    }

    public function isFormatCode(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->format === FormatBannerEnum::CODE->name
        )->shouldCache();
    }

}
