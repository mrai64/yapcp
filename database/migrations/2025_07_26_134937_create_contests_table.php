<?php
/**
 * 2025-07-26 ITA Elenco "semplice" dei concorsi
 * TODO Mettere nel model use SoftDeletes
 * - id concorso (id oppure uuid)
 * - nome del concorso 
 * più avanti
 * - nazione del concorso 
 * - link scheda organizzatore
 * - link bando regolamento 
 * - link modulo iscrizione 
 * - link pagina risultati 
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
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('contests', 100)->index();
            // $table->timestamps();
            $table->timestamps()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
