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
        Schema::table('work_validations', function (Blueprint $table) {
            $table->unique(['work_id', 'federation_section_id', 'deleted_at'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_validations', function (Blueprint $table) {
            $table->dropUnique('general_idx');
        });
    }
};
