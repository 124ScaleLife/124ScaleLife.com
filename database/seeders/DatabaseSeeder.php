<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'David',
            'last_name' => 'Rodriguez',
            'username' => 'enyutech',
            'display_name' => 'David Rodriguez',
            'role' => User::SUPER_ADMIN,
            'email' => 'david@enyutech.com',
            'password' => bcrypt('password')
        ]);

        User::factory(9)->create();
    }
}
