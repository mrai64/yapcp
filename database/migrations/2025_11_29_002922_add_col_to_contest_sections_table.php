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
            $table->boolean('rule_raw_required')->default(false)
                ->after('rule_monochromatic')
                ->comment("0 == false; 1 == true");
            $table->boolean('rule_only_one')->default(false)
                ->after('rule_raw_required')
                ->comment("0 = only one prize per section per person not required");
            // idx
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_sections', function (Blueprint $table) {
            $table->dropColumn('rule_only_one');
            $table->dropColumn('rule_raw_required');
        });
    }
};
