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
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->index(['contest_id', 'section_id', 'award_code', 'winner_work_id', 'winner_user_id', 'winner_name'], 'view_idx');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->dropIndex('deleted_at');
            $table->dropIndex('view_idx');
        });
    }
};
