<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->foreign('contest_id')->references('id')->on('contests');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('section_id')->references('id')->on('contest_sections');
            $table->foreign('user_id')->references('user_id')->on('user_contacts');
            $table->foreign('work_id')->references('id')->on('works');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->dropForeign('work_id');
            $table->dropForeign('user_id');
            $table->dropForeign('section_id');
            $table->dropForeign('country_id');
            $table->dropForeign('contest_id');
        });
    }
};
