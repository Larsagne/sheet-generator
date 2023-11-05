<?php declare(strict_types=1);

namespace App\Contracts\Services;

interface HarmonyServiceInterface
{
    public function getKeys(): array;

    public function isValidChord(string $chord): bool;
}
