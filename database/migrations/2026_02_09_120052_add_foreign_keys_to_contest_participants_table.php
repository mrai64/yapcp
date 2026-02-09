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
        Schema::table('contest_participants', function (Blueprint $table) {
            $table->foreign(['contest_id'])->references(['id'])->on('contests')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fee_payment_completed'])->references(['status'])->on('contest_participants_fee_payment_completed_sets')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['user_id'])->on('user_contacts')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_participants', function (Blueprint $table) {
            $table->dropForeign('pcp_contest_participants_contest_id_foreign');
            $table->dropForeign('pcp_contest_participants_fee_payment_completed_foreign');
            $table->dropForeign('pcp_contest_participants_user_id_foreign');
        });
    }
};
