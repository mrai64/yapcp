<?php

/**
 * Contest Participants
 *
 * The payment of the competition entry fee has been made
 *
 * id not uuid
 *
 * TODO Add a column for payment_references, how register
 * TODO   the payment way: via Paypal via Bank via
 */
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

        Schema::create('contest_participants_fee_payment_completed_sets', function (Blueprint $table) {
            $table->char('status', 1)->primary();
            // N waiting
            // Y completed
        });

        Schema::dropIfExists('contest_participants'); // it's a v.2
        Schema::create('contest_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('contest_id')->comment('fk: contests.id '); // uuid
            $table->foreignUuid('user_id')->comment('fk: user_contacts.user_id '); // uuid

            $table->char('fee_payment_completed', 1)->default('N')->comment('N/Y flag');
            // $table->string('payment_reference')->default('')->comment('paypal, bank, direct');

            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();

            // indexes
            $table->index(['contest_id', 'user_id'], 'contest_idx');
            $table->index(['user_id', 'contest_id'], 'user_idx');

            // fk
            $table->foreign('fee_payment_completed')->references('status')->on('contest_participants_fee_payment_completed_sets');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_participants');
        Schema::dropIfExists('contest_participants_fee_payment_completed_set');
    }
};
