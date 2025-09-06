<?php
/**
 * - uuid id
 * - factory yes, but
 * - softdelete yes
 * 
 * It's a id card for contest and
 * UH? A lot of fields? yes. We need it 
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
        Schema::create('contests', function (Blueprint $table) {
            $table->uuid('id')->primary()
                ->comment('uuid assigned'); // $table->id();
            $table->string('country_id',3)->index()
                ->comment('fk: countries.id');
            $table->string('name_en')->index();
            $table->string('name_local')->nullable()->index();
            $table->string('organization_id',36)->index()
                ->comment('fk: organizations.id');
            $table->string('contest_mark')->nullable()
                ->comment('The contest or organization passport photo - mark');
            $table->text('contact_info')
                ->comment('contest headquarter, email and so on');
            $table->char('is_circuit',1)->default('N')->comment('Y/N, N when not Y');
            $table->string('circuit_id',36)->nullable()->index()
                ->comment('null or a valid contest.id');
            $table->string('federation_list')->nullable()
                ->comment('under patronage of federation code[]');
            // link to outer space
            $table->string('url_1_rule')->nullable()
                ->comment('how read english rules and subscribe link');
            $table->string('url_2_concurrent_list')->nullable();
            $table->string('url_3_admit_n_award list')->nullable()
                ->comment('only the result list, not a catalogue');
            $table->string('url_4_catalogue')->nullable()
                ->comment('catalogue download page');
            // calendar
            // TODO use dateTimeTz
            $table->string('timezone')
                ->comment('A MUST HAVE used for time math, must be a php valid timezone');
            $table->dateTime('day_1_opening')->comment('Reveal the contest, opening for subscription');
            $table->dateTime('day_2_closing')->comment('End of receive works');
            $table->dateTime('day_3_jury_opening')->comment('Start of juror works');
            $table->dateTime('day_4_jury_closing')->comment('End of juror works');
            $table->dateTime('day_5_revelations')->comment('Publicly result communications');
            $table->dateTime('day_6_awards')->index()->comment('Award Ceremony');
            $table->dateTime('day_7_catalogues')->comment('Publicly Catalogue publications');
            $table->dateTime('day_8_closing')->comment('Closing date for award postal send');
            $table->text('award_ceremony_info')->nullable()->comment('Site and date, or link to broadcast platform');
            // backup and softdelete - don't need Tz anymore
            $table->dateTime('created_at')->useCurrent()
                ->comment('backup reserved');
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()
                ->comment('backup reserved');
            $table->dateTime('deleted_at')->nullable()
                ->comment('softdelete reserved'); 
            // 
            $table->index(['country_id', 'day_2_closing', 'name_en', 'created_at'], 'general_idx')
                ->comment('for general list');
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
