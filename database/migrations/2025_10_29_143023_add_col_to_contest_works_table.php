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
        Schema::table('contest_works', function (Blueprint $table) {
            $table->string('extension', 6)->after('work_id')->default('jpg')->comment('to build file name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->dropColumn('extension');
        });
    }
};
