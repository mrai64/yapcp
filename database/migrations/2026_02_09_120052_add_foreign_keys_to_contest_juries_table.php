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
        Schema::table('contest_juries', function (Blueprint $table) {
            $table->foreign(['section_id'])->references(['id'])->on('contest_sections')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_juries', function (Blueprint $table) {
            $table->dropForeign('pcp_contest_juries_section_id_foreign');
        });
    }
};
