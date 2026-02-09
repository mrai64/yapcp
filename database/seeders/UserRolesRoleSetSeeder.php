<?php

/**
 * auxiliary table
 * - for user_roles
 */

namespace Database\Seeders;

use App\Models\UserRolesRoleSet;
use Illuminate\Database\Seeder;

class UserRoleRoleSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserRolesRoleSet::factory()->create(['role' => 'chairman']);
        UserRolesRoleSet::factory()->create(['role' => 'juror']);
        UserRolesRoleSet::factory()->create(['role' => 'member']);
        UserRolesRoleSet::factory()->create(['role' => 'president']);
        UserRolesRoleSet::factory()->create(['role' => 'secretary']);
        UserRolesRoleSet::factory()->create(['role' => 'winner']);

    }
}
