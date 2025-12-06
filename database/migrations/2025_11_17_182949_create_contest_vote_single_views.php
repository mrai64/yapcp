<?php

/**
 * View for all contest all section all vote
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
        DB::statement('CREATE VIEW pcp_contest_vote_single_view AS
            SELECT
                c.name_en AS contest_name,
                cs.code,
                cs.name_en AS section_name,
                cv.vote,
                w.title_en,
                w.work_file,
                uc.country_id,
                uc.last_name,
                uc.first_name,
                cv.contest_id,
                cv.section_id,
                cv.work_id,
                cv.juror_user_id,
                uc.user_id
            FROM
                pcp_contest_votes cv,
                pcp_contests c,
                pcp_contest_sections cs,
                pcp_works w,
                pcp_user_contacts uc
            where cv.contest_id = c.id 
            and cv.section_id = cs.id
            and cv.work_id = w.id
            and w.user_id = uc.user_id
            ORDER BY
                1,
                3,
                cv.vote DESC,
                7,
                8,
                9
        ');
        DB::statement("CREATE VIEW pcp_contest_vote_group1_view AS
            SELECT
                COUNT(*) AS vote_count,
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
        DB::statement('DROP VIEW pcp_contest_vote_group1_view');
        DB::statement('DROP VIEW pcp_contest_vote_single_view');
    }
};
