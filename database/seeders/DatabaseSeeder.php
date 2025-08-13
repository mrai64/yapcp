<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CountrySeeder::run();
        
        // User::factory(10)->create();
        // 
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'country_iso3' => 'ITA',
        // ]);
        UserSeeder::run();
    }
}
