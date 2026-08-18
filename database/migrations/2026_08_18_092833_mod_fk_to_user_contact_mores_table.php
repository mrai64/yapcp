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
            $table->dropForeign('fk_federation_mores');
            $table->index(['federation_id', 'field_name'], 'fed_fld_nam_idx');
            //
            $table->foreign(['federation_id'], 'fk_federation')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign(['federation_id', 'field_name'], 'fk_federation_mores')
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
            $table->dropForeign('fk_federation');
            //
            $table->foreign(['federation_id'], 'fk_federation')
                ->references(['id'])->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign(['federation_id', 'field_name'], 'fk_federation_mores')
                ->references(['federation_id', 'field_name'])->on('federation_mores')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }
};
