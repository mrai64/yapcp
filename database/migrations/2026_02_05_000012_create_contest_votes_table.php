<?php

/**
 * Contest Juror vote board
 * 
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contest_votes', function (Blueprint $table) {
            $table->id()->comment('real pk: section_id + work_id + juror_id');
            //
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id contest_sections.contest_id');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contest_sections.id');
            $table->char('work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contest_works.work_id user_works.id');
            $table->char('juror_user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_contacts.id juror');
            //
            $table->string('vote')->index()->comment('based on contests.vote_rule');
            $table->boolean('review_required')->default(false)->comment('false - not required');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index()->comment('date of vote');
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->unique(['contest_id', 'section_id', 'work_id', 'juror_user_id'], 'general_idx');
            $table->index(['section_id', 'juror_user_id', 'review_required', 'work_id'], 'review_idx');
            $table->index(['contest_id', 'section_id', 'vote', 'work_id', 'juror_user_id'], 'vote_idx');
            // fk
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            // it's contest_works.id
            $table->foreign(['work_id'])->references(['work_id'])->on('contest_works')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['juror_user_id'])->references(['user_id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            //
            $table->comment('The juror vote board');
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
