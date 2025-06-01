<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

trait HasScopeActive
{

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where($this->table . '.status', StatusEnum::ACTIVE->name);
    }

}
