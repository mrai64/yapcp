<?php

/**
 * Change column site from 5 to 10
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
        Schema::table('federation_sections', function (Blueprint $table) {
            //
            $table->string('code', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_sections', function (Blueprint $table) {
            // no down?
            $table->string('code', 5)->change();
        });
    }
};
