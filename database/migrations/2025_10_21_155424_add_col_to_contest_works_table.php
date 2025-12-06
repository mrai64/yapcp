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
            $table->unsignedTinyInteger('portfolio_sequence')->default(0)
                ->after('work_id')->comment('valid also in section counter');
            $table->dropIndex('user_idx');
            $table->index(['user_id', 'contest_id', 'section_id', 'portfolio_sequence', 'work_id', 'id'], 'user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->dropIndex('user_idx');
            $table->dropColumn('portfolio_sequence');
        });
    }
};
