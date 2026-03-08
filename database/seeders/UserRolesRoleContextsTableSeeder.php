<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesRoleContextsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('user_roles_role_contexts')->delete();

        \DB::table('user_roles_role_contexts')->insert(array(
            0 =>
            array(
                'role' => 'admin',
                'context' => 'contests',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            1 =>
            array(
                'role' => 'admin',
                'context' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:02',
                'deleted_at' => null,
            ),
            2 =>
            array(
                'role' => 'admin',
                'context' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            3 =>
            array(
                'role' => 'chairman',
                'context' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:10',
                'deleted_at' => null,
            ),
            4 =>
            array(
                'role' => 'chairman',
                'context' => 'organizations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            5 =>
            array(
                'role' => 'chairman',
                'context' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            6 =>
            array(
                'role' => 'juror',
                'context' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:23',
                'deleted_at' => null,
            ),
            7 =>
            array(
                'role' => 'juror',
                'context' => 'organizations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            8 =>
            array(
                'role' => 'juror',
                'context' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            9 =>
            array(
                'role' => 'member',
                'context' => 'contests',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            10 =>
            array(
                'role' => 'member',
                'context' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:34',
                'deleted_at' => null,
            ),
            11 =>
            array(
                'role' => 'member',
                'context' => 'federations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:42',
                'deleted_at' => null,
            ),
            12 =>
            array(
                'role' => 'president',
                'context' => 'contests',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            13 =>
            array(
                'role' => 'president',
                'context' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:09:53',
                'deleted_at' => null,
            ),
            14 =>
            array(
                'role' => 'president',
                'context' => 'federations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:00',
                'deleted_at' => null,
            ),
            15 =>
            array(
                'role' => 'secretary',
                'context' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:07',
                'deleted_at' => null,
            ),
            16 =>
            array(
                'role' => 'secretary',
                'context' => 'organizations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:12',
                'deleted_at' => null,
            ),
            17 =>
            array(
                'role' => 'secretary',
                'context' => 'federations',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:17',
                'deleted_at' => null,
            ),
            18 =>
            array(
                'role' => 'winner',
                'context' => 'contests',
                'green' => 1,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:10:24',
                'deleted_at' => null,
            ),
            19 =>
            array(
                'role' => 'winner',
                'context' => 'organizations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
            20 =>
            array(
                'role' => 'winner',
                'context' => 'federations',
                'green' => 0,
                'created_at' => '2026-03-08 00:07:59',
                'updated_at' => '2026-03-08 00:07:59',
                'deleted_at' => null,
            ),
        ));
    }
}
