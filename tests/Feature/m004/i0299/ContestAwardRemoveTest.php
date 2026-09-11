<?php

/**
 * Organization Contest Design / ContestAward Remove component test
 *
 * vendor/bin/pest tests/Feature/m004/i0297/ContestAwardRemoveTest.php
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

    // Premio 1: verrà rimosso nel test
    $this->contestAward1 = ContestAward::factory()->create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->contestSection1->id,
        'section_code' => $this->contestSection1->code,
        'award_code' => 'GOLD-01',
        'award_name' => 'Premio Primo Posto - Sezione 1',
        'is_award' => true,
    ]);

    // Premio 2: rimarrà inalterato nel concorso
    $this->contestAward2 = ContestAward::factory()->create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->contestSection2->id,
        'section_code' => $this->contestSection2->code,
        'award_code' => 'GOLD-02',
        'award_name' => 'Premio Primo Posto - Sezione 2',
        'is_award' => true,
    ]);
});

test('component renders correctly for removing a contest award', function () {
    Volt::test('organization.design.contest-award.remove', ['contest_award' => $this->contestAward1])
        ->assertSet('contestAward.id', $this->contestAward1->id)
        ->assertSet('contestAwardAwardCode', 'GOLD-01')
        ->assertSet('contestAwardAwardName', 'Premio Primo Posto - Sezione 1')
        ->assertSet('contestAwardIsAward', true)
        ->assertStatus(200);
});

test('can remove a contest award successfully', function () {
    Volt::test('organization.design.contest-award.remove', ['contest_award' => $this->contestAward1])
        ->call('removeContestAward')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-award.listed', ['contest' => $this->contest]));

    // Verifica che il premio 1 sia stato eliminato tramite Soft Delete
    $this->assertSoftDeleted('contest_awards', [
        'id' => $this->contestAward1->id,
        'award_code' => 'GOLD-01',
    ]);

    // Verifica che il premio 2 non sia stato toccato
    $this->assertDatabaseHas('contest_awards', [
        'id' => $this->contestAward2->id,
        'award_code' => 'GOLD-02',
        'deleted_at' => null,
    ]);
});
