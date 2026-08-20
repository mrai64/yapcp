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
        Schema::table('user_roles', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('use_rol_fed_fk');
            //
            $table->foreign(['federation_id'], 'use_rol_fed_fk')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('use_rol_fed_fk');
            //
            $table->foreign(['federation_id'], 'use_rol_fed_fk')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }
};
