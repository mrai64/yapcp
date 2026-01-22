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
        Schema::table('contest_waitings', function (Blueprint $table) {
            $table->index('participant_user_id', 'participant_idx');
            $table->index('organization_user_id', 'organization_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_waitings', function (Blueprint $table) {
            $table->dropIndex('participant_idx');
            $table->dropIndex('organization_idx');
        });
    }
};
