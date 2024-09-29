<?php

namespace Database\Factories;

use App\Models\Key;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class InvitationFactory extends Factory
{
    /**
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'email' => fake()->email,
            'token' => bin2hex(random_bytes(16))
        ];
    }
}
