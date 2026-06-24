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
        Schema::table('contest_sections', function (Blueprint $table) {
           $table->text('synopsis')->after('name_local');
           $table->renameColumn('file_formats', 'file_formats')->default('jpg,tif,raw,raf,nef,cr2');
           $table->renameColumn('rule_min', 'min_works');
           $table->renameColumn('rule_max', 'max_works');
           $table->renameColumn('rule_min_size', 'short_size_max');
           $table->renameColumn('rule_max_size', 'long_size_max');
           $table->renameColumn('rule_max_weight', 'file_size_max');
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
            $table->removeColumn('synopsis');
            $table->renameColumn('file_formats', 'file_formatss');
            $table->renameColumn('min_works', 'rule_min' );
            $table->renameColumn('max_works', 'rule_max' );
            $table->renameColumn('short_size_max', 'rule_min_size' );
            $table->renameColumn('long_size_max', 'rule_max_size' );
            $table->renameColumn('file_size_max', 'rule_max_weight' );
            $table->renameColumn('monochromatic_required', 'rule_monochromatic_required' );
            $table->renameColumn('raw_required', 'rule_raw_required' );
            $table->renameColumn('unique_prize', 'rule_only_one' );
        });
    }
};
