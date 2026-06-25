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
        Schema::table('contest_sections', function (Blueprint $table) {
            $table->dropForeign(['federation_section_id']);
            $table->unsignedBigInteger('federation_section_id')
                ->nullable()
                ->default(null)
                ->comment('zero,or fk: federation_sections.id')
                ->change();
            $table->foreign('federation_section_id')
                ->references('id')
                ->on('federation_sections')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_sections', function (Blueprint $table) {
            // no down
        });
    }
};
