<?php

/**
 * auxiliary table
 * - for user_roles
 */

namespace Database\Seeders;

use App\Models\UserRoleRoleSet;
use Illuminate\Database\Seeder;

class UserRoleRoleSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserRoleRoleSet::factory()->create(['role' => 'chairman']);
        UserRoleRoleSet::factory()->create(['role' => 'juror']);
        UserRoleRoleSet::factory()->create(['role' => 'member']);
        UserRoleRoleSet::factory()->create(['role' => 'president']);
        UserRoleRoleSet::factory()->create(['role' => 'secretary']);
        UserRoleRoleSet::factory()->create(['role' => 'winner']);

    }
}
