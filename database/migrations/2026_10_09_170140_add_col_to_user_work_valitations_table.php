<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('user_work_validations', function (Blueprint $table) {
            // Rende federation_section_id nullable
            $table->unsignedBigInteger('federation_section_id')->nullable()->change();

            // Aggiunge la chiave per ContestSection
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->after('user_work_id')->index()
                ->comment('fk: contest_sections.id');

            // Foreign Key
            $table->foreign('section_id')->references('id')->on('contest_sections')
                ->onUpdate('restrict')->onDelete('restrict');

            // Rimuove la vecchia unique constraint se necessario e ne definisce una nuova
            $table->dropUnique('general_idx');
            $table->unique(['user_work_id', 'section_id', 'federation_section_id'], 'user_work_sec_val_idx');
        });
    }

    public function down(): void
    {
        Schema::table('user_work_validations', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropUnique('user_work_sec_val_idx');
            $table->dropColumn('section_id');

            $table->unique(['user_work_id', 'federation_section_id'], 'general_idx');
        });
    }
};
