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
        Schema::create('contest_waitings', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('contest_id', 36);
            $table->char('section_id', 36);
            $table->char('work_id', 36)->index();
            $table->char('participant_user_id', 36)->index('participant_idx');
            $table->unsignedTinyInteger('portfolio_sequence')->default(0)->comment('valid also in section counter');
            $table->char('organization_user_id', 36)->index('organization_idx');
            $table->text('because')->comment('why that work is out');
            $table->string('email')->comment('for notification');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['contest_id', 'section_id', 'work_id', 'portfolio_sequence', 'deleted_at'], 'main_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_waitings');
    }
};
