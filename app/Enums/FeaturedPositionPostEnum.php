<?php

namespace App\Enums;

enum FeaturedPositionPostEnum: string
{

//    case NO = 'Não';
    case YES = 'Sim';
//    case HEADLINE = 'Manchete';
//    case FEATURED_PHOTO = 'Destaque foto';
//    case SPECIAL_HIGHLIGHT = 'Destaque especial';

    public static function getDescriptions(): array
    {
        return [
//            ['value' => self::NO->name, 'description' => self::NO->value],
            ['value' => self::YES->name, 'description' => self::YES->value],
//            ['value' => self::HEADLINE->name, 'description' => self::HEADLINE->value],
//            ['value' => self::FEATURED_PHOTO->name, 'description' => self::FEATURED_PHOTO->value],
//            ['value' => self::SPECIAL_HIGHLIGHT->name, 'description' => self::SPECIAL_HIGHLIGHT->value . " (preencha o campo foto destaque especial que deve ter 1200 x 220 pixels)"],
        ];
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
