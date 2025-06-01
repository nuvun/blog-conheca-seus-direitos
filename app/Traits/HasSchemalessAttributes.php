<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

trait HasSchemalessAttributes
{
    public function initializeHasSchemalessAttributes()
    {
        $this->casts['attributes'] = SchemalessAttributes::class;
    }

    public function scopeWithAttributes(Builder $query, string $attributeName, $value): Builder
    {
        return $query->where("attributes->$attributeName", $value);
    }

    public function getValueSchemalessAttributes($attributeKey): mixed
    {
        $attributes = json_decode($this->attributes['attributes'] ?? '{}', true);

        $keys = explode('.', $attributeKey);

        foreach ($keys as $key) {
            $attributes = $attributes[$key] ?? null;
        }

        return $attributes;
    }

}
