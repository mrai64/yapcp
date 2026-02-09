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
        DB::statement("CREATE VIEW `pcp_organizations_view` AS select `org`.`name` AS `name`,`usr`.`last_name` AS `last_name`,`usr`.`first_name` AS `first_name`,`rol`.`role` AS `role`,`usr`.`email` AS `email`,`org`.`id` AS `organization_id`,`rol`.`id` AS `user_role_id`,`usr`.`user_id` AS `user_id` from ((`pcpdb`.`pcp_organizations` `org` join `pcpdb`.`pcp_user_roles` `rol`) join `pcpdb`.`pcp_user_contacts` `usr`) where ((`org`.`deleted_at` is null) and (`usr`.`deleted_at` is null) and (`org`.`deleted_at` is null) and (`org`.`id` = `rol`.`organization_id`) and (`rol`.`user_id` = `usr`.`user_id`)) order by `org`.`name`,`usr`.`last_name`,`usr`.`first_name`,`rol`.`role`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_organizations_view`");
    }
};
