<?php

/**
 * Organization Contest Design / ContestAward Add component
 *
 * vendor/bin/pest tests/Feature/m004/i0297/ContestAwardAddTest.php
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestJury;
use App\Models\ContestPatronage;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\UserRole;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // 1. Creiamo un utente e una organizzazione di cui fa parte
    $this->user = User::factory()->create();

    $this->organization = Organization::factory()->create();

    $this->memberOf = UserRole::factory()->create([
        'user_id' => $this->user->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(20)->format('Y-m-d\TH:i:s'),
        'role_closing' => now()->addDays(40)->format('Y-m-d\TH:i:s'),
    ]);
    $this->actingAs($this->user);

    // 2. Creazione del Concorso
    $this->contest = Contest::factory()->create([
        'organization_id'    => $this->organization->id,
        'name_en'            => 'International Photo Contest',
        'day_1_opening'      => now()->subDays(5)->format('Y-m-d H:i:s'),
        'day_2_closing'      => now()->addDays(20)->format('Y-m-d H:i:s'),
        'day_3_jury_opening' => now()->addDays(21)->format('Y-m-d H:i:s'),
        'day_4_jury_closing' => now()->addDays(30)->format('Y-m-d H:i:s'),
        'day_5_revelations'  => now()->addDays(40)->format('Y-m-d H:i:s'),
        'day_6_awards'       => now()->addDays(50)->format('Y-m-d H:i:s'),
        'day_7_catalogues'   => now()->addDays(60)->format('Y-m-d H:i:s'),
    ]);

    // 3. Creazione delle Sezioni del concorso
    $this->contestSection = ContestSection::factory()->create([
        'contest_id'             => $this->contest->id,
        'code'                   => 'A1',
        'under_patronage'        => false,
        'name_en'                => 'Open Color',
        'name_local'             => 'Colore',
        'synopsis'               => 'Free theme color works',
        'file_formats'           => 'jpg',
        'min_works'              => 0,
        'max_works'              => 4,
        'short_size_max'         => 2000,
        'long_size_max'          => 2000,
        'file_size_max'          => 2000000,
        'monochromatic_required' => false,
        'raw_required'           => false,
        'unique_prize'           => true,
    ]);

    // 4. Creazione Giuria per la Sezione
    $this->juryUser = User::factory()->create(['name' => 'John Jury']);
    $this->contestJury = ContestJury::factory()->create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->contestSection->id,
        'user_id'    => $this->juryUser->id,
    ]);

    // 5. Creazione Premi (Generale del Concorso e specifico per Sezione)
    $this->generalAward = ContestAward::factory()->create([
        'contest_id'   => $this->contest->id,
        'section_id'   => null,
        'section_code' => null,
        'award_code'   => 'GEN-01',
        'award_name'   => 'Best Author Overall',
        'is_award'     => true,
    ]);

    $this->sectionAward = ContestAward::factory()->create([
        'contest_id'   => $this->contest->id,
        'section_id'   => $this->contestSection->id,
        'section_code' => $this->contestSection->code,
        'award_code'   => 'SEC-A1-01',
        'award_name'   => 'Gold Medal Open Color',
        'is_award'     => true,
    ]);
});

test('component renders contest detail page correctly for an organization member', function () {
    // Verifica il rendering del componente Volt di dettaglio principale
    Volt::test('organization.design.contest.detail', ['contest' => $this->contest])
        ->assertSet('contest.id', $this->contest->id)
        ->assertSet('organization.id', $this->organization->id)
        ->assertStatus(200);
});

test('contest detail page displays nested components and full info correctly', function () {
    // Esegue una richiesta HTTP GET sulla rotta di dettaglio
    $response = $this->get(route('organization.design.contest.detail', ['contest' => $this->contest]));

    $response->assertOk();

    // Verifichiamo la presenza dei 4 sotto-componenti Livewire Volt
    $response->assertSeeLivewire('organization.design.contest.detail-general1')
        ->assertSeeLivewire('organization.design.contest-section.details')
        ->assertSeeLivewire('organization.design.contest-award.details')
        ->assertSeeLivewire('organization.design.contest.detail-general2');

    // Verifichiamo la resa dei dati generali del Concorso
    $response->assertSee($this->contest->name_en)
        ->assertSee($this->organization->name);

    // Verifichiamo i dati delle Sezioni e delle Giurie
    $response->assertSee($this->contestSection->code)
        ->assertSee($this->contestSection->name_en)
        ->assertSee($this->juryUser->name);

    // Verifichiamo i dati dei Premi
    $response->assertSee($this->generalAward->award_name)
        ->assertSee($this->sectionAward->award_name);
});
