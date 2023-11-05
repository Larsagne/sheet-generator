<?php declare(strict_types=1);

namespace App\Facades;

use App\Contracts\Services\HarmonyServiceInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static getKeys()
 * @method static isValidChord(string $chord)
 */
class Harmony extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return HarmonyServiceInterface::class;
    }
}
