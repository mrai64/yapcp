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
        Schema::create('federation_mores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('federation_id', 10)->comment('fk federations');
            $table->string('field_name', 20)->comment('lowercase');
            $table->string('field_label')->comment('label for the field');
            $table->string('field_validation_rules')->default('string|max:255')->comment('string or function(), validation rules for the field, nullable if none');
            $table->string('field_default_value')->default('')->comment('empty string as default default value');
            $table->string('field_suggest')->default('')->comment('message to explain what insert');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index('backup_idx');
            $table->dateTime('deleted_at')->nullable()->index('soft_delete_idx');

            $table->unique(['federation_id', 'field_name'], 'alt_primary_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_mores');
    }
};
