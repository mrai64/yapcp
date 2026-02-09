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
            $table->foreign(['contest_id'])->references(['id'])->on('contests')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['juror_user_id'])->references(['user_id'])->on('user_contacts')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_votes', function (Blueprint $table) {
            $table->dropForeign('pcp_contest_votes_contest_id_foreign');
            $table->dropForeign('pcp_contest_votes_juror_user_id_foreign');
            $table->dropForeign('pcp_contest_votes_section_id_foreign');
        });
    }
};
