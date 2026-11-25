<?php

/**
 * For circuit use enlarge field from 20 to 72
 *
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
        Schema::table('contest_patronages', function (Blueprint $table) {
            $table->string('patronage_code', 72)
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_patronages', function (Blueprint $table) {
            $table->string('patronage_code', 20)
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('')
                ->change();
        });
    }
};
