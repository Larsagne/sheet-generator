<?php

namespace Database\Factories;

use App\Models\Key;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class SheetFactory extends Factory
{
    /**
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'title' => ucwords(sprintf('%s %s', fake()->word, fake()->word)),
            'description' => fake()->sentence(12),
            'artist' => fake()->name,
            'key' => Key::inRandomOrder()->first(),
            'duration' => fake()->numberBetween(140, 270),
            'tempo' => fake()->numberBetween(65, 160),
            'time_signature' => '4/4',
        ];
    }
}
