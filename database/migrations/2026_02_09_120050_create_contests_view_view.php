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
        DB::statement("CREATE VIEW `pcp_contests_view` AS select `con`.`name_en` AS `contest_name`,`con`.`name_local` AS `contest_local_name`,`con`.`day_2_closing` AS `day_2_closing`,`org`.`name` AS `organization_name`,`uco`.`first_name` AS `first_name`,`uco`.`last_name` AS `last_name`,`uro`.`role` AS `role`,`con`.`id` AS `contest_id`,`org`.`id` AS `organization_id`,`uco`.`user_id` AS `user_id`,`uro`.`id` AS `user_role_id` from (((`pcpdb`.`pcp_contests` `con` join `pcpdb`.`pcp_organizations` `org`) join `pcpdb`.`pcp_user_roles` `uro`) join `pcpdb`.`pcp_user_contacts` `uco`) where ((`con`.`deleted_at` is null) and (`con`.`organization_id` = `org`.`id`) and (`con`.`organization_id` = `uro`.`organization_id`) and (`uro`.`user_id` = `uco`.`user_id`)) order by `con`.`day_2_closing`,`uro`.`role`,`uco`.`last_name`,`uco`.`first_name`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_contests_view`");
    }
};
