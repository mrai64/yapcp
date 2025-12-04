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
            $table->char('rule_monochromatic', 1)->default('N')->comment("maybe boolean 0/N=false, 1/Y=true")->change();
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
