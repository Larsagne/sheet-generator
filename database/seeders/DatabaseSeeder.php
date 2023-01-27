<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

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
    }
}
