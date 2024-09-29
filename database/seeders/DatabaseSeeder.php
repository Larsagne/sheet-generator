<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            User::factory()->create([
                'name' => 'Lars Fröhle',
                'email' => 'larsfroehle@gmx.de',
            ]),
            User::factory()->create([
                'name' => 'Micha Gerdes',
                'email' => 'michagerdes@google.de',
            ])
        ];

        /** @var Band $band */
        $band = Band::factory()->create([
            'name' => 'Reallive',
            'founder_id' => $users[0]->id
        ]);
        $band->members()->attach($users[1]->id);

        Band::factory()->create([
            'name' => 'Funkstelle',
            'founder_id' => $users[1]->id
        ]);

        Artisan::call('sheets:migrate');
    }
}
