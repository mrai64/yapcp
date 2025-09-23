<?php
/**
 * Contest (Section) Jury table 
 * - child of Contest Section table
 *   - child of Contest table 
 * 
 * Parent also w/UserContact, w/User and w/UserRole
 * 
 * When a record is added to ContestJury
 *   a record must added if missing in
 *   - User 
 *   - UserContact
 *   - UserRole 
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
        Schema::create('contest_jury', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('uuid assigned'); // uuid
            $table->foreignUuid('section_id')->comment('fx: contest_section.id 1:N '); // uuid
            $table->foreignUuid('user_contact_id')->comment('fx: user_contact.user_id'); // uuid
            $table->char('is_president', 1)->default('N')->comment('N/Y flag'); 
            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idx
            $table->unique(['section_id', 'user_contact_id'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_jury');
    }
};
