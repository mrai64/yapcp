<?php

/**
 * Test specifico per l'export FIAF 2 (Opere ed Esiti)
 */

namespace Tests\Feature\Export;

use App\Exports\Fiaf2WorksExport;
use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Federation;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use App\Models\UserWork;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Nota: RefreshDatabase è gestito nel TestCase globale del progetto.

it('genera correttamente il report Fiaf2WorksExport con join su opere e premi', function () {
    // 1. Arrange: Preparazione dati
    $this->withoutExceptionHandling();

    // Federazione e Concorso
    $fed = Federation::find('FIAF') ?? Federation::factory()->create(['id' => 'FIAF']);
    $contest = Contest::factory()->create(['federation_list' => 'FIAF']);

    // Sezione del concorso
    $section = ContestSection::factory()->create([
        'contest_id' => $contest->id,
        'code' => 'DIG',
        'under_patronage' => true,
    ]);

    // Autore (User) e record anagrafico (UserContact)
    $user = User::factory()->create();
    $userContact = UserContact::updateOrCreate(
        ['id' => $user->id],
        [
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => $user->email,
            'country_id' => 'ITA',
        ]
    );

    // L'opera nell'archivio personale dell'utente
    dump("Sto per creare UserWork...");
    ds("Check UserWork creation");
    $userWork = UserWork::factory()->create([
        'user_id' => $userContact->id,
        'title_en' => 'Sogno di una notte di mezza estate',
        'reference_year' => '2025'
    ]);
    ds("UserWork created, est: " . json_encode($userWork));

    // Iscrizione dell'opera al concorso (ContestWork)
    ContestWork::factory()->create([
        'contest_id' => $contest->id,
        'section_id' => $section->id,
        'user_id'    => $userContact->id,
        'user_work_id' => $userWork->id, // Chiave di join usata nell'export
        'is_admit'   => true,
        'portfolio_sequence' => 1
    ]);

    // Assegnazione di un premio (necessario per testare il leftJoin su contest_awards)
    ContestAward::factory()->create([
        'contest_id' => $contest->id,
        'section_id' => $section->id,
        'winner_work_id' => $userWork->id,
        'winner_user_id' => $userContact->id,
        'award_code' => 'M1',
        'award_name' => 'Menzione d\'Onore',
    ]);

    // Dati extra FIAF (Tessera e Codice Fiscale)
    UserContactMore::factory()->create([
        'user_id' => $user->id,
        'federation_id' => $fed->id,
        'field_name' => 'cardId',
        'field_value' => '012345',
    ]);

    // 2. Act: Esecuzione dell'export
    $export = new Fiaf2WorksExport($contest->id, $fed->id);
    $response = $export->download('fiaf2_opere_test.xlsx');

    // 3. Assert: Verifica
    expect($response)->toBeInstanceOf(StreamedResponse::class);

    // Verifica che il download contenga dati
    expect($response->headers->get('Content-Disposition'))->toContain('fiaf2_opere_test.xlsx');
});
