<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('federation_mores', function (Blueprint $table) {
            $table->unique('field_name', 'field_name_idx');
            $table->dropUnique('alt_primary_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_mores', function (Blueprint $table) {
            $table->dropUnique('field_name_idx');
            $table->unique(['federation_id', 'field_name'], 'alt_primary_idx');
        });
    }
};
