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
        DB::statement("CREATE VIEW `pcp_works_view` AS select `u`.`country_id` AS `country_id`,`u`.`last_name` AS `last_name`,`u`.`first_name` AS `first_name`,`w`.`title_en` AS `title_en`,`w`.`id` AS `work_id`,`w`.`user_id` AS `user_id` from (`pcpdb`.`pcp_works` `w` join `pcpdb`.`pcp_user_contacts` `u`) where (`u`.`user_id` = `w`.`user_id`) order by `u`.`country_id`,`u`.`last_name`,`u`.`first_name`,`w`.`title_en`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_works_view`");
    }
};
