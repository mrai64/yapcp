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
        Schema::create('contest_participants', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('uuid assigned'); // uuid

            $table->foreignUuid('contest_id')->comment('fk: contests.id 1:N '); // uuid
            $table->foreignUuid('section_id')->comment('fk: contest_sections.id '); // uuid
            $table->char('country_id',3)->comment('fk: user_contacts.country_id '); // uuid
            $table->foreignUuid('user_id')->comment('fk: users.id '); // uuid
            $table->foreignUuid('work_id')->comment('fk: works.id '); // uuid
            $table->char('is_admit', 1)->default('N')->comment('N/Y flag, Y=admission, N=participant only'); 

            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // 
            $table->index(['contest_id', 'section_id', 'country_id', 'user_id', 'work_id'], 'first_idx');
            $table->index(['contest_id', 'country_id', 'user_id', 'section_id', 'work_id'], 'secondary_idx');
            $table->index(['user_id', 'contest_id', 'section_id', 'work_id'], 'user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_participants');
    }
};
