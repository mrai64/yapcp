<?php

/**
 * contest is the base of platform scope
 * here are registered only a part of all contest
 * definition
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
        Schema::create('contests', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary();

            $table->char('country_id', 3)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: countries.id');

            $table->string('name_en')->index();
            $table->string('name_local')->nullable()->index();
            $table->string('lang_local', 5)->charset('ascii')->collation('ascii_general_ci')
                ->default('en')->comment('dev: in LangList[]');

            $table->char('organization_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: organizations.id');

            // TODO convert to boolean 0/1
            $table->char('is_circuit', 1)->default('N')->comment('Y/N, N when not Y');
            $table->string('circuit_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index()->comment('null or a valid contest.id');

            $table->string('federation_list')->nullable()->comment('under patronage of federation code[]');
            $table->string('contest_mark')->nullable()->comment('The contest or organization passport photo - mark');

            $table->text('contact_info')->comment('contest headquarter, email and so on');
            $table->text('award_ceremony_info')->nullable()->comment('Site and date, or link to broadcast platform');
            $table->text('fee_info')->nullable()->comment('only text description of fee for participation');

            $table->string('vote_rule')->default('num:1..10')->index('vote_rule_idx')
                ->comment('fk: contests_vote_rule_sets.vote_rule');

            $table->string('url_1_rule')->nullable()->comment('how read english rules and subscribe link');
            $table->string('url_2_concurrent_list')->nullable();
            $table->string('url_3_admit_n_award_list')->nullable()
                ->comment('only the result list, not a catalogue');
            $table->string('url_4_catalogue')->nullable()->comment('catalogue download page');

            $table->string('timezone_id')->charset('ascii')->collation('ascii_general_ci')
                ->index('timezone_idx')->comment('fk: timezones.id');
            $table->dateTime('day_1_opening')->comment('T1 Reveal the contest, opening for subscription');
            $table->dateTime('day_2_closing')->comment('T2 >= T1 End of receive works');
            $table->dateTime('day_3_jury_opening')->comment('T3 > T2 Start of juror works');
            $table->dateTime('day_4_jury_closing')->comment('T4 >= T3 End of juror works');
            $table->dateTime('day_5_revelations')->comment('T5 > T4 Publicly result communications');
            $table->dateTime('day_6_awards')->index()->comment('T6 > T5 Award Ceremony');
            $table->dateTime('day_7_catalogues')->comment('T7 > T6 Publicly Catalogue publications');
            $table->dateTime('day_8_closing')->comment('T8 > T7 Closing date for award postal send');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['country_id', 'day_2_closing', 'name_en', 'created_at'], 'general_idx');

            $table->foreign(['country_id'])->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['organization_id'])->references(['id'])->on('organizations')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['circuit_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['vote_rule'])->references(['vote_rule'])->on('contests_vote_rule_sets')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['timezone_id'])->references(['id'])->on('timezones')
                ->onUpdate('restrict')->onDelete('restrict');
            //
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
