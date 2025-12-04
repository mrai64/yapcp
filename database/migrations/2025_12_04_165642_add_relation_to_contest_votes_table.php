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
        Schema::table('contest_votes', function (Blueprint $table) {
            $table->foreign('contest_id')->references('id')->on('contests');
            $table->foreign('section_id')->references('id')->on('contest_sections');
            $table->foreign('juror_user_id')->references('user_id')->on('user_contacts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_votes', function (Blueprint $table) {
            $table->dropForeign('juror_user_id');
            $table->dropForeign('section_id');
            $table->dropForeign('contest_id');
        });
    }
};
