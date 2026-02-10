<?php

/**
 * UserContact for federationMore fields
 *
 *
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_contact_mores', function (Blueprint $table) {
            $table->id()->comment('real pk is user_contact_id n federation_id n field_name');
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk for user_contact id');

            $table->string('federation_id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk federation_mores');
            $table->string('field_name', 20)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk federation_mores');
            $table->string('field_value')->default('')->comment('following rules when updated');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['user_contact_user_id', 'federation_id', 'field_name'], 'alt_primary_idx');
            $table->index(['federation_id', 'field_name'], 'pcp_user_contact_mores_federation_id_field_name_foreign');

            $table->foreign(['user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id', 'field_name'])->references(['federation_id', 'field_name'])
                ->on('federation_mores')->onUpdate('restrict')->onDelete('restrict');
            //
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
