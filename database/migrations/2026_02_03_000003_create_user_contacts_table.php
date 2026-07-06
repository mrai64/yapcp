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
            $table->uuid('id')
                ->charset('ascii')->collation('ascii_general_ci')->primary()
                ->comment('pk fk: users.id');

            $table->char('country_id', 3)
                ->charset('ascii')->collation('ascii_general_ci')
                ->default('ITA')
                ->comment('fk: countries.id');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('nick_name')->default('')->index()->comment('alias, aka');

            $table->string('email')->unique()->comment('fk: users.email');

            $table->string('cellular', 20)->default('')->comment('completed with international prefix');
            $table->string('passport_photo')->default('/photos/anon.jpg')->comment('as rounded avatars');

            $table->char('lang_code', 7)
                ->charset('ascii')->collation('ascii_general_ci')
                ->default('it_IT')
                ->comment('xx_YYY - for future use in html lang');
            $table->string('timezone_id', 40)
                ->charset('ascii')->collation('ascii_general_ci')
                ->default('Europe/Rome')
                ->index()
                ->comment('fk: timezones.id');

            // postal
            // name see up
            $table->string('address')->default('')->comment('in latin char');
            $table->string('address_line2')->default('');
            $table->string('city')->default('');
            $table->string('region')->default('')->comment('not timezone region');
            $table->string('postal_code', 10)->default('');
            // country see up

            // online
            $table->string('website')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site');
            $table->string('facebook')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site');
            $table->string('x_twitter')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site');
            $table->string('instagram')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site');
            $table->string('whatsapp')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site');
            $table->string('linkedin')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->index(['country_id', 'last_name', 'first_name', 'id'], 'general_idx');
            // fk
            $table->foreign(['country_id'], 'user_contacts_fk1')->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['timezone_id'], 'user_contacts_fk2')->references(['id'])->on('timezones')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id'], 'user_contacts_fk3')->references(['id'])->on('users')
                ->onDelete('cascade');
            $table->foreign(['email'], 'user_contacts_fk4')->references(['email'])->on('users')
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
