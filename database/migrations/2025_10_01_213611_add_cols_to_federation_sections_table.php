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
        Schema::table('federation_sections', function (Blueprint $table) {
            $table->string('rule_format')->after('excerptum')->default('jpg')->comment('list of permitted extension');
            $table->unsignedInteger('rule_min')->after('rule_format')->default(0)->comment('minimum works-per-section');
            $table->unsignedInteger('rule_max')->after('rule_min')->default(4)->comment('maximum works-per-section');
            $table->unsignedInteger('rule_min_size')->after('rule_max')->default(1024)->comment('minimum short_side px');
            $table->unsignedInteger('rule_max_size')->after('rule_min_size')->default(2500)->comment('maximum long_side px');
            $table->unsignedInteger('rule_max_weight')->after('rule_max_size')->default(6000)->comment('file weight in KB');
            $table->char('rule_monochromatic')->after('rule_max_weight')->default('N')->comment('Color N Monochromatic Y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_sections', function (Blueprint $table) {
            $table->dropColumn('rule_format');
            $table->dropColumn('rule_min');
            $table->dropColumn('rule_max');
            $table->dropColumn('rule_min_size');
            $table->dropColumn('rule_max_size');
            $table->dropColumn('rule_max_weight');
            $table->dropColumn('rule_monochromatic');
        });
    }
};
