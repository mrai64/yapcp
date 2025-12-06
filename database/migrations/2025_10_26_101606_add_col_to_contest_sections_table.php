<?php

/**
 * Needed a more strict relationship between
 * contest_section when under patronage == Y
 * and
 * federation_section
 * even if contest is under more-tha-unique federation sponsorship
 * only one of federation rules win over other and are used
 * as reference rule for contest section
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
        Schema::table('contest_sections', function (Blueprint $table) {
            $table->foreignId('federation_section_id')->nullable()->after('under_patronage')->comment('fk: federation_sections.id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_sections', function (Blueprint $table) {
            $table->dropColumn('federation_section_id');
        });
    }
};
