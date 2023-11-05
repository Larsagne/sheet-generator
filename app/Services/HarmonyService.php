<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\HarmonyServiceInterface;
use App\Models\Key;

class HarmonyService implements HarmonyServiceInterface
{
    /**
     * @return array
     */
    public function getKeys(): array
    {
        return Key::all()->toArray();
    }

    public function isValidChord(string $chord): bool
    {
        $regex = '/\b(?:G,C,D|A,B,C|E,C,D)|(?:[ABCDEFG](?:#|b)?)(?:\/[ABCDEFG]b)?(?:(?:(?:maj|min|sus|add|aug|dim)(?:\d{0,2}(?:#\d{1,2}|sus\d)?)?)|(?:m\d{0,2}(?:(?:maj|add|#)\d{0,2})?)|(?:-?\d{0,2}(?:\([^)]*\)|#\d{1,2})?))(?!#\d{1,2})/';

        return preg_match($regex, $chord) === 1;
    }
}
