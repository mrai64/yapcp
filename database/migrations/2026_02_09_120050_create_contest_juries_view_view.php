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
        DB::statement("CREATE VIEW `pcp_contest_juries_view` AS select `con`.`name_en` AS `contest_name_en`,`sec`.`name_en` AS `section_name_en`,`user`.`last_name` AS `juror_last_name`,`user`.`first_name` AS `juror_first_name`,`con`.`day_3_jury_opening` AS `day_jury_works_opening`,`con`.`day_4_jury_closing` AS `day_jury_works_closing`,`con`.`id` AS `contest_id`,`jur`.`section_id` AS `section_id`,`jur`.`id` AS `juror_id`,`jur`.`user_contact_id` AS `user_id` from (((`pcpdb`.`pcp_contest_juries` `jur` join `pcpdb`.`pcp_contest_sections` `sec`) join `pcpdb`.`pcp_contests` `con`) join `pcpdb`.`pcp_user_contacts` `user`) where ((`con`.`deleted_at` is null) and (`sec`.`deleted_at` is null) and (`jur`.`deleted_at` is null) and (`jur`.`section_id` = `sec`.`id`) and (`sec`.`contest_id` = `con`.`id`) and (`jur`.`user_contact_id` = `user`.`user_id`)) order by `con`.`day_3_jury_opening`,`con`.`name_en`,`sec`.`name_en`,`user`.`last_name`,`user`.`first_name`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_contest_juries_view`");
    }
};
