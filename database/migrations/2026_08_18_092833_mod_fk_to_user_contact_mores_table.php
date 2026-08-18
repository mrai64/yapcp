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
            // reset onUpdate onDelete to restrict
            $table->dropForeign('use_con_mor_fed_fk');
            $table->dropForeign('use_con_mor_fed_mor_fk');
            //
            $table->foreign(['federation_id'], 'use_con_mor_fed_fk')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign(['federation_id', 'field_name'], 'use_con_mor_fed_mor_fk')
                ->references(['federation_id', 'field_name'])->on('federation_mores')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contact_mores', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('use_con_mor_fed_fk');
            $table->dropForeign('use_con_mor_fed_mor_fk');
            //
            $table->foreign(['federation_id'], 'use_con_mor_fed_fk')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign(['federation_id', 'field_name'], 'use_con_mor_fed_mor_fk')
                ->references(['federation_id', 'field_name'])->on('federation_mores')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }
};
