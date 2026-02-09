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
        Schema::create('contest_works', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('contest_id', 36);
            $table->char('section_id', 36)->index('pcp_contest_works_section_id_foreign');
            $table->char('country_id', 3)->index('pcp_contest_works_country_id_foreign')->comment('fk: user_contacts.country_id ');
            $table->char('user_id', 36);
            $table->char('work_id', 36);
            $table->string('extension', 6)->default('jpg')->comment('to build file name');
            $table->unsignedTinyInteger('portfolio_sequence')->default(0)->comment('valid also in section counter');
            $table->boolean('is_admit')->default(false)->comment('0 = not admit, admit otherwise');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['section_id', 'is_admit', 'work_id'], 'admit_idx');
            $table->index(['contest_id', 'country_id', 'user_id', 'section_id', 'work_id', 'id'], 'catalogue_idx');
            $table->index(['contest_id', 'section_id', 'country_id', 'user_id', 'work_id', 'id'], 'contest_idx');
            $table->index(['work_id', 'section_id', 'contest_id'], 'contest_works_idx');
            $table->unique(['user_id', 'contest_id', 'section_id', 'portfolio_sequence', 'work_id', 'deleted_at'], 'sequence_idx');
            $table->index(['user_id', 'section_id', 'contest_id', 'portfolio_sequence'], 'user_contests_idx');
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
