<?php
/**
 * 2025-07-25 ITA Elenco delle nazioni basato sulla codifica
 *                iso3166-3, potrebbe essere sostituito da un
 *                file di configurazione.
 *            ENG Country list based on iso-3166-3 list,
 *                or use a config file.
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
        Schema::create('countries', function (Blueprint $table) {
            $table->string('iso3', 3)->primary(); // id
            $table->string('country', 100)->index(); // english
            // $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
