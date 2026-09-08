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
            $table->string('qualify')->default('')
                ->after('is_president')
                ->comment('president of... professional ...');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_juries', function (Blueprint $table) {
            $table->dropColumn('qualify');
        });
    }
};
