<?php

namespace Database\Seeders;

use App\Models\UserRolesContextSet;
use App\Models\UserRolesRoleContext;
use App\Models\UserRolesRoleSet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserRolesRoleContextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // empty table
        Schema::disableForeignKeyConstraints();
        UserRolesRoleContext::truncate();
        Schema::enableForeignKeyConstraints();

        // pivot table with N x M rows
        $rolesSet = UserRolesRoleSet::all();
        // ds($rolesSet);
        $contextSet = UserRolesContextSet::all();
        // ds($contextSet);

        foreach ($rolesSet as $role) {
            foreach ($contextSet as $context) {
                // ds('role: ' . $role->role . ' context:' . $context->context_type);
                UserRolesRoleContext::factory()->create([
                    'role' => $role->role,
                    'context' => $context->context_type,
                ]);
            }
        }
    }
}
