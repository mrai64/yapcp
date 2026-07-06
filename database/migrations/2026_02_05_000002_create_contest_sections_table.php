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
            $table->uuid('id')
                ->charset('ascii')->collation('ascii_general_ci')
                ->primary()
                ->comment('real pk contest_id n code');
            $table->char('contest_id', 36)
                ->charset('ascii')->collation('ascii_general_ci')
                ->index()
                ->comment('fk: contests.id');
            $table->string('code', 10)
                ->charset('ascii')->collation('ascii_general_ci')
                ->index()
                ->comment('fk: federationSections.code but also not');

            $table->boolean('under_patronage')
                ->default(false)
                ->comment('section-theme valid for federation');
            $table->unsignedBigInteger('federation_section_id')
                ->nullable()
                ->default(null)
                ->comment('null | fk: federation_sections.id');

            $table->string('name_en')->comment('international');
            $table->string('name_local')
                ->default('')
                ->comment('in local lang - see contests.lang_local');
            $table->text('synopsis')->nullable()->comment('synopsis from federal regulation docs');

            // sections rules
            $table->string('file_formats')
                ->default('jpg,tif,raw,raf,nef,cr2')
                ->comment('list of permitted extension');

            $table->unsignedInteger('min_works')->default(0)->comment('greater zero == portfolio');
            $table->unsignedInteger('max_works')->default(4);
            $table->unsignedInteger('short_size_max')->default(1080)->comment('px');
            $table->unsignedInteger('long_size_max')->default(2500)->comment('px');
            $table->unsignedInteger('file_size_max')->default(6000)->comment('KB');

            $table->boolean('monochromatic_required')->default(false)
                ->comment('0 == false, 1 == true');
            $table->boolean('raw_required')->default(false)
                ->comment('section require raw original works (not only)');
            $table->boolean('unique_prize')->default(false)
                ->comment('required only one prize / author n section');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->unique(['contest_id', 'code', 'deleted_at'], 'general_idx');
            $table->index(['contest_id', 'name_en', 'deleted_at'], 'name_idx');
            // fk
            $table->foreign(['contest_id'])
                ->references(['id'])->on('contests')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('federation_section_id')
                ->references('id')->on('federation_sections')
                ->onDelete('set null');
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
