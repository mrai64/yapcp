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
            $table->unique(['user_id', 'contest_id', 'section_id', 'portfolio_sequence', 'work_id', 'deleted_at'], 'sequence_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->dropUnique('sequence_idx');
        });
    }
};
