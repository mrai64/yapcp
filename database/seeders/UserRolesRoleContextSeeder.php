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

        // Standard fill with all 'green' false
        // // pivot table with N x M rows
        // $rolesSet = UserRolesRoleSet::all();
        // // ds($rolesSet);
        // $contextSet = UserRolesContextSet::all();
        // // ds($contextSet);
        // 
        // foreach ($rolesSet as $role) {
        //     foreach ($contextSet as $context) {
        //         // ds('role: ' . $role->role . ' context:' . $context->context_type);
        //         UserRolesRoleContext::factory()->create([
        //             'role' => $role->role,
        //             'context' => $context->context_type,
        //         ]);
        //     }
        // }

        // real start values
        // \DB::table('user_roles_role_contexts')->delete();

        \DB::table('user_roles_role_contexts')->insert(array(
            0 =>
            array(
                'role' => 'admin',
                'context_type' => 'contests',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            1 =>
            array(
                'role' => 'admin',
                'context_type' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:02',
                'deleted_at' => null,
            ),
            2 =>
            array(
                'role' => 'admin',
                'context_type' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            3 =>
            array(
                'role' => 'chairman',
                'context_type' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:10',
                'deleted_at' => null,
            ),
            4 =>
            array(
                'role' => 'chairman',
                'context_type' => 'organizations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            5 =>
            array(
                'role' => 'chairman',
                'context_type' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            6 =>
            array(
                'role' => 'juror',
                'context_type' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:23',
                'deleted_at' => null,
            ),
            7 =>
            array(
                'role' => 'juror',
                'context_type' => 'organizations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            8 =>
            array(
                'role' => 'juror',
                'context_type' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            9 =>
            array(
                'role' => 'member',
                'context_type' => 'contests',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            10 =>
            array(
                'role' => 'member',
                'context_type' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:34',
                'deleted_at' => null,
            ),
            11 =>
            array(
                'role' => 'member',
                'context_type' => 'federations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:42',
                'deleted_at' => null,
            ),
            12 =>
            array(
                'role' => 'president',
                'context_type' => 'contests',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            13 =>
            array(
                'role' => 'president',
                'context_type' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:53',
                'deleted_at' => null,
            ),
            14 =>
            array(
                'role' => 'president',
                'context_type' => 'federations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:00',
                'deleted_at' => null,
            ),
            15 =>
            array(
                'role' => 'secretary',
                'context_type' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:07',
                'deleted_at' => null,
            ),
            16 =>
            array(
                'role' => 'secretary',
                'context_type' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:12',
                'deleted_at' => null,
            ),
            17 =>
            array(
                'role' => 'secretary',
                'context_type' => 'federations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:17',
                'deleted_at' => null,
            ),
            18 =>
            array(
                'role' => 'winner',
                'context_type' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:24',
                'deleted_at' => null,
            ),
            19 =>
            array(
                'role' => 'winner',
                'context_type' => 'organizations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            20 =>
            array(
                'role' => 'winner',
                'context_type' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
        ));

    }
}
