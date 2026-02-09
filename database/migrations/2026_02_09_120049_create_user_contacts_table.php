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
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_id', 36);
            $table->char('country_id', 3)->comment('fk: countries.id');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('nick_name')->nullable();
            $table->string('email')->comment('same as users.email');
            $table->string('cellular', 20)->default('');
            $table->string('passport_photo')->default('anon.jpg');
            $table->char('lang_local', 5)->default('en')->comment('for future use - html lang');
            $table->string('timezone', 40)->default('Europe/Rome')->index('pcp_user_contacts_timezone_foreign')->comment('for future use - php timezone for time math');
            $table->string('address')->default('');
            $table->string('address_line2')->default('');
            $table->string('city')->default('');
            $table->string('region')->default('');
            $table->string('postal_code', 10)->default('');
            $table->string('website')->nullable()->comment('url of personal site');
            $table->string('facebook')->nullable()->comment('url of personal page');
            $table->string('x_twitter')->nullable()->comment('url of personal page');
            $table->string('instagram')->nullable()->comment('url of personal page');
            $table->string('whatsapp')->nullable()->comment('to chat into');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(['country_id', 'last_name', 'first_name', 'user_id'], 'country_name_idx');
            $table->unique(['user_id', 'deleted_at'], 'user_id_idx');
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
