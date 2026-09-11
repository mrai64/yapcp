<?php

/**
 * Organization Contest Design / ContestAward list index
 *
 * vendor/bin/pest tests/Feature/m004/i0296/ContestAwardListedTest.php
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\UserRole;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creiamo un utente e un concorso di prova
    $this->user = User::factory()->create();
    //
    $this->organization = Organization::factory()->create();
    //
    $this->memberOf = UserRole::factory()->create([
        'user_id' => $this->user->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(20)->format('Y-m-d\TH:i:s'),
        'role_closing' => now()->addDays(40)->format('Y-m-d\TH:i:s'),
    ]);
    $this->ActingAs($this->user);
    //
    $this->contest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
        'day_3_jury_opening' => now()->addDays(1)->format('Y-m-d H:i:s'),
        'day_4_jury_closing' => now()->addDays(10)->format('Y-m-d H:i:s'),
    ]);
    //
    $this->contestSection = ContestSection::factory()->create([

        'contest_id' => $this->contest->id,
        'code' => 'A1',
        'under_patronage' => false,
        'name_en' => 'A section',
        'name_local' => '',
        'synopsis' => '',
        'file_formats' => 'jpg', //            list of extension file
        'min_works' => 0, //               int # of works
        'max_works' => 1, //               int
        'short_size_max' => 2000, //          int px size
        'long_size_max' => 2000, //
        'file_size_max' => 2000000, //           int B
        'monochromatic_required' => false, //  bool 0/No, color 1/monochromatic
        'raw_required' => false, //            bool 0/No, 1/Raw required
        'unique_prize' => true, //            bool 0/More than an award per secton 1/only one award per section
    ]);
});

test('component rendered correctly when no awards exist', function () {
    // Si autentica l'utente e carica il componente Volt passando il $contest
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-award.listed', ['contest' => $this->contest])
        ->assertSet('contest.id', $this->contest->id)
        ->assertSet('contestAwardsSet', [])
        ->assertSee(__('Add first Award to your Contest'));
});

test('component correctly groups and orders awards by section code and priority', function () {
    $this->actingAs($this->user);

    // 1. Premio generale del concorso (section_code null -> raggruppato sotto '..')
    $awardGeneral = ContestAward::factory()->create([
        'contest_id'   => $this->contest->id,
        'section_id'   => null,
        'section_code' => null,
        'is_award'     => true,
        'award_code'   => 'GEN-01',
        'award_name'   => 'Primo Premio Generale',
        'winner_name'  => '', // no default
    ]);

    // 2. Premio di Sezione "A" - Primario (is_award = 1)
    $awardSecA1 = ContestAward::factory()->create([
        'contest_id'   => $this->contest->id,
        'section_id'   => $this->contestSection->id,
        'section_code' => 'SEC-A',
        'is_award'     => true,
        'award_code'   => 'A-01',
        'award_name'   => 'Primo Premio Sezione A',
        'winner_name'  => '', // no default
    ]);

    // 3. Premio di Sezione "A" - Secondario (is_award = 0)
    $awardSecA2 = ContestAward::factory()->create([
        'contest_id'   => $this->contest->id,
        'section_id'   => $this->contestSection->id,
        'section_code' => 'SEC-A',
        'is_award'     => false,
        'award_code'   => 'A-02',
        'award_name'   => 'Menzione Sezione A',
        'winner_name'  => '', // no default
    ]);

    // Test del componente
    Volt::test('organization.design.contest-award.listed', ['contest' => $this->contest])
        ->assertSee(__('Add Another Award'))

        // Verifica la presenza dei codici e nomi dei premi
        ->assertSee('GEN-01')
        ->assertSee('Primo Premio Generale')
        ->assertSee('SEC-A')
        ->assertSee('A-01')
        ->assertSee('Primo Premio Sezione A')
        ->assertSee('A-02')
        ->assertSee('Menzione Sezione A')

        // Verifica che la chiave '..' sia stata creata per i premi senza sezione
        ->assertViewHas('contestAwardsSet', function ($awardsSet) {
            return isset($awardsSet['..'])
                && isset($awardsSet['SEC-A'])
                && count($awardsSet['..']) === 1
                && count($awardsSet['SEC-A']) === 2;
        });
});

test('links for modifying and removing awards are present', function () {
    $this->actingAs($this->user);

    $award = ContestAward::factory()->create([
        'contest_id'   => $this->contest->id,
        'section_code' => 'SEC-B',
        'award_code'   => 'B-01',
        'award_name'   => 'Premio Speciale',
        'winner_name'  => '', // no default
    ]);

    $modifyUrl = route('organization.design.contest-award.modify', ['contest_award' => $award->id]);
    $removeUrl = route('organization.design.contest-award.remove', ['contest_award' => $award->id]);

    Volt::test('organization.design.contest-award.listed', ['contest' => $this->contest])
        ->assertSee($modifyUrl)
        ->assertSee($removeUrl);
});
