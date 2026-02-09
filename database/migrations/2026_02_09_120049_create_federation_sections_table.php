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
        Schema::create('federation_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('federation_id', 10);
            $table->char('code', 10);
            $table->string('name_en')->index()->comment('official name in english');
            $table->char('local_lang', 2)->default('en')->comment('follow iso-3166 2 ascii lowercase');
            $table->string('name_local')->default('')->comment('in local name');
            $table->text('rule_definition')->nullable()->comment('synopsis from federal regulation docs');
            $table->string('file_formats')->default('jpg,tif,raw,raf,nef,cr2')->comment('list of ext, comma separated');
            $table->unsignedInteger('min_works')->default(0)->comment('greater zero == portfolio');
            $table->unsignedInteger('max_works')->default(4);
            $table->unsignedInteger('min_short_side')->default(1080)->comment('px');
            $table->unsignedInteger('max_long_side')->default(2500)->comment('px');
            $table->integer('max_weight')->default(6000000)->comment('Bytes');
            $table->boolean('monochromatic_required')->default(false)->comment('0 == false, 1 == true');
            $table->boolean('raw_required')->default(false)->comment('0 == false, 1 == true');
            $table->boolean('only_one')->default(false)->comment('0 = only one prize per section per person not required');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['federation_id', 'code', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_sections');
    }
};
