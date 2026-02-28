<?php

/**
 * auxiliary table
 * - for user_roles
 */

namespace Database\Seeders;

use App\Models\UserRolesRoleSet;
use Illuminate\Database\Seeder;

class UserRolesRoleSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserRolesRoleSet::factory()->create(['role' => 'admin']); //     system
        UserRolesRoleSet::factory()->create(['role' => 'chairman']); //  contest
        UserRolesRoleSet::factory()->create(['role' => 'juror']); //     contest
        UserRolesRoleSet::factory()->create(['role' => 'member']); //    organization
        UserRolesRoleSet::factory()->create(['role' => 'president']); // organization
        UserRolesRoleSet::factory()->create(['role' => 'secretary']); // organization
        UserRolesRoleSet::factory()->create(['role' => 'winner']); //    contest

    }
}
