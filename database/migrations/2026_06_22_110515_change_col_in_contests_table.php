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
        Schema::table('contests', function (Blueprint $table) {
            $table->dropColumn('is_circuit');
            $table->boolean('is_circuit')->default(false)->comment('contests joined in circuit')->after('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->dropColumn('is_circuit');
            $table->char('is_circuit', 1)->default('N')->comment('Y/N, N when not Y')->after('organization_id');
        });
    }
};
