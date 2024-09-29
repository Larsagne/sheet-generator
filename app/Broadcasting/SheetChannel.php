<?php

namespace App\Broadcasting;

use App\Models\Sheet;
use App\Models\User;

class SheetChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, Sheet $sheet): array|bool
    {
        return $user->id === $sheet->user_id;
    }
}
