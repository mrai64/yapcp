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
        Schema::create('federations', function (Blueprint $table) {
            $table->char('id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->primary()->comment('UPPER, when code are equals add :country_id to both');

            $table->char('country_id', 3)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk countries.id');
            $table->string('name_en')->index()->comment('official name in english');
            $table->string('website')->default('')->comment('official website or fb info page');

            $table->char('local_lang', 5)->charset('ascii')->collation('ascii_general_ci')
                ->default('en')->comment('follow iso-3166 2 ascii lowercase');
            $table->string('name_local')->default('')->comment('when differ from official english');
            $table->string('timezone_id')->default('')
                ->index('pcp_federations_timezone_id_foreign')->comment('HQ address');

            $table->text('contact_info')->comment('HQ address, email, and other infos');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['country_id', 'id'], 'country_idx');
            $table->index(['country_id', 'name_en'], 'name_idx');

            $table->foreign(['country_id'])->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['timezone_id'])->references(['id'])->on('timezones')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->comment('Who build the contest rules for patronages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federations');
    }
};
