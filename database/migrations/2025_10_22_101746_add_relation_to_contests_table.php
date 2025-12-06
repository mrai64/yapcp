<?php

/**
 * created auxiliary table contests_vote_role_set
 * make col and related to
 */

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
            $table->string('vote_rule')->default('num:1..10')->after('fee_info')->comment('related to limited set');
            $table->foreign('vote_rule')->references('vote_rule')->on('contests_vote_rule_sets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contests', function (Blueprint $table) {
            //
            $table->dropForeign('vote_rule');
            $table->dropColumn('vote_rule');
        });
    }
};
