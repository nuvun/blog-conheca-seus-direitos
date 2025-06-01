<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function getDescriptions(): array
    {
        return [
            ['value' => self::ACTIVE->value,   'description' => 'Ativo'],
            ['value' => self::INACTIVE->value, 'description' => 'Inativo'],
        ];
    }

}


