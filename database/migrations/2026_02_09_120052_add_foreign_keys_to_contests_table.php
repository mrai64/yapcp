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
        Schema::table('contests', function (Blueprint $table) {
            $table->foreign(['timezone'])->references(['id'])->on('timezones')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['vote_rule'])->references(['vote_rule'])->on('contests_vote_rule_sets')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->dropForeign('pcp_contests_timezone_foreign');
            $table->dropForeign('pcp_contests_vote_rule_foreign');
        });
    }
};
