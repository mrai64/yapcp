<?php
/**
 * user_contacts
 * child table of users
 * 
 * user is only for platform registration
 * user_contacts is for more data on user
 * don't need an uuid() as primary key
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
            $table->foreignUuid('user_id')->unique()->comment('fk: users.id uuid');
            $table->char('country_id', 3)->comment('fk: countries.id');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('nick_name')->nullable();
            $table->string('email')->comment('same as users.email');
            $table->string('cellular', 20)->comment('even with international prefix');
            $table->string('passport_photo')->comment('reserved');
            $table->string('address');
            $table->string('address_line2');
            $table->string('city');
            $table->string('region')->comment('country / area / town');
            $table->string('postal_code', 10)->comment('aka zip code');
            // 
            $table->string('website')->nullable()->comment('url of personal site');
            $table->string('facebook')->nullable()->comment('url of personal page');
            $table->string('x_twitter')->nullable()->comment('url of personal page');
            $table->string('instagram')->nullable()->comment('url of personal page');
            $table->string('whatsapp')->nullable()->comment('to chat into');
            // for backup
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();

            //
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
