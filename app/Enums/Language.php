<?php

namespace App\Enums;

enum Language: string
{
    case EN = 'en';
    case DE = 'de';

    public function label(): string
    {
        return match($this) {
            self::EN => 'English',
            self::DE => 'Deutsch',
        };
    }
}
