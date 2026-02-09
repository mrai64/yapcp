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
        Schema::create('contest_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('contest_id', 36)->index();
            $table->char('section_id', 36)->index();
            $table->char('work_id', 36)->index();
            $table->char('juror_user_id', 36)->index();
            $table->string('vote')->index()->comment('see contests.vote_rule');
            $table->boolean('review_required')->default(false)->comment('0 = not required');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index()->comment('date of vote');
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['contest_id', 'section_id', 'work_id', 'juror_user_id'], 'general_idx');
            $table->index(['section_id', 'juror_user_id', 'review_required', 'work_id'], 'review_idx');
            $table->index(['contest_id', 'section_id', 'vote', 'work_id', 'juror_user_id'], 'vote_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_votes');
    }
};
