<?php

namespace Database\Seeders;

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
         User::factory()->create([
             'name' => 'Lars Fröhle',
             'email' => 'larsfroehle@gmx.de',
         ]);
        User::factory()->create([
            'name' => 'Micha Gerdes',
            'email' => 'michagerdes@gmx.de',
        ]);

        Artisan::call('sheets:migrate');
    }
}
