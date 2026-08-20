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
        Schema::table('user_work_mores', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('fk_uwm_uw');
            $table->dropForeign('fk_uwm_fed');
            $table->dropForeign('fk_uwm_fed_more');
            //
            $table->foreign('user_work_id', 'fk_uwm_uw')
                ->references('id')->on('user_works')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            //
            $table->foreign('federation_id', 'fk_uwm_fed')
                ->references('id')
                ->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            //
            $table->foreign(['federation_id', 'field_name'], 'fk_uwm_fed_more')
                ->references(['federation_id', 'field_name'])
                ->on('federation_mores')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_work_mores', function (Blueprint $table) {
            // reset onUpdate onDelete to restrict
            $table->dropForeign('fk_uwm_uw');
            $table->dropForeign('fk_uwm_fed');
            $table->dropForeign('fk_uwm_fed_more');
            //
            $table->foreign('user_work_id', 'fk_uwm_uw')
                ->references('id')->on('user_works')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            //
            $table->foreign('federation_id', 'fk_uwm_fed')
                ->references('id')
                ->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            //
            $table->foreign(['federation_id', 'field_name'], 'fk_uwm_fed_more')
                ->references(['federation_id', 'field_name'])
                ->on('federation_mores')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }
};
