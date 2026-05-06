<?php

/**
 * Export test
 * - user Export
 * - FIAF 1 participants Export
 * - FIAF 2
 *
 */

use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\ContestSection;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Exports\UserExport;
use App\Exports\Fiaf1ParticipantsExport;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

// uses(RefreshDatabase::class);

it('UserExport genera una risposta valida', function () {
    User::factory()->count(3)->create();

    $response = (new UserExport())->download('utenti.xlsx');

    expect($response)->toBeInstanceOf(StreamedResponse::class);
});

it('FIAF Fiaf1ParticipantsExport genera il report senza errori', function () {
    // 1. Setup dati gerarchici
    $org = Organization::factory()->create();
    $fed = Federation::find('FIAF');
    $contest = Contest::factory()->create([
        'organization_id' => $org->id,
        'country_id' => 'ITA',
        'name_en' => 'The test contest',
        'contact_info' => 'HD ' . $org->name_en,
        'timezone_id' => 'Europe/Rome',
        'federation_list' => 'FIAF',
    ]);

    $codeList = ['BN', 'CL', 'LB', 'NA']; // from fiaf section list
    $randIndex = array_rand($codeList, 3);

    $sections = collect([
        ContestSection::factory()->create([
            'contest_id' => $contest->id,
            'code' => $codeList[$randIndex[0]],
            'under_patronage' => true,
            'name_en' => fake()->text(20),
            'name_local' => fake()->text(20),
        ]),
        ContestSection::factory()->create([
            'contest_id' => $contest->id,
            'code' => $codeList[$randIndex[1]],
            'under_patronage' => true,
            'name_en' => fake()->text(20),
            'name_local' => fake()->text(20),
        ]),
        ContestSection::factory()->create([
            'contest_id' => $contest->id,
            'code' => $codeList[$randIndex[2]],
            'under_patronage' => true,
            'name_en' => fake()->text(20),
            'name_local' => fake()->text(20),
        ]),
    ]);

    // Creiamo un partecipante (User + Contact tramite Factory)
    // TODO Arrivare a gestire almeno 5 user
    $first_name = fake()->firstName();
    $last_name = fake()->lastName();
    $email = fake()->safeEmail();
    $user = User::factory()->create([
        'name' => $last_name . ', ' . $first_name,
        'email' => $email,
    ]);
    $userContact = UserContact::updateOrCreate(
        [ 'id' => $user->id ],
        [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'address' => fake()->address(),
        'city' => fake()->city(),
        'region' => fake()->state(),
        'postal_code' => fake()->text(10),
        'country_id' => 'ITA',
    ]
    );
    $userContactMore = collect([
        UserContactMore::factory()->create([
            'user_id' => $user->id,
            'federation_id' => $fed->id,
            'field_name' => 'cardId',
            'field_value' => fake()->numerify('0######'),
        ]),
        UserContactMore::factory()->create([
            'user_id' => $user->id,
            'federation_id' => $fed->id,
            'field_name' => 'italianTaxId',
            'field_value' => Str::upper(fake()->bothify('??????##?##?###?')),
        ]),
        UserContactMore::factory()->create([
            'user_id' => $user->id,
            'federation_id' => $fed->id,
            'field_name' => 'fiafDistinctions',
            'field_value' => Str::upper(fake()->bothify('???? ?????')),
        ]),
    ]);

    // TODO Creare UserWorks

    ContestParticipant::factory()->create([
        'contest_id' => $contest->id,
        'user_contact_id' => $user->id,
        'fee_payment_completed' => '1',
    ]);

    // Aggiungiamo un'opera per sezione
    foreach ($sections as $section) {
        ContestWork::factory()->create([
            'contest_id' => $contest->id,
            'section_id' => $section->id,
            'country_id' => 'ITA',
            'user_id'    => $user->id,
            'user_work_id' => fake()->uuid(),
            'is_admit'   => fake()->boolean(25), // 25% of true
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
