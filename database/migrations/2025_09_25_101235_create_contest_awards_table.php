<?php
/**
 * Contest (section) Awards table
 * - child of contest section table
 *   - child of Contest table
 * - 
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
        Schema::create('contest_awards', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('uuid assigned'); // uuid

            $table->foreignUuid('contest_id')->comment('fk: contests.id 1:N '); // uuid
            $table->foreignUuid('section_id')->nullable()->comment('fk: contest_section.id '); // uuid
            $table->string('section_code', 10)->nullable()->comment('from: section.id->code ');
            
            $table->string('award_code', 10)->comment('free but unique in contest');
            $table->string('award_name')->comment('free');
            $table->char('is_award', 1)->default('N')->comment('N/Y flag, Y=award prize, N=HM or other'); 
            
            $table->foreignUuid('winner_work_id')->nullable()->comment('fk: works.id '); // uuid - nullable for "greatest participant group and others not individual"
            $table->foreignUuid('winner_user_id')->nullable()->comment('fk: users.id user_contacts.user_id'); // uuid - nullable for not individual prizes
            $table->foreignUuid('winner_name')->nullable()->comment('not individual winners ev not organization'); // uuid - nullable for not individual prizes

            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idx
            $table->unique(['contest_id', 'award_code'], 'general_idx');
            $table->index(['contest_id', 'section_code', 'award_code'], 'secondary_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_awards');
    }
};
