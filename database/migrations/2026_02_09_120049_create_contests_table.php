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
        Schema::create('contests', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('country_id', 3)->index()->comment('fk: countries.id');
            $table->string('name_en')->index();
            $table->string('name_local')->nullable()->index();
            $table->string('lang_local', 8)->default('en')->comment('dev: in LangList[]');
            $table->string('organization_id', 36)->index()->comment('fk: organizations.id');
            $table->char('is_circuit', 1)->default('N')->comment('Y/N, N when not Y');
            $table->string('circuit_id', 36)->nullable()->index()->comment('null or a valid contest.id');
            $table->string('federation_list')->nullable()->comment('under patronage of federation code[]');
            $table->string('contest_mark')->nullable()->comment('The contest or organization passport photo - mark');
            $table->text('contact_info')->comment('contest headquarter, email and so on');
            $table->text('award_ceremony_info')->nullable()->comment('Site and date, or link to broadcast platform');
            $table->text('fee_info')->nullable()->comment('only text description of fee for participation');
            $table->string('vote_rule')->default('num:1..10')->index('pcp_contests_vote_rule_foreign')->comment('related to limited set');
            $table->string('url_1_rule')->nullable()->comment('how read english rules and subscribe link');
            $table->string('url_2_concurrent_list')->nullable();
            $table->string('url_3_admit_n_award_list')->nullable()->comment('only the result list, not a catalogue');
            $table->string('url_4_catalogue')->nullable()->comment('catalogue download page');
            $table->string('timezone')->index('pcp_contests_timezone_foreign')->comment('A MUST HAVE used for time math, must be a php valid timezone');
            $table->dateTime('day_1_opening')->comment('Reveal the contest, opening for subscription');
            $table->dateTime('day_2_closing')->comment('End of receive works');
            $table->dateTime('day_3_jury_opening')->comment('Start of juror works');
            $table->dateTime('day_4_jury_closing')->comment('End of juror works');
            $table->dateTime('day_5_revelations')->comment('Publicly result communications');
            $table->dateTime('day_6_awards')->index()->comment('Award Ceremony');
            $table->dateTime('day_7_catalogues')->comment('Publicly Catalogue publications');
            $table->dateTime('day_8_closing')->comment('Closing date for award postal send');
            $table->dateTime('created_at')->useCurrent()->comment('backup reserved');
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('backup reserved');
            $table->dateTime('deleted_at')->nullable()->index()->comment('softdelete reserved');

            $table->index(['country_id', 'day_2_closing', 'name_en', 'created_at'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
