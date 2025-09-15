<?php
/**
 * pk id but
 * unique (contest.id + code) <- should be pk
 * 
 * patronage means almost a federation sponsor
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
        Schema::create('contest_sections', function (Blueprint $table) {
            // $table->id(); // bigint +
            $table->uuid('id')->primary()->comment('uuid assigned'); // uuid
            $table->foreignUuid('contest_id')->comment('fx: contests.id 1:N '); // uuid
            $table->string('code', 10)->comment('as fk: federationSections.code');
            $table->char('under_patronage', 1)->default('N')->comment('a Y/N col');
            $table->string('name_en')->comment('international');
            $table->string('name_local')->nullable()->comment('in local lang - see contests.lang_local');
            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idx
            $table->unique(['contest_id', 'code'], 'general_idx');
            // relations
            // $table->foreign('contest_id')->references('id')->on('contests');
            // TODO the desiderata is that when i soft-delete a contest,
            // TODO  other related record in child tables must be soft-deleted
            // TODO  with it.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_sections');
    }
};
