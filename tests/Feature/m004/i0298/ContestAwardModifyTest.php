<?php

/**
 * Organization Contest Design / ContestAward Modify component
 *
 * vendor/bin/pest tests/Feature/m004/i0297/ContestAwardModifyTest.php
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

    $this->contestSection1 = ContestSection::factory()->create([
        'contest_id' => $this->contest->id,
        'code' => 'A1',
        'under_patronage' => false,
        'name_en' => 'Prima Sezione',
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

    $this->contestSection2 = ContestSection::factory()->create([
        'contest_id' => $this->contest->id,
        'code' => 'B1',
        'under_patronage' => false,
        'name_en' => 'Seconda Sezione',
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

    // Premio esistente da modificare
    $this->contestAward = ContestAward::factory()->create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->contestSection1->id,
        'section_code' => $this->contestSection1->code,
        'award_code' => 'GOLD-01',
        'award_name' => 'Premio Primo Posto',
        'is_award' => true,
    ]);
});

test('component renders correctly for modifying a contest award', function () {
    Volt::test('organization.design.contest-award.modify', ['contest_award' => $this->contestAward])
        ->assertSet('contestAward.id', $this->contestAward->id)
        ->assertSet('contestAwardAwardCode', 'GOLD-01')
        ->assertSet('contestAwardAwardName', 'Premio Primo Posto')
        ->assertSet('contestAwardIsAward', true)
        ->assertStatus(200);
});

test('can modify an existing contest award name and status', function () {
    Volt::test('organization.design.contest-award.modify', ['contest_award' => $this->contestAward])
        ->set('contestAwardAwardName', 'Premio Primo Posto Modificato')
        ->set('contestAwardIsAward', false)
        ->call('modifyContestAward')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-award.listed', ['contest' => $this->contest]));

    $this->assertDatabaseHas('contest_awards', [
        'id' => $this->contestAward->id,
        'contest_id' => $this->contest->id,
        'section_id' => $this->contestSection1->id,
        'award_code' => 'GOLD-01',
        'award_name' => 'Premio Primo Posto Modificato',
        'is_award' => false,
    ]);
});

test('can modify contest award code replacing old record', function () {
    Volt::test('organization.design.contest-award.modify', ['contest_award' => $this->contestAward])
        ->set('contestAwardAwardCode', 'GOLD-MOD')
        ->set('contestAwardAwardName', 'Premio Con Codice Aggiornato')
        ->call('modifyContestAward')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-award.listed', ['contest' => $this->contest]));

    // Il vecchio record con il codice GOLD-01 deve essere stato eliminato (soft delete)
    $this->assertSoftDeleted('contest_awards', [
        'id' => $this->contestAward->id,
        'award_code' => 'GOLD-01',
    ]);

    // Il nuovo record deve essere stato creato con il nuovo codice
    $this->assertDatabaseHas('contest_awards', [
        'contest_id' => $this->contest->id,
        'section_id' => $this->contestSection1->id,
        'award_code' => 'GOLD-MOD',
        'award_name' => 'Premio Con Codice Aggiornato',
        'deleted_at' => null,
    ]);
});
