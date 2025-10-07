<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a specific user (Test User)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call other seeders
        $this->call([
            ProductSeeder::class,
            LocalProductSeeder::class,
            CountriesTableSeeder::class,  // Register Countries Seeder
            StatesSeeder::class,          // Register States Seeder
            CitiesTableSeeder::class,     // Register Cities Seeder
        ]);
    }
}
