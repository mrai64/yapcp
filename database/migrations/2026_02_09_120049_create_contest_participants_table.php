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
        Schema::create('contest_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('contest_id', 36);
            $table->char('user_id', 36);
            $table->char('fee_payment_completed', 1)->default('N')->index('pcp_contest_participants_fee_payment_completed_foreign')->comment('N/Y flag');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['contest_id', 'user_id'], 'contest_idx');
            $table->index(['user_id', 'contest_id'], 'user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_participants');
    }
};
