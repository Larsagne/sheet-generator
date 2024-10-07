<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->invited_by;
    }

    public function accept(User $user, Invitation $invitation): bool
    {
        return $user->email === $invitation->email;
    }
}
