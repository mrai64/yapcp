<?php

/**
 * Hoping that table remain empty, contains
 * reference at user_works that under automatic n human review
 * are not compliant to contest requirements.
 * So it's a "parking" table how works are
 * waiting for some response from author
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
        Schema::create('contest_waitings', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary()
                ->comment('real pk: contest_work_id');
            // contest_work keys
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contest_sections.id');
            $table->char('user_work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_works.id');
            $table->unsignedTinyInteger('portfolio_sequence')->default(0)
                ->comment('to ripristinate original record');
            // to
            $table->char('participant_user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_contacts.id author');
            $table->string('email')->comment('for notification');
            // from
            $table->char('organization_user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index('organization_idx')->comment('fk: user_works.id organization member');
            // waiting because
            $table->text('because')->comment('why that work is out');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->index(['contest_id', 'section_id', 'user_work_id', 'portfolio_sequence', 'deleted_at'], 'general_idx');
            // fk
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['user_work_id'])->references(['id'])->on('user_works')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['participant_user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['organization_user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            //
            $table->comment('Parking table for user_works with any problem');
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
