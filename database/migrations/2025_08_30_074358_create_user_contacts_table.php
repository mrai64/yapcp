<?php
/**
 * user_contacts
 * child table of users
 * 
 * TODO make Model, Factory, Seeder
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
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->index()->comment('fk: users.id uuid');
            $table->string('contact_type', 20)->comment('lsov: limited set of values');
            $table->string('contact_data');
            // first name
            // last name 
            // nickname
            // email 
            // cellular
            // country_code country.id
            // address
            // address line 2
            // city 
            // Country/Area/Town
            // postal code zip
            // website
            // facebook
            // X twitter
            // instagram
            // whatsapp

            // $table->timestamps();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            // softDeletes
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contacts');
    }
};
