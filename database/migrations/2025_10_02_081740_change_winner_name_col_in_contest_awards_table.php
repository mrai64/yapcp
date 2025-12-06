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
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->dropColumn('winner_name'); // free text - nullable for not individual prizes
            $table->string('winner_name')->after('winner_user_id')->default('')->comment('winner not in previous cols');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_awards', function (Blueprint $table) {
            //
        });
    }
};
