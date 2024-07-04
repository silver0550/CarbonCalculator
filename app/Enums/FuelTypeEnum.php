<?php

namespace App\Enums;

enum FuelTypeEnum: string
{
    case PATROL = 'P';
    case ELECTRONIC = 'E';
    case DIESEL = 'D';
    case HYBRID = 'H';

    public function getReadableText(): string
    {
        return match ($this) {
            self::PATROL => __('fuel_type.patrol'),
            self::ELECTRONIC => __('fuel_type.electric'),
            self::DIESEL => __('fuel_type.diesel'),
            self::HYBRID => __('fuel_type.gas'),
        };
    }
}
