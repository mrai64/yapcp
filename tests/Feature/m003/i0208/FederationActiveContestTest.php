<?php

/**
 * check activeContest model
 */

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Federation;
use Illuminate\Support\Carbon;

it('counts active contests where today is between day1_opening and day8_closing', function () {
    // 1. Fissiamo la data di oggi a un giorno preciso per il test
    $today = Carbon::parse('2026-06-15 12:00:00');
    Carbon::setTestNow($today);

    // 2. Creiamo una federazione
    $federation = Federation::factory()->create(['id' => 'FED01']);

    // 3. Creiamo i concorsi con varie combinazioni di date:

    // Concorso A: APERTO (day1 < oggi < day8) -> DEVE ESSERE CONTEGGIATO
    $openContest1 = Contest::factory()->create([
        'day_1_opening' => '2026-06-01 00:00:00',
        'day_8_closing' => '2026-06-30 23:59:59',
    ]);

    // Concorso B: APERTO (oggi coincide esattamente con day1) -> DEVE ESSERE CONTEGGIATO
    $openContest2 = Contest::factory()->create([
        'day_1_opening' => '2026-06-15 00:00:00',
        'day_8_closing' => '2026-06-20 23:59:59',
    ]);

    // Concorso C: APERTO (oggi coincide esattamente con day8) -> DEVE ESSERE CONTEGGIATO
    $openContest3 = Contest::factory()->create([
        'day_1_opening' => '2026-06-01 00:00:00',
        'day_8_closing' => '2026-06-15 23:59:59',
    ]);

    // Concorso D: NON ANCORA APERTO (day1 nel futuro) -> ESCLUSO
    $futureContest = Contest::factory()->create([
        'day_1_opening' => '2026-07-01 00:00:00',
        'day_8_closing' => '2026-07-31 23:59:59',
    ]);

    // Concorso E: GIÀ CHIUSO (day8 nel passato) -> ESCLUSO
    $pastContest = Contest::factory()->create([
        'day_1_opening' => '2026-05-01 00:00:00',
        'day_8_closing' => '2026-05-31 23:59:59',
    ]);

    // 4. Associamo i concorsi alla federazione tramite la pivot ContestPatronage
    foreach ([$openContest1, $openContest2, $openContest3, $futureContest, $pastContest] as $contest) {
        ContestPatronage::factory()->create([
            'federation_id'  => $federation->id,
            'contest_id'     => $contest->id,
            'patronage_code' => fake()->regexify('[A-Z0-9]{' . fake()->numberBetween(4, 6) . '}'),
        ]);
    }

    // 5. Verifica: ci aspettiamo esattamente 3 concorsi attivi
    expect($federation->activeContests()->count())->toBe(3);
});
