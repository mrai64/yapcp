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
            // 1. Rimuovi la foreign key che "blocca" l'indice
            $table->dropForeign('reference_fk');

            // Rimuovi l'indice unique esistente
            $table->dropUnique(['referenced_table']);

            // Aggiungi un indice normale
            $table->index('referenced_table', 'referenced_table_idx');

            // 2. Ripristina la foreign key sullo stesso campo
            $table->foreign(['referenced_table'], 'reference_fk')
                ->references(['referenced_table'])->on('federation_mores_referenced_tables')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_mores', function (Blueprint $table) {
            // 1. Rimuovi la foreign key
            $table->dropForeign('reference_fk');

            // Rimuovi l'indice normale
            $table->dropIndex('referenced_table_idx');

            // Ripristina l'indice unique
            $table->unique(['referenced_table']);

            // 2. Ripristina la foreign key
            $table->foreign(['referenced_table'], 'reference_fk')
                ->references(['referenced_table'])->on('federation_mores_referenced_tables')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
