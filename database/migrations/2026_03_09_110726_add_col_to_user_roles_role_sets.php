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
        Schema::table('user_roles_role_sets', function (Blueprint $table) {
            $table->unsignedTinyInteger('role_weight')->default(0)
                ->after('role')
                ->comment('higher to admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles_role_sets', function (Blueprint $table) {
            $table->dropColumn('role_weight');
        });
    }
};
