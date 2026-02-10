<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contest_juries', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')
                ->primary()->comment('reak pk section_id + juror user_id');
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contest_sections.id');
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_contacts.id - juror');
            $table->boolean('is_president')->default(false)
                ->comment('used to put first in juror list');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->unique(['section_id', 'user_id'], 'general_idx');
            // fk
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['section_id'], 'contest_section_fk')->references(['id'])->on('contest_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            //
            $table->comment('juror contest section list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_juries');
    }
};
