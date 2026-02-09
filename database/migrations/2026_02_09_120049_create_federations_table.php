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
        Schema::create('federations', function (Blueprint $table) {
            $table->char('id', 10)->primary()->comment('when code are equals add :country_id to both');
            $table->char('country_id', 3)->comment('follow iso-3166 3 ascii uppercase');
            $table->string('name_en')->index()->comment('official name in english');
            $table->char('local_lang', 2)->default('en')->comment('follow iso-3166 2 ascii lowercase');
            $table->string('name_local')->default('');
            $table->string('timezone_id')->default('')->index('pcp_federations_timezone_id_foreign')->comment('reserved');
            $table->string('website')->default('')->comment('official website or fb info page');
            $table->text('contact_info')->comment('HQ address, email, and other infos');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['country_id', 'id'], 'country_idx');
            $table->index(['country_id', 'name_en'], 'name_idx');
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
