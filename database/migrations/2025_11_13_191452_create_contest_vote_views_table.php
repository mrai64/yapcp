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
        DB::statement("CREATE VIEW pcp_contest_votes_view AS
            SELECT
                COUNT(*),
                c.name_en AS 'contest_name',
                cs.name_en AS 'section_name',
                cv.vote,
                cv.contest_id,
                cv.section_id
            FROM
                pcp_contest_votes cv,
                pcp_contests c,
                pcp_contest_sections cs
            WHERE
                c.id = cv.contest_id 
                AND cs.id = cv.section_id
            GROUP BY
                cv.contest_id,
                cv.section_id,
                cv.vote
            ORDER BY
                5,
                6,
                4 DESC
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW pcp_contest_votes_view');
    }
};
