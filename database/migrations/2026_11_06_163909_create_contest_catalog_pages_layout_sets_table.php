<?php

/**
 * aka contest_catalog_pages_layout_type_sets
 */

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
        Schema::create('contest_catalog_pages_layout_sets', function (Blueprint $table) {
            $table->char('layout_type', 16)
                ->charset('ascii')->collation('ascii_general_ci')
                ->primary();
            //
            // template
            $table->string('template_file_path')
                ->default('')->index('template_idx')
                ->comment('path n complete filename, complete');
            $table->string('title_en')
                ->default('')
                ->comment('english page definition');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            //
            $table->comment('lookup table for: contest_catalog_pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_catalog_pages_layout_sets');
    }
};
