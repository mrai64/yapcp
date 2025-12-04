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
        Schema::table('contest_participants', function (Blueprint $table) {
            $table->foreign('contest_id')->references('id')->on('contests');
            $table->foreign('user_id')->references('user_id')->on('user_contacts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_participants', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('contest_id');
        });
    }
};
