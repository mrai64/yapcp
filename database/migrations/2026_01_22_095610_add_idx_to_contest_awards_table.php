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
            $table->index('winner_user_id', 'winner_user_id_idx');
            $table->index('winner_work_id', 'winner_work_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_awards', function (Blueprint $table) {
            $table->dropIndex('winner_user_id_idx');
            $table->dropIndex('winner_work_id_idx');
        });
    }
};
