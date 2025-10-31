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
            $table->id();
            $table->foreignUuid('contest_id')->index()->comment('fk: contests.id '); // uuid
            $table->foreignUuid('section_id')->index()->comment('fk: contest_sections.id '); // uuid
            $table->foreignUuid('work_id')->index()->comment('fk: works.id '); // uuid
            $table->foreignUuid('juror_user_id')->index()->comment('fk: user_contacts.user_id '); // uuid
            $table->string('vote')->index()->comment('see contests.vote_rule');

            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index()->comment('date of vote');
            $table->dateTime('deleted_at')->nullable();

            // idxs
            $table->unique(['contest_id', 'section_id', 'work_id', 'juror_user_id'], 'general_idx' );
            $table->index(['contest_id', 'section_id', 'vote', 'work_id', 'juror_user_id'], 'vote_idx' );

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
