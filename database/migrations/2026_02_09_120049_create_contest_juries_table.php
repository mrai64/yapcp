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
        Schema::create('contest_juries', function (Blueprint $table) {
            $table->char('id', 36)->primary()->comment('uuid assigned');
            $table->char('section_id', 36);
            $table->char('user_contact_id', 36);
            $table->char('is_president', 1)->default('N')->comment('N/Y flag');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['section_id', 'user_contact_id'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_juries');
    }
};
