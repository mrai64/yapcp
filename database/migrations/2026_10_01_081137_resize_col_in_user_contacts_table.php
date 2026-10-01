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
            // resize col from 255 to 36
            $table->string('whatsapp', 36)->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contacts', function (Blueprint $table) {
            // resize col as original
            $table->string('whatsapp')->default('')
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('url of personal site')->change();
        });
    }
};
