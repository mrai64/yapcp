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
        Schema::table('user_contacts', function (Blueprint $table) {
            $table->char('lang', 5)->default('en')->after('passport_photo')->comment('for future use - html lang');
            $table->string('timezone', 40)->default('Europe/Rome')->after('lang')->comment('for future use - php timezone for time math');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contacts', function (Blueprint $table) {
            $table->dropColumn('lang');
            $table->dropColumn('timezone');
        });
    }
};
