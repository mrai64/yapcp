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
            $table->foreign(['contest_id'])->references(['id'])->on('contests')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['user_id'])->on('user_contacts')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['work_id'])->references(['id'])->on('works')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->dropForeign('pcp_contest_works_contest_id_foreign');
            $table->dropForeign('pcp_contest_works_section_id_foreign');
            $table->dropForeign('pcp_contest_works_user_id_foreign');
            $table->dropForeign('pcp_contest_works_work_id_foreign');
        });
    }
};
