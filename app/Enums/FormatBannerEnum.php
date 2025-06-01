<?php

namespace App\Enums;

enum FormatBannerEnum: string
{
    case FILE = 'Arquivo';
    case CODE = 'Código';

    public static function getDescriptions(): array
    {
        return array_map(
            fn($case) => ['value' => $case->name, 'name' => $case->value],
            self::cases()
        );
    }

    public static function fromName(string $name): string
    {
        foreach (self::cases() as $item) {
            if ($name === $item->name) {
                return $item->value;
            }
        }

        return false;
    }

}


