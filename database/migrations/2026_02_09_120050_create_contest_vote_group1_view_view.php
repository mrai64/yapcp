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
        DB::statement("CREATE VIEW `pcp_contest_vote_group1_view` AS select count(0) AS `vote_count`,`c`.`name_en` AS `contest_name`,`cs`.`name_en` AS `section_name`,`cv`.`vote` AS `vote`,`cv`.`contest_id` AS `contest_id`,`cv`.`section_id` AS `section_id` from ((`pcpdb`.`pcp_contest_votes` `cv` join `pcpdb`.`pcp_contests` `c`) join `pcpdb`.`pcp_contest_sections` `cs`) where ((`c`.`id` = `cv`.`contest_id`) and (`cs`.`id` = `cv`.`section_id`)) group by `cv`.`contest_id`,`cv`.`section_id`,`cv`.`vote` order by `cv`.`contest_id`,`cv`.`section_id`,`cv`.`vote` desc");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_contest_vote_group1_view`");
    }
};
