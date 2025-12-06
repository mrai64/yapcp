<?php

/**
 * Fed creation table
 * pk not id bigint autoincrement
 *
 * Fed_secs creation table
 * child-of Fed table
 * relationship 1:N
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
        Schema::create('federations', function (Blueprint $table) {
            $table->char('id', 10)->uppercase()->primary()->comment('when code are equals add :country_id to both');
            $table->char('country_id', 3)->uppercase()->comment('follow iso-3166 3 ascii uppercase');
            $table->string('name_en')->index()->comment('official name in english');
            //
            $table->char('local_lang', 2)->default('en')->comment('follow iso-3166 2 ascii lowercase');
            $table->string('name_local')->default('');
            $table->string('timezone_id')->default('')->comment('reserved');
            $table->string('website')->default('')->comment('official website or fb info page');
            $table->text('contact_info')->comment('HQ address, email, and other infos');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idx
            $table->index(['country_id', 'id'], 'country_idx');
            $table->index(['country_id', 'name_en'], 'name_idx');
            // fk
            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('federation_sections', function (Blueprint $table) {
            $table->char('federation_id', 10)->uppercase();
            $table->char('code', 10)->uppercase()->comment('w/federation_id make pk');

            $table->string('name_en')->index()->comment('official name in english');
            $table->char('local_lang', 2)->default('en')->comment('follow iso-3166 2 ascii lowercase');
            $table->string('name_local')->default('')->comment('in local name');
            //
            $table->text('rule_definition')->nullable()->comment('synopsis from federal regulation docs');
            //
            // automatizable checks
            $table->string('file_formats')->default('jpg,tif,raw,raf,nef,cr2')->comment('list of ext, comma separated');
            $table->unsignedInteger('min_works')->default(0)->comment('greater zero == portfolio');
            $table->unsignedInteger('max_works')->default(4);
            $table->unsignedInteger('min_short_side')->default(1080)->comment('px');
            $table->unsignedInteger('max_long_side')->default(2500)->comment('px');
            $table->integer('max_weight')->default(6000000)->comment('Bytes');
            $table->boolean('monochromatic_required')->default(false)->comment('maybe Y/N');
            $table->boolean('raw_required')->default(false)->comment('maybe Y/N - require a 2nd image w/raw extension dng,nef,other');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idx
            $table->primary(['federation_id', 'code']);
            // fk
            $table->foreign('federation_id')->references('id')->on('federations');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_sections');
        Schema::dropIfExists('federations');
    }
};
