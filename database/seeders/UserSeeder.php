<?php

/**
 * users
 * - relationship 1:1 w/user_contacts
 * - relationship 1:N w/user_roles
 * - relationship 1:N w/works (may become user_works)
 * - relationship 1:N w/contest_participants
 * - relationship 1:N w/contest_works
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n  Create 25 users";
        User::factory()->create([
            'name' => 'Rainato, Massimo',
            'email' => 'massimo.rainato@athesis77.it',
            'email_verified_at' => now(),
            'password' => Hash::make('massimo.rainato@athesis77.it'),
            'remember_token' => Str::random(10),
        ]);
        User::factory()->count(24)->create();
        echo "\n  Create 25 more users";
        User::factory()->count(25)->create();
        echo "\n  Create 25 more users";
        User::factory()->count(25)->create();
        echo "\n  Create 25 more users";
        User::factory()->count(25)->create();
        echo "\n  Done\n";
    }
}
