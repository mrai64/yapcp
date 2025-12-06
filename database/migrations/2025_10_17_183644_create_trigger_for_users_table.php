<?php

use Illuminate\Database\Migrations\Migration;

// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('trigger_for_users', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        DB::unprepared("CREATE TRIGGER `user_contacts_ins_trigger` AFTER INSERT ON `pcp_users` FOR EACH ROW INSERT INTO `pcp_user_contacts` ( `user_id`, `first_name`, `last_name`, `email`    , `country_id` ) VALUES ( NEW.id,  NEW.name,   NEW.name,  NEW.email, '')");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('trigger_for_users');
        DB::unprepared('DROP TRIGGER ');
    }
};
