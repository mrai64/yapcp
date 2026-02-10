<?php

/**
 * contest depot
 * - contest_id is a facility
 * - section_id must be related to contest_id
 * - country_id is a facility must be user_id->country_id
 * - work_id must be property of user_id
 * - extension is a facility must be user_work->extension
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
        Schema::create('contest_works', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary();
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contest_sections.id');
            $table->char('country_id', 3)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: countries.id ');
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk:user_contacts.id author');
            $table->char('work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_works.id');
            //
            $table->string('extension', 6)->charset('ascii')->collation('ascii_general_ci')
                ->default('jpg')->comment('used to build file name');
            //
            $table->unsignedTinyInteger('portfolio_sequence')->default(0)
                ->comment('sequence also for portfolio');
            //
            $table->boolean('is_admit')->default(false)->comment('0 = not admit, admit otherwise');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->index(['section_id', 'is_admit', 'work_id'], 'admit_idx');
            $table->index(['contest_id', 'country_id', 'user_id', 'section_id', 'work_id', 'id'], 'catalogue_idx');
            $table->index(['contest_id', 'section_id', 'country_id', 'user_id', 'work_id', 'id'], 'contest_idx');
            $table->index(['work_id', 'section_id', 'contest_id'], 'contest_works_idx');
            $table->unique(['user_id', 'contest_id', 'section_id', 'portfolio_sequence', 'work_id', 'deleted_at'], 'sequence_idx');
            $table->index(['user_id', 'section_id', 'contest_id', 'portfolio_sequence'], 'user_contests_idx');
            //
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['country_id'])->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_works');
    }
};
