<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary()
                ->comment('aligned to users.id');
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk users.id');

            $table->char('country_id', 3)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk: countries.id');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('nick_name')->nullable()->index()->comment('alias, aka');

            $table->string('email')->unique()->comment('aligned to users.email');

            $table->string('cellular', 20)->default('')->comment('country code prefixed');
            $table->string('passport_photo')->default('anon.jpg')->comment('as rounded avatars');

            $table->char('lang_local', 5)->charset('ascii')->collation('ascii_general_ci')
                ->default('en')->comment('xx_YY - for future use in html lang');
            $table->string('timezone_id', 40)->charset('ascii')->collation('ascii_general_ci')
                ->default('Europe/Rome')->index()->comment('fk: timezones.id');

            // postal
            // name see up
            $table->string('address')->default('')->comment('in latin char');
            $table->string('address_line2')->default('');
            $table->string('city')->default('');
            $table->string('region')->default('')->comment('not timezone region');
            $table->string('postal_code', 10)->default('');
            // country see up

            // online
            $table->string('website')->nullable()->comment('url of personal site');
            $table->string('facebook')->nullable()->comment('url of personal page');
            $table->string('x_twitter')->nullable()->comment('url of personal page');
            $table->string('instagram')->nullable()->comment('url of personal page');
            $table->string('whatsapp')->nullable()->comment('url to chat into');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->index(['country_id', 'last_name', 'first_name', 'user_id'], 'general_idx');
            // fk
            $table->foreign(['country_id'], 'user_contacts_fk1')->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['timezone_id'], 'user_contacts_fk2')->references(['id'])->on('timezones')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreign('user_id', 'user_contacts_fk3')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign(['id'], 'user_contacts_fk4')->references(['id'])->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['email'], 'user_contacts_fk5')->references(['email'])->on('users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->comment('the real users info table');
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
