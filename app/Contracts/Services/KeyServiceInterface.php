<?php declare(strict_types=1);

namespace App\Contracts\Services;

interface KeyServiceInterface
{
    public function getKeys(): array;
}
