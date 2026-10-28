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
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->text('citation')
                ->nullable()
                ->after('winner_name')
                ->comment('jury speech for minute or award show');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->dropColumn('citation');
        });
    }
};
