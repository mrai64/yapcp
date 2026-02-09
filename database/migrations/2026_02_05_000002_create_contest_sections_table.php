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
        Schema::create('contest_sections', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('real pk contest_id n code');
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id');
            $table->string('code', 10)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: federationSections.code but also not');

            $table->boolean('under_patronage')->default(false)->comment('section-theme valid for federation');
            $table->unsignedBigInteger('federation_section_id')->nullable()->comment('fk: federation_sections.id');

            $table->string('name_en')->comment('international');
            $table->string('name_local')->nullable()->comment('in local lang - see contests.lang_local');
            // sections rules
            $table->string('rule_format')->default('jpg')->comment('list of permitted extension');

            $table->unsignedInteger('rule_min')->default(0)->comment('minimum works-per-section');
            $table->unsignedInteger('rule_max')->default(4)->comment('maximum works-per-section');

            $table->unsignedInteger('rule_min_size')->default(1024)->comment('minimum short_side px');
            $table->unsignedInteger('rule_max_size')->default(2500)->comment('maximum long_side px');

            $table->unsignedInteger('rule_max_weight')->default(6000)->comment('file weight in KB');

            $table->boolean('rule_monochromatic')->default(false)->comment('BW / M only');
            $table->boolean('rule_raw_required')->default(false)->comment('RAW required');
            $table->boolean('rule_only_one')->default(false)->comment('unique award per person per section-theme');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['contest_id', 'code'], 'general_idx');
            $table->index(['contest_id', 'name_en', 'deleted_at'], 'name_idx');

            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_section_id'])->references(['id'])->on('federation_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            //
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
