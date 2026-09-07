<?php

/**
 * Pest Test: ContestSection Delete / Removal
 *
 * Test coverage for deleting a ContestSection record using Pest PHP framework.
 * Path: tests/Feature/ContestSectionDeleteTest.php
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    // Set up a user and contest for testing
    $this->user = User::factory()->create();
    $this->contest = Contest::factory()->create();
    
    // Create a contest section attached to the contest
    $this->contestSection = ContestSection::factory()->create([
        'contest_id' => $this->contest->id,
        'code' => 'OPEN-COL',
        'name_en' => 'Open Color',
        'name_local' => 'Colore Libero',
        'min_works' => 0,
        'max_works' => 4,
        'short_size_max' => 1080,
        'long_size_max' => 1920,
        'file_size_max' => 5000,
        'monochromatic_required' => false,
        'raw_required' => false,
        'unique_prize' => false,
    ]);
});

test('a contest section can be soft deleted directly via model', function () {
    $sectionId = $this->contestSection->id;

    // Perform soft delete on model
    $this->contestSection->delete();

    // Verify record is soft deleted in database (deleted_at is set)
    assertSoftDeleted('contest_sections', [
        'id' => $sectionId,
    ]);

    // Ensure model is not present in normal query
    expect(ContestSection::find($sectionId))->toBeNull();

    // Ensure model is present in withTrashed query
    expect(ContestSection::withTrashed()->find($sectionId))->not->toBeNull();
});

test('authenticated user can view the section remove confirm page', function () {
    // Assuming route follows standard convention or Livewire route structure
    $response = actingAs($this->user)
        ->get(route('organization.design.contest-section.remove', [
            'contest' => $this->contest->id,
            'contest_section' => $this->contestSection->id,
        ]));

    $response->assertStatus(200);
    $response->assertSee($this->contestSection->name_en);
});

test('authenticated authorized user can remove a contest section via livewire / route action', function () {
    actingAs($this->user);

    // Testing Livewire Volt component for section removal if applicable
    if (class_exists(\Livewire\Livewire::class)) {
        \Livewire\Livewire::test('organization.design.contest-section.remove', [
            'contestSection' => $this->contestSection,
        ])
        ->call('removeContestSection')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-section.listed', ['contest' => $this->contest]));
    } else {
        // Fallback HTTP DELETE route assertion
        $response = delete(route('organization.design.contest-section.destroy', [
            'contest_section' => $this->contestSection->id,
        ]));

        $response->assertRedirect();
    }

    // Verify soft deletion in database
    assertSoftDeleted('contest_sections', [
        'id' => $this->contestSection->id,
    ]);
});

test('guest user cannot delete a contest section', function () {
    $sectionId = $this->contestSection->id;

    // Attempt action as guest
    $response = delete(route('organization.design.contest-section.destroy', [
        'contest_section' => $sectionId,
    ]));

    $response->assertRedirect(route('login'));

    // Assert record is still active in database
    assertDatabaseHas('contest_sections', [
        'id' => $sectionId,
        'deleted_at' => null,
    ]);
});

test('a soft deleted contest section can be force deleted permanently', function () {
    $sectionId = $this->contestSection->id;

    $this->contestSection->delete();
    $this->contestSection->forceDelete();

    // Verify complete removal from database
    assertDatabaseMissing('contest_sections', [
        'id' => $sectionId,
    ]);
});
