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
        Schema::create('contest_awards', function (Blueprint $table) {
            $table->comment('Contest awards contains both sections prizes and contest prizes (section code missing)');
            $table->char('id', 36)->primary()->comment('uuid assigned');
            $table->char('contest_id', 36);
            $table->char('section_id', 36)->nullable();
            $table->string('section_code', 10)->nullable()->comment('from: section.id->code ');
            $table->string('award_code', 10)->comment('free but unique in contest');
            $table->string('award_name')->comment('free');
            $table->char('is_award', 1)->default('N')->comment('N/Y flag, Y=award prize, N=HM or other');
            $table->char('winner_work_id', 36)->nullable()->index('winner_work_id_idx');
            $table->char('winner_user_id', 36)->nullable()->index('winner_user_id_idx');
            $table->string('winner_name')->default('')->comment('winner not in previous cols');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['contest_id', 'award_code'], 'general_idx');
            $table->index(['contest_id', 'section_code', 'award_code'], 'secondary_idx');
            $table->index(['winner_work_id', 'section_id', 'contest_id'], 'sixth_idx');
            $table->index(['contest_id', 'section_id', 'award_code', 'winner_work_id', 'winner_user_id', 'winner_name'], 'view_idx');
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
