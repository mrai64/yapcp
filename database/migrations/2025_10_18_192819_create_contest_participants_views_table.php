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
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::statement("DROP VIEW pcp_contest_participants_view");

        DB::statement("
            CREATE VIEW pcp_contest_participants_view AS
            SELECT
                con.name_en                AS contest_name,
                usr.country_id,
                usr.last_name,
                usr.first_name,
                par.fee_payment_completed,
                par.updated_at,
                par.user_id,
                par.contest_id,
                par.id
            FROM
                pcp_contest_participants par,
                pcp_contests             con,
                pcp_user_contacts        usr
            WHERE 
                    par.contest_id  = con.id
                and par.user_id     = usr.user_id
                and par.deleted_at is null
                and con.deleted_at is null
                and usr.deleted_at is null

            ORDER BY 1, 2, 3, 4, 6
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW pcp_contest_participants_view");

    }
};
