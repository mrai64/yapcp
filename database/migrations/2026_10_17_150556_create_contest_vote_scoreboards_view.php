<?php

/**
 * VIEW query predefinita che viene caricata dal mysql
 * per velocizzare i conti quando in termine tecnico
 * i record sono un pacco alto così
 *
 * NON viene sortato per total_votes, ma sarà
 * ATTENZIONE:
 * v.vote AS SIGNED converte il voto stringa '1' in numerico 1
 * ma si sa già che NON FUNZIONA con '⭐️'
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('contest_vote_scoreboards_view', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        DB::statement("
        CREATE VIEW contest_vote_scoreboards AS
        SELECT
            cw.id AS contest_work_id,
            cw.section_id,
            COALESCE(SUM(v.vote), 0) AS total_votes
        FROM contest_works cw
        LEFT JOIN contest_votes v ON  v.contest_work_id = cw.id AND v.deleted_at IS NULL
        WHERE cw.deleted_at IS NULL
        GROUP by cw.id, cw.section_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('contest_vote_scoreboards_view');
        DB::statement("DROP VIEW IF EXISTS contest_vote_scoreboards");
    }
};
