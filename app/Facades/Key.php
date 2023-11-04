<?php declare(strict_types=1);

namespace App\Facades;

use App\Contracts\Services\KeyServiceInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static getKeys()
 */
class Key extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return KeyServiceInterface::class;
    }
}
