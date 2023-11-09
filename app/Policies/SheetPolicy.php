<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\Sheet;
use App\Models\User;

class SheetPolicy
{
    /**
     * Determine whether the user can view any sheets.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the sheet.
     */
    public function view(User $user, Sheet $sheet): bool
    {
        return $user->id === $sheet->user_id;
    }

    /**
     * Determine whether the user can view the pdf of the sheet.
     */
    public function pdf(User $user, Sheet $sheet): bool
    {
        return $user->id === $sheet->user_id;
    }

    /**
     * Determine whether the user can view the playback of the sheet.
     */
    public function playback(User $user, Sheet $sheet): bool
    {
        return $user->id === $sheet->user_id;
    }

    /**
     * Determine whether the user can create sheets.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the sheet.
     */
    public function update(User $user, Sheet $sheet): bool
    {
        return $user->id === $sheet->user_id;
    }

    /**
     * Determine whether the user can delete the sheet.
     */
    public function delete(User $user, Sheet $sheet): bool
    {
        return $user->id === $sheet->user_id;
    }
}
