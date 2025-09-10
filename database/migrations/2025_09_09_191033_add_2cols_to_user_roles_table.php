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
        Schema::table('user_roles', function (Blueprint $table) {
            $table->string('federation_id', 36)->nullable()->after('organization_id')->comment('fk: federations.id');
            $table->string('contest_id', 36)->nullable()->after('federation_id')->comment('fk: contests.id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropColumn('federation_id');
            $table->dropColumn('contest_id');
        });
    }
};
