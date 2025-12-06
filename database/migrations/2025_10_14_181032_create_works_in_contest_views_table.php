<?php

/**
 * THAT's NOT A TABLE BUT A SQL VIEW
 * see also
 * - https://www.reddit.com/r/laravel/comments/o0ban2/using_database_views_in_laravel/
 * - https://medium.com/@kevinsada05/using-sql-views-in-laravel-examples-and-best-practices-1b00cbcc8494
 * - https://laravel.com/docs/12.x/eloquent#table-names
 *
 * WARNING: we must use pcp_ table prefix explicit.
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
        CREATE VIEW pcp_contest_works_view AS
        SELECT
            c.name_en AS contest_name,
            s.name_en AS section_name,
            u.country_id,
            u.last_name,
            u.first_name,
            w.title_en,
            w.reference_year,
            w.work_file,
            cw.contest_id,
            cw.section_id,
            cw.user_id,
            cw.work_id,
            cw.id AS contest_work_id
        FROM
            pcp_contest_works    cw,
            pcp_contests         c,
            pcp_contest_sections s,
            pcp_user_contacts    u,
            pcp_works            w
        WHERE
            cw.contest_id     = c.id 
            AND cw.section_id = s.id 
            AND cw.user_id    = u.user_id 
            AND cw.work_id    = w.id 
            AND cw.deleted_at IS NULL

        ORDER BY 1, 2,
            3,
            4,
            5,
            6
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW pcp_contest_works_view');
    }
};
