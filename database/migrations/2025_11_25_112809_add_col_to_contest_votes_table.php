<?php

/**
 * Add review col to contest_votes_table
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
        Schema::table('contest_votes', function (Blueprint $table) {
            $table->boolean('review_required')->default(false)
                ->after('vote')->comment('0 = not required');
            // idx
            $table->index(['section_id', 'juror_user_id', 'review_required', 'work_id'], 'review_idx');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_votes', function (Blueprint $table) {
            $table->dropIndex('review_idx');
            $table->dropColumn('review_required');
        });
    }
};
