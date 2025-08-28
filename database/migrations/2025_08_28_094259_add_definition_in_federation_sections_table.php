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
            $table->text('definition')->nullable()
            ->after('name')->comment('extract from regulation doc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_sections', function (Blueprint $table) {
            $table->dropColumn('definition');
        });
    }
};
