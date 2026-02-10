<?php

/**
 * define the awards list for every section and 
 * without section code, for the contest
 *
 * 
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
        Schema::create('contest_awards', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary()
                ->comment('real pk si contest_id + award_code');
            //
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id contest_sections.contest_id');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index()->comment('fk: contest_sections.id');
            $table->string('section_code', 10)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index()->comment('from: section.id->code | null for contest/circuit');
            //
            $table->string('award_code', 10)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('mut be unique in contest');
            $table->string('award_name')->comment('free');
            $table->boolean('is_award')->default(false)->comment('true - award/award prize, false - HM or other');
            // and the winner are
            $table->char('winner_work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index('winner_work_id_idx');
            $table->char('winner_user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index('winner_user_id_idx');
            $table->string('winner_name')->default('')->comment('winner not in previous cols');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->unique(['contest_id', 'award_code'], 'general_idx');
            $table->index(['contest_id', 'section_code', 'award_code'], 'secondary_idx');
            $table->index(['winner_work_id', 'section_id', 'contest_id'], 'sixth_idx');
            $table->index(['contest_id', 'section_id', 'award_code', 'winner_work_id', 'winner_user_id', 'winner_name'], 'view_idx');
            //
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            //
            $table->comment('Contest:award list for every section and for contest/circuit');
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
