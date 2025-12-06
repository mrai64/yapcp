<?php

/**
 * That' not a table but a table VIEW
 *
 * for: contests
 * need use pcp_ prefix
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
            CREATE VIEW pcp_contests_view AS 
            SELECT
                con.name_en AS contest_name,
                con.name_local AS contest_local_name,
                con.day_2_closing,
                org.name AS organization_name,
                uco.first_name,
                uco.last_name,
                uro.role,
                con.id as contest_id,
                org.id as organization_id,
                uco.user_id as user_id,
                uro.id as user_role_id
            FROM
                pcp_contests con,
                pcp_organizations org,
                pcp_user_roles uro,
                pcp_user_contacts uco
            WHERE
                con.deleted_at IS NULL
                AND con.organization_id = org.id 
                AND con.organization_id = uro.organization_id 
                AND uro.user_id = uco.user_id
                ORDER BY 3,7,6,5
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW pcp_contests_view');
    }
};
