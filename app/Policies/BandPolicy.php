<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\Band;
use App\Models\User;

class BandPolicy
{
    /**
     * Determine whether the user can view any bands.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the band.
     */
    public function view(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    /**
     * Determine whether the user can view the pdf of the band.
     */
    public function pdf(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    /**
     * Determine whether the user can view the playback of the band.
     */
    public function playback(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    /**
     * Determine whether the user can create bands.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the band.
     */
    public function update(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    /**
     * Determine whether the user can delete the band.
     */
    public function delete(User $user, Band $band): bool
    {
        return $user->id === $band->founder->id;
    }

    private function isMember(User $user, Band $band)
    {
        return $band->members()->where('member_id', $user->id)->exists();
    }
}
