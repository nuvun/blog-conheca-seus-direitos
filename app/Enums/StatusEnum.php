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

    public static function getFromName(string $name): string
    {
        return array_values(array_filter(self::getDescriptions(), fn($value) => $value['value'] === $name))[0]['description'] ?? '';
    }

}


