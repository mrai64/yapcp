<?php
/**
 * 
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
        DB::statement("CREATE VIEW pcp_contest_juries_view AS
            SELECT
                con.name_en         AS contest_name_en,
                sec.name_en         AS section_name_en,
                user.last_name      AS juror_last_name,
                user.first_name     AS juror_first_name,
                con.id              AS contest_id,
                jur.section_id      ,
                jur.id              AS juror_id,
                jur.user_contact_id AS user_id
            FROM
                pcp_contest_juries    jur,
                pcp_contest_sections  sec,
                pcp_contests          con,
                pcp_user_contacts     user
            WHERE
                    con.deleted_at IS NULL
                AND sec.deleted_at IS NULL
                AND jur.deleted_at IS NULL
                AND jur.section_id  = sec.id 
                AND sec.contest_id  = con.id 
                AND user_contact_id = user.user_id

            ORDER BY 1,2,3,4
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW pcp_contest_juries_view");
    }
};
