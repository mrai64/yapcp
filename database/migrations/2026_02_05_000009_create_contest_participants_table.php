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
        Schema::create('contest_participants', function (Blueprint $table) {
            $table->id();
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')->index();
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')->index();
            $table->boolean('fee_payment_completed')->default(false)->index()
                ->comment('reserved for contest organization members');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            //
            $table->index(['contest_id', 'user_id'], 'contest_idx');
            $table->index(['user_id', 'contest_id'], 'user_idx');
            //
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['user_id'])->references(['user_id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            //
            $table->comment('Participant list w/fee semaphore');
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
