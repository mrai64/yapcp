<?php

/**
 * THAT's NOT A TABLE BUT A SQL VIEW
 * see also
 * - https://www.reddit.com/r/laravel/comments/o0ban2/using_database_views_in_laravel/
 * - https://medium.com/@kevinsada05/using-sql-views-in-laravel-examples-and-best-practices-1b00cbcc8494
 * - https://laravel.com/docs/12.x/eloquent#table-names
 *
 * WARNING: we must use pcp_ table prefix explicit.
 *
 * 2025-10-16 federations.name col become name_en
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW pcp_user_roles_view');
        // exceeding blanks to make more readable
        DB::statement("
            CREATE VIEW pcp_user_roles_view AS
            SELECT
                ur.id              AS id,
                uc.country_id      AS uc_country_id,
                uc.last_name       AS uc_last_name,
                uc.first_name      AS uc_first_name,
                uc.email           AS uc_email,
                ur.role            AS uc_role,
                'org'              AS roled,
                org.name           AS uc_roled,
                ur.organization_id AS uc_roled_id,
                ur.user_id         AS ur_user_id
            FROM
                `pcp_user_roles`  ur,
                pcp_user_contacts uc,
                pcp_organizations org
            WHERE
                    ur.user_id         = uc.user_id
                AND ur.organization_id = org.id
                AND ur.deleted_at      IS NULL
                AND ur.organization_id IS NOT NULL
            UNION
            SELECT
                ur.id              AS id,
                uc.country_id      AS uc_country_id,
                uc.last_name       AS uc_last_name,
                uc.first_name      AS uc_first_name,
                uc.email           AS uc_email,
                ur.role            AS uc_role,
                'fed'              AS roled,
                fed.name_en        AS uc_roled,
                ur.federation_id   AS uc_roled_id,
                ur.user_id         AS ur_user_id
            FROM
                `pcp_user_roles`  ur,
                pcp_user_contacts uc,
                pcp_federations   fed
            WHERE
                    ur.user_id       = uc.user_id
                AND ur.federation_id = fed.id
                AND ur.deleted_at    IS NULL
                AND ur.federation_id IS NOT NULL
            UNION
            SELECT
                ur.id              AS id,
                uc.country_id      AS uc_country_id,
                uc.last_name       AS uc_last_name,
                uc.first_name      AS uc_first_name,
                uc.email           AS uc_email,
                ur.role            AS uc_role,
                'cnt'              AS roled,
                cnt.name_en        AS uc_roled,
                ur.contest_id      AS uc_roled_id,
                ur.user_id         AS ur_user_id
            FROM
                `pcp_user_roles`  ur,
                pcp_user_contacts uc,
                pcp_contests      cnt
            WHERE
                    ur.user_id    = uc.user_id
                AND ur.contest_id = cnt.id
                AND ur.deleted_at IS NULL
                AND ur.contest_id IS NOT NULL

            ORDER BY 3,4,6,7
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('user_roles_views');
        DB::statement('DROP VIEW pcp_user_roles_view');
    }
};
