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
        Schema::table('federations', function (Blueprint $table) {
            $table->text('contact')->nullable()
                ->after('website')->comment('postal address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federations', function (Blueprint $table) {
            $table->dropColumn('contact');
        });
    }
};
