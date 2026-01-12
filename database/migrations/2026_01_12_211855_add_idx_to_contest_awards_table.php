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
            $table->index(['winner_work_id', 'section_id', 'contest_id'], 'sixth_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->dropIndex('sixth_idx');
        });
    }
};
