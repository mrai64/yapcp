<?php

/**
 * (User) Work (manual) Validation (log)
 * Even if a work in a section should be validated for some rule
 * in an automatic way, some others are only human validation,
 * but why validate twice the same work?
 *
 * - work_id
 * - federation_section_id
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
        Schema::create('work_validations', function (Blueprint $table) {
            $table->id(); // standard
            $table->foreignUuid('work_id')->index()->comment('fk: works.id '); // uuid
            $table->foreignId('federation_section_id')->comment('fk: federation_sections.id '); //
            // payload
            $table->foreignUuid('validator_user_id')->comment('fk: user_contacts.user_id '); // uuid

            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idxs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_validations');
    }
};
