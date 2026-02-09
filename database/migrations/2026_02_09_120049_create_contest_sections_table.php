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
        Schema::create('contest_sections', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('contest_id', 36);
            $table->string('code', 10)->comment('as fk: federationSections.code');
            $table->char('under_patronage', 1)->default('N')->comment('a Y/N col');
            $table->unsignedBigInteger('federation_section_id')->nullable()->comment('fk: federation_sections.id');
            $table->string('name_en')->comment('international');
            $table->string('name_local')->nullable()->comment('in local lang - see contests.lang_local');
            $table->string('rule_format')->default('jpg')->comment('list of permitted extension');
            $table->unsignedInteger('rule_min')->default(0)->comment('minimum works-per-section');
            $table->unsignedInteger('rule_max')->default(4)->comment('maximum works-per-section');
            $table->unsignedInteger('rule_min_size')->default(1024)->comment('minimum short_side px');
            $table->unsignedInteger('rule_max_size')->default(2500)->comment('maximum long_side px');
            $table->unsignedInteger('rule_max_weight')->default(6000)->comment('file weight in KB');
            $table->char('rule_monochromatic', 1)->default('N')->comment('maybe boolean 0/N=false, 1/Y=true');
            $table->boolean('rule_raw_required')->default(false)->comment('0 == false; 1 == true');
            $table->boolean('rule_only_one')->default(false)->comment('0 = only one prize per section per person not required');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['contest_id', 'code'], 'general_idx');
            $table->index(['contest_id', 'name_en', 'deleted_at'], 'name_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_sections');
    }
};
