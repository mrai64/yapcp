<?php

/**
 * to reduce time consume for access in query
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
        Schema::table('contest_works', function (Blueprint $table) {
            $table->index(['work_id', 'section_id', 'contest_id'], 'contest_works_idx');
            $table->index(['user_id', 'section_id', 'contest_id', 'portfolio_sequence'], 'user_contests_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_waitings', function (Blueprint $table) {
            $table->dropIndex('contest_works_idx');
            $table->dropIndex('user_contests_idx');
        });
    }
};
