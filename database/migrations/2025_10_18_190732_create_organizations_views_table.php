<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE VIEW pcp_organizations_view AS
            SELECT
                org.name,
                usr.last_name,
                usr.first_name,
                rol.role,
                usr.email,
                org.id       AS organization_id,
                rol.id       AS user_role_id,
                usr.user_id  AS user_id
            FROM
                pcp_organizations org,
                pcp_user_roles    rol,
                pcp_user_contacts usr
            WHERE
                org.deleted_at     IS NULL
                AND usr.deleted_at IS NULL
                AND org.deleted_at IS NULL
                AND org.id = rol.organization_id 
                AND rol.user_id = usr.user_id
            ORDER BY
                1, 2, 3, 4
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW pcp_organizations_view');
    }
};
