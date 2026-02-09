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
        Schema::create('user_contact_mores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_contact_user_id', 36)->comment('fk for user_contact id');
            $table->string('federation_id', 10)->comment('fk federations');
            $table->string('field_name', 20)->comment('fk federation_mores');
            $table->string('field_value')->default('')->comment('following rules when updated');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index('backup_idx');
            $table->dateTime('deleted_at')->nullable()->index('soft_delete_idx');

            $table->unique(['user_contact_user_id', 'federation_id', 'field_name'], 'alt_primary_idx');
            $table->index(['federation_id', 'field_name'], 'pcp_user_contact_mores_federation_id_field_name_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contact_mores');
    }
};
