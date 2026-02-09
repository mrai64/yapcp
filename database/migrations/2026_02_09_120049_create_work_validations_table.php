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
        Schema::create('work_validations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('work_id', 36)->index();
            $table->unsignedBigInteger('federation_section_id')->comment('fk: federation_sections.id ');
            $table->char('validator_user_id', 36);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['work_id', 'federation_section_id', 'deleted_at'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_validations');
    }
};
