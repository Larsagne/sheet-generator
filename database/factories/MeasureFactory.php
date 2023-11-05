<?php

namespace Database\Factories;

use App\Models\Key;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class MeasureFactory extends Factory
{
    /**
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'chords'
        ];
    }

    private function getChords()
    {
        $chords = [];


        return implode('-', $chords);
    }
}
