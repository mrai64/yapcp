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
        DB::statement("CREATE VIEW `pcp_contest_works_view` AS select `c`.`name_en` AS `contest_name`,`s`.`name_en` AS `section_name`,`u`.`country_id` AS `country_id`,`u`.`last_name` AS `last_name`,`u`.`first_name` AS `first_name`,`cw`.`portfolio_sequence` AS `seq`,`w`.`title_en` AS `title_en`,`w`.`reference_year` AS `reference_year`,`w`.`work_file` AS `work_file`,`cw`.`contest_id` AS `contest_id`,`cw`.`section_id` AS `section_id`,`cw`.`user_id` AS `user_id`,`cw`.`work_id` AS `work_id`,`cw`.`id` AS `contest_work_id` from ((((`pcpdb`.`pcp_contest_works` `cw` join `pcpdb`.`pcp_contests` `c`) join `pcpdb`.`pcp_contest_sections` `s`) join `pcpdb`.`pcp_user_contacts` `u`) join `pcpdb`.`pcp_works` `w`) where ((`cw`.`contest_id` = `c`.`id`) and (`cw`.`section_id` = `s`.`id`) and (`cw`.`user_id` = `u`.`user_id`) and (`cw`.`work_id` = `w`.`id`) and (`cw`.`deleted_at` is null)) order by `c`.`name_en`,`s`.`name_en`,`u`.`country_id`,`u`.`last_name`,`u`.`first_name`,`cw`.`portfolio_sequence`,`w`.`title_en`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_contest_works_view`");
    }
};
