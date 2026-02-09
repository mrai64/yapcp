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
        DB::statement("CREATE VIEW `pcp_user_roles_view` AS select `ur`.`id` AS `id`,`uc`.`country_id` AS `uc_country_id`,`uc`.`last_name` AS `uc_last_name`,`uc`.`first_name` AS `uc_first_name`,`uc`.`email` AS `uc_email`,`ur`.`role` AS `uc_role`,'org' AS `roled`,`org`.`name` AS `uc_roled`,`ur`.`organization_id` AS `uc_roled_id`,`ur`.`user_id` AS `ur_user_id` from ((`pcpdb`.`pcp_user_roles` `ur` join `pcpdb`.`pcp_user_contacts` `uc`) join `pcpdb`.`pcp_organizations` `org`) where ((`ur`.`user_id` = `uc`.`user_id`) and (`ur`.`organization_id` = `org`.`id`) and (`ur`.`deleted_at` is null) and (`ur`.`organization_id` is not null)) union select `ur`.`id` AS `id`,`uc`.`country_id` AS `uc_country_id`,`uc`.`last_name` AS `uc_last_name`,`uc`.`first_name` AS `uc_first_name`,`uc`.`email` AS `uc_email`,`ur`.`role` AS `uc_role`,'fed' AS `roled`,`fed`.`name_en` AS `uc_roled`,`ur`.`federation_id` AS `uc_roled_id`,`ur`.`user_id` AS `ur_user_id` from ((`pcpdb`.`pcp_user_roles` `ur` join `pcpdb`.`pcp_user_contacts` `uc`) join `pcpdb`.`pcp_federations` `fed`) where ((`ur`.`user_id` = `uc`.`user_id`) and (`ur`.`federation_id` = `fed`.`id`) and (`ur`.`deleted_at` is null) and (`ur`.`federation_id` is not null)) union select `ur`.`id` AS `id`,`uc`.`country_id` AS `uc_country_id`,`uc`.`last_name` AS `uc_last_name`,`uc`.`first_name` AS `uc_first_name`,`uc`.`email` AS `uc_email`,`ur`.`role` AS `uc_role`,'cnt' AS `roled`,`cnt`.`name_en` AS `uc_roled`,`ur`.`contest_id` AS `uc_roled_id`,`ur`.`user_id` AS `ur_user_id` from ((`pcpdb`.`pcp_user_roles` `ur` join `pcpdb`.`pcp_user_contacts` `uc`) join `pcpdb`.`pcp_contests` `cnt`) where ((`ur`.`user_id` = `uc`.`user_id`) and (`ur`.`contest_id` = `cnt`.`id`) and (`ur`.`deleted_at` is null) and (`ur`.`contest_id` is not null)) order by `uc_last_name`,`uc_first_name`,`uc_role`,`roled`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_user_roles_view`");
    }
};
