<?php

/**
 * user_contact fields that depend on federation_mores
 */

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\UserContact;
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
            $table->id(); // ok, standard id
            // fk 1 - user_contacts    id
            $table->string('user_contact_user_id', 36)->comment('fk for user_contact id');
            // fk 2 - federations      id
            $table->string('federation_id', 10)->comment('fk federations');
            // fk 3 - federation_mores id
            $table->string('field_name', 20)->comment('fk federation_mores');
            $table->string('field_value')->default('')->comment('following rules when updated');

            // for incremental backup and softdelete
            $table->dateTime('created_at')->useCurrent(); // no timestamps
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable(); // softDelete

            // idx
            $table->unique(['user_contact_user_id', 'federation_id', 'field_name'], 'alt_primary_idx')->comment('real primary key');
            $table->index('updated_at', 'backup_idx');
            $table->index('deleted_at', 'soft_delete_idx');

            // relations
            $table->foreign('user_contact_user_id')->references('user_id')->on(UserContact::table_name);
            $table->foreign('federation_id')->references('id')->on(Federation::table_name);
            $table->foreign(['federation_id', 'field_name'])->references(['federation_id', 'field_name'])->on(FederationMore::table_name);

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
