<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\Access;
use App\Models\Band;
use App\Models\Sheet;
use App\Models\User;

class SheetPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, Sheet $sheet): bool
    {
        return $this->hasSheetAccess($user, $sheet);
    }

    public function pdf(User $user, Sheet $sheet): bool
    {
        return $this->hasSheetAccess($user, $sheet);
    }

    public function playback(User $user, Sheet $sheet): bool
    {
        return $this->hasSheetAccess($user, $sheet);
    }

    public function create(): bool
    {
        return true;
    }

    public function update(User $user, Sheet $sheet): bool
    {
        return $this->hasSheetAccess($user, $sheet);
    }

    public function delete(User $user, Sheet $sheet): bool
    {
        return $this->isCreator($user, $sheet);
    }

    private function hasSheetAccess(User $user, Sheet $sheet): bool
    {
        $bandHasAccess = Access::where('accessable_type', Band::class)
            ->whereIn('accessable_id', $user->bands()->select(['id']))
            ->where('resourceable_id', $sheet->id)
            ->where('resourceable_type', Sheet::class)
            ->exists();

        $userHasAccess = Access::where('accessable_type', User::class)
            ->where('accessable_id', $user->id)
            ->where('resourceable_id', $sheet->id)
            ->where('resourceable_type', Sheet::class)
            ->exists();

        return
            $this->isCreator($user, $sheet) || $bandHasAccess || $userHasAccess;
    }

    private function isCreator(User $user, Sheet $sheet)
    {
        return $user->id === $sheet->user_id;
    }
}
