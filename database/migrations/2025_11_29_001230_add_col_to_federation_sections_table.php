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
            $table->boolean('only_one')->default(false)
                ->after('raw_required')
                ->comment("0 = only one prize per section per person not required");
            // idx
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_sections', function (Blueprint $table) {
            $table->dropColumn('only_one');
        });
    }
};
