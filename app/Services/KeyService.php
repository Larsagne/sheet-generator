<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\KeyServiceInterface;
use App\Models\Key;

class KeyService implements KeyServiceInterface
{
    /**
     * @return array
     */
    public function getKeys(): array
    {
        return Key::all()->toArray();
    }
}
