<?php

namespace Database\Factories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class SequenceFactory extends Factory
{
    /**
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'quantity' => random_int(1, 4),
            'name' => fake()->randomElement(['Intro', 'Verse', 'Pre-Chorus', 'Chorus', 'Bridge', 'Instrumental', 'Outro']),
            'position' => fake()->numberBetween(0, 100),
            'description' => fake()->text(80),
            'lyrics' => fake()->text(400)
        ];
    }
}
