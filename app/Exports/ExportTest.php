<?php

use App\Models\User;
use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\ContestSection;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Exports\UserExport;
use App\Exports\Fiaf1ParticipantsExport;
use App\Exports\Fiaf2WorksExport;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('UserExport genera una risposta valida', function () {
    User::factory()->count(3)->create();

    $response = (new UserExport())->download('utenti.xlsx');

    expect($response)->toBeInstanceOf(StreamedResponse::class);
});

test('Fiaf1ParticipantsExport genera il report senza errori', function () {
    // 1. Setup dati gerarchici
    $org = Organization::factory()->create();
    $fed = Federation::factory()->create();
    $contest = Contest::factory()->create([
        'organization_id' => $org->id,
    ]);

    // Creiamo un paio di sezioni
    $sections = ContestSection::factory()->count(2)->create([
        'contest_id' => $contest->id
    ]);

    // Creiamo un partecipante (User + Contact tramite Factory)
    $user = User::factory()->create();
    // Assumiamo che tu abbia una relazione o un seeder per creare il contatto
    // Se hai un observer che crea il contatto, è già a posto.
    
    ContestParticipant::factory()->create([
        'contest_id' => $contest->id,
        'user_id' => $user->id,
    ]);

    // Aggiungiamo un'opera per sezione
    foreach ($sections as $section) {
        ContestWork::factory()->create([
            'contest_id' => $contest->id,
            'section_id' => $section->id,
            'user_id'    => $user->id,
            'is_admit'   => true,
        ]);
    }

    // 2. Esecuzione
    $export = new Fiaf1ParticipantsExport($contest->id, $fed->id);
    $response = $export->download('test_fiaf1.xlsx');

    // 3. Verifica
    expect($response)->toBeInstanceOf(StreamedResponse::class);
    
    // Opzionale: cattura l'output per assicurarsi che non sia vuoto
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();
    
    expect(strlen($content))->toBeGreaterThan(0);
});
