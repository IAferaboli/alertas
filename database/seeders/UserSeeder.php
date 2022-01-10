<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Nicolás Rotili',
            'email' => 'rotilinicolas@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Administrador');

        // User::factory(90)->create();
    }
}
