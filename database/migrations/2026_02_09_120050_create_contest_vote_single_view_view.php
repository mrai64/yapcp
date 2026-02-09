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
        DB::statement("CREATE VIEW `pcp_contest_vote_single_view` AS select `c`.`name_en` AS `contest_name`,`cs`.`code` AS `code`,`cs`.`name_en` AS `section_name`,`cv`.`vote` AS `vote`,`w`.`title_en` AS `title_en`,`w`.`work_file` AS `work_file`,`uc`.`country_id` AS `country_id`,`uc`.`last_name` AS `last_name`,`uc`.`first_name` AS `first_name`,`cv`.`contest_id` AS `contest_id`,`cv`.`section_id` AS `section_id`,`cv`.`work_id` AS `work_id`,`cv`.`juror_user_id` AS `juror_user_id`,`uc`.`user_id` AS `user_id` from ((((`pcpdb`.`pcp_contest_votes` `cv` join `pcpdb`.`pcp_contests` `c`) join `pcpdb`.`pcp_contest_sections` `cs`) join `pcpdb`.`pcp_works` `w`) join `pcpdb`.`pcp_user_contacts` `uc`) where ((`cv`.`contest_id` = `c`.`id`) and (`cv`.`section_id` = `cs`.`id`) and (`cv`.`work_id` = `w`.`id`) and (`w`.`user_id` = `uc`.`user_id`)) order by `c`.`name_en`,`cs`.`name_en`,`cv`.`vote` desc,`uc`.`country_id`,`uc`.`last_name`,`uc`.`first_name`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_contest_vote_single_view`");
    }
};
