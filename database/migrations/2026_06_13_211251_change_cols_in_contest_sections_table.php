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
        Schema::table('contest_sections', function (Blueprint $table) {
            // add
            $table->text('synopsis')->nullable()
                ->after('name_local')
                ->comment('synopsis from federal regulation docs');
            // rename
            $table->renameColumn('rule_format', 'file_formats');
            $table->string('file_formats')->default('jpg,tif,raw,raf,nef,cr2')
                ->comment('list of ext, comma separated')->change();

            $table->renameColumn('rule_min', 'min_works');
            $table->integer('min_works')->unsigned()
                ->default(0)->comment('greater zero == portfolio')->change();

            $table->renameColumn('rule_max', 'max_works');
            $table->integer('max_works')->unsigned()
                ->default(4)->comment('not less min_works')->change();

            $table->renameColumn('rule_min_size', 'short_size_max');
            $table->integer('short_size_max')->unsigned()
                ->default(1024)->comment('px')->change();

            $table->renameColumn('rule_max_size', 'long_size_max');
            $table->integer('long_size_max')->unsigned()
                ->default(2500)->comment('px')->change();

            $table->renameColumn('rule_max_weight', 'file_size_max');
            $table->integer('file_size_max')->unsigned()
                ->default(6000000)->comment('Bytes')->change();

            $table->renameColumn('rule_monochromatic', 'monochromatic_required');

            $table->renameColumn('rule_raw_required', 'raw_required');

            $table->renameColumn('rule_only_one', 'unique_prize');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_sections', function (Blueprint $table) {
            //
        });
    }
};
