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
        Schema::table('user_contact_mores', function (Blueprint $table) {
            // 
            $table->index('user_id', 'user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contact_mores', function (Blueprint $table) {
            //
            $table->dropIndex('user_idx');
        });
    }
};
