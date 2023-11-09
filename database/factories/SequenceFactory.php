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
            'position' => fake()->numberBetween(0, 100),
            'description' => fake()->text(80),
            'measures' => $this->fakeMeasures()
        ];
    }

    /**
     * @return array
     */
    private function fakeMeasures(): array
    {
        $measures = [];

        for ($i = 0; $i < fake()->randomElement([4, 8]); $i++) {
            $measures[] = [
                'chords' => implode('-', $this->fakeChords()),
                'time_signature' => '4/4'
            ];
        }

        return $measures;
    }

    /**
     * @return array
     */
    private function fakeChords(): array
    {
        $chords = [];

        for ($i = 0; $i < fake()->numberBetween(1, 4); $i++) {
            $chords[] = fake()->randomElement([
                'C', 'Dm', 'Em', 'F', 'G', 'Am',
                'C7', 'Cmaj7', 'Csus4', 'C7', 'C/A', 'C/F', 'C/G',
                'F7', 'Fmaj7', 'Fsus4', 'F7', 'F/A', 'F/C', 'F/G',
                'G7', 'Gmaj7', 'Gsus4', 'G7', 'G/A', 'G/F', 'G/C',
                'Am7', 'Dm7', 'Em7'
            ]);
        }

        return $chords;
    }
}
