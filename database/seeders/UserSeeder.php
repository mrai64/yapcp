<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::factory()->create([
            'country_iso3' => 'ITA',
            'name' => 'Rainato, Massimo',
            'email' => 'massimo.rainato@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('massimo.rainato@gmail.com'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()->create([
            'country_iso3' => 'ITA',
            'name' => 'Rainato, Massimo',
            'email' => 'maxrainato@libero.it',
            'email_verified_at' => now(),
            'password' => Hash::make('maxrainato@libero.it'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
