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

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
    }
}
