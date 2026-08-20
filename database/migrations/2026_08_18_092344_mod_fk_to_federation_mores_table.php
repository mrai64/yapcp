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
        Schema::table('federation_mores', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('fed_mor_fed_fk');
            //
            $table->foreign(['federation_id'], 'fed_mor_fed_fk')
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
        Schema::table('federation_mores', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('fed_mor_fed_fk');
            //
            $table->foreign(['federation_id'], 'fed_mor_fed_fk')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }
};
