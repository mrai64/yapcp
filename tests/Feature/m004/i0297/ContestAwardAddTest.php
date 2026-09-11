<?php

/**
 * Organization Contest Design / ContestAward Add component
 *
 * vendor/bin/pest tests/Feature/m004/i0297/ContestAwardAddTest.php
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

    $this->organization = Organization::factory()->create();

    $this->memberOf = UserRole::factory()->create([
        'user_id' => $this->user->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(20)->format('Y-m-d\TH:i:s'),
        'role_closing' => now()->addDays(40)->format('Y-m-d\TH:i:s'),
    ]);
    $this->actingAs($this->user);

    $this->contest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
        'day_3_jury_opening' => now()->addDays(1)->format('Y-m-d H:i:s'),
        'day_4_jury_closing' => now()->addDays(10)->format('Y-m-d H:i:s'),
    ]);

    $this->contestSection = ContestSection::factory()->create([
        'contest_id' => $this->contest->id,
        'code' => 'A1',
        'under_patronage' => false,
        'name_en' => 'A section',
        'name_local' => '',
        'synopsis' => '',
        'file_formats' => 'jpg',
        'min_works' => 0,
        'max_works' => 1,
        'short_size_max' => 2000,
        'long_size_max' => 2000,
        'file_size_max' => 2000000,
        'monochromatic_required' => false,
        'raw_required' => false,
        'unique_prize' => true,
    ]);
});

test('component renders correctly for creating a contest award', function () {
    Volt::test('organization.design.contest-award.add', ['contest' => $this->contest])
        ->assertSet('contest.id', $this->contest->id)
        ->assertStatus(200);
});

test('can add a general contest award when section_id is null', function () {
    Volt::test('organization.design.contest-award.add', ['contest' => $this->contest])
        ->set('contestAwardSectionId', '') // nel mount() è inizializzata come stringa vuota ''
        ->set('contestAwardAwardCode', 'GEN-01')
        ->set('contestAwardAwardName', 'Primo Premio Generale')
        ->set('contestAwardIsAward', true)
        ->call('addContestAward')
        ->assertHasNoErrors();

    // Verifica la persistenza nel database usando le colonne del model/DB
    $this->assertDatabaseHas('contest_awards', [
        'contest_id'   => $this->contest->id,
        'section_id'   => null,
        'award_code'   => 'GEN-01',
        'award_name'   => 'Primo Premio Generale',
        'is_award'     => true,
    ]);
});

test('can add a section contest award when section_id is set to a valid section', function () {
    Volt::test('organization.design.contest-award.add', ['contest' => $this->contest])
        ->set('contestAwardSectionId', $this->contestSection->id)
        ->set('contestAwardAwardCode', 'SEC-01')
        ->set('contestAwardAwardName', 'Primo Premio Sezione A')
        ->set('contestAwardIsAward', true)
        ->call('addContestAward')
        ->assertHasNoErrors();

    // Verifica la persistenza nel database usando le colonne del model/DB
    $this->assertDatabaseHas('contest_awards', [
        'contest_id'   => $this->contest->id,
        'section_id'   => $this->contestSection->id,
        'award_code'   => 'SEC-01',
        'award_name'   => 'Primo Premio Sezione A',
        'is_award'     => true,
    ]);
});
