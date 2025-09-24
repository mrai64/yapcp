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
            $table->string('cellular', 20)->default('')->change();
            $table->string('passport_photo')->default('')->change();
            $table->string('address')->default('')->change();
            $table->string('address_line2')->default('')->change();
            $table->string('city')->default('')->change();
            $table->string('region')->default('')->change();
            $table->string('postal_code', 10)->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contacts', function (Blueprint $table) {
            //
        });
    }
};
