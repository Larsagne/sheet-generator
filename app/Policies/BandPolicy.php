<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\Band;
use App\Models\User;

class BandPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    public function pdf(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    public function playback(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Band $band): bool
    {
        return $this->isMember($user, $band);
    }

    public function delete(User $user, Band $band): bool
    {
        return $user->id === $band->founder->id;
    }

    private function isMember(User $user, Band $band)
    {
        return $band->members()->where('member_id', $user->id)->exists();
    }
}
