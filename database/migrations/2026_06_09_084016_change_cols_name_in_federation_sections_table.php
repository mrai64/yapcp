<?php

/**
 * for issue #133
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('federation_sections', function (Blueprint $table) {
            $table->renameColumn('rule_definition', 'synopsis');
            $table->renameColumn('min_short_side', 'short_size_max');
            $table->renameColumn('max_long_side', 'long_size_max');
            $table->renameColumn('max_weight', 'file_size_max');
            $table->renameColumn('only_one', 'unique_prize');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federation_sections', function (Blueprint $table) {
            $table->renameColumn('synopsis', 'rule_definition');
            $table->renameColumn('short_size_max', 'min_short_side');
            $table->renameColumn('long_size_max', 'max_long_side');
            $table->renameColumn('file_size_max', 'max_weight');
            $table->renameColumn('unique_prize', 'only_one');
        });
    }
};
