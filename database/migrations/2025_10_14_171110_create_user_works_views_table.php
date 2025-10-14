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
        // Schema::create('user_works_views', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        DB::statement("
        CREATE VIEW pcp_user_works_view AS
        SELECT
            u.country_id,
            u.last_name,
            u.first_name,
            w.title_en,
            w.id           as work_id,
            w.user_id
        FROM
            pcp_works         w,
            pcp_user_contacts u
        WHERE
            u.user_id = w.user_id

        ORDER BY
            1,
            2,
            3,
            4");        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('user_works_views');
        DB::statement("DROP VIEW pcp_user_works_view");
    }
};
