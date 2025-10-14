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
        // Schema::create('contest_participants_views', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        
        DB::statement("
        CREATE VIEW pcp_contest_participant_view AS
        SELECT
            c.name_en                AS contest_name,
            u.country_id,
            u.last_name,
            u.first_name,
            p.fee_payment_completed,
            p.updated_at,
            p.user_id,
            p.contest_id,
            p.id
        FROM
            pcp_contest_participants p,
            pcp_contests             c,
            pcp_user_contacts        u
        WHERE 
                p.contest_id  = c.id
            and p.user_id     = u.user_id
            and p.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null

        ORDER BY 1, 2, 3, 4, 6
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('contest_participants_views');
        DB::statement("DROP VIEW pcp_contest_participant_view");

    }
};
