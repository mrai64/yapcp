<?php
/**
 * Contest Waiting
 * Works Parked away from contest
 * wait a moment: that work had a problem 
 * 
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
        Schema::create('contest_waitings', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('uuid assigned'); //                  uuid

            $table->foreignUuid('contest_id')->comment('fk: contests.id 1:N '); //       uuid
            $table->foreignUuid('section_id')->comment('fk: contest_sections.id '); //   uuid
            $table->foreignUuid('work_id')->comment('fk: works.id '); // uuid
            $table->foreignUuid('participant_user_id')->comment('fk: users.id '); //     uuid
            $table->unsignedTinyInteger('portfolio_sequence')->default(0)
                ->comment('valid also in section counter');
            //
            $table->foreignUuid('organization_user_id')->comment('fk: users.id '); //    uuid
            $table->text('because')->comment('why that work is out'); //                 uuid
            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idxs
            $table->index(['contest_id', 'section_id', 'work_id', 'portfolio_sequence', 'deleted_at'], 'main_idx');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_waitings');
    }
};
