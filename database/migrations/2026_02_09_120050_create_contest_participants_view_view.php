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
        DB::statement("CREATE VIEW `pcp_contest_participants_view` AS select `con`.`name_en` AS `contest_name`,`usr`.`country_id` AS `country_id`,`usr`.`last_name` AS `last_name`,`usr`.`first_name` AS `first_name`,`par`.`fee_payment_completed` AS `fee_payment_completed`,`par`.`updated_at` AS `updated_at`,`par`.`user_id` AS `user_id`,`par`.`contest_id` AS `contest_id`,`par`.`id` AS `id` from ((`pcpdb`.`pcp_contest_participants` `par` join `pcpdb`.`pcp_contests` `con`) join `pcpdb`.`pcp_user_contacts` `usr`) where ((`par`.`contest_id` = `con`.`id`) and (`par`.`user_id` = `usr`.`user_id`) and (`par`.`deleted_at` is null) and (`con`.`deleted_at` is null) and (`usr`.`deleted_at` is null)) order by `con`.`name_en`,`usr`.`country_id`,`usr`.`last_name`,`usr`.`first_name`,`par`.`updated_at`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `pcp_contest_participants_view`");
    }
};
