<?php declare(strict_types=1);

namespace App\Enums;

enum Moods
{
    case Minor;
    case Major;

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return match ($this) {
            self::Minor => 'm',
            self::Major => '',
        };
    }
}
