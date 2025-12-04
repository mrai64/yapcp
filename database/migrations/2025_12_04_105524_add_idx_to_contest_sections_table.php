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
            $table->index(['contest_id', 'name_en', 'deleted_at'], 'name_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_sections', function (Blueprint $table) {
            $table->dropIndex('name_idx');
        });
    }
};
