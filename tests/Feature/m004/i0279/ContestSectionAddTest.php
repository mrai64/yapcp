<?php

/**
 * Test for Contest Section Creation Feature
 * 
 * Related to issue #0279
 * Tests the Add Livewire component for creating contest sections
 * 
 * The contest section add feature allows:
 * - Create a new section (theme) for a contest
 * - Assign a section code (must be unique per contest)
 * - Set patronage status
 * - Provide multilingual names (English and local language)
 * 
 * Structure follows AAA pattern (Arrange, Act, Assert)
 */

namespace Tests\Features\m004\i0279;

use App\Livewire\Contest\Section\Add;
use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

// Uses RefreshDatabase from TestCase setup (seeders loaded in setUp)

it('can render the contest section add component', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->assertStatus(200);
});

it('initializes with empty form fields', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->assertSet('contest_id', $contest->id)
        ->assertSet('name_en', '')
        ->assertSet('name_local', '')
        ->assertSet('under_patronage', 'N');
});

it('loads existing sections code list on mount', function () {
    // Arrange
    $contest = Contest::factory()->create();
    
    // Create existing sections for this contest
    $section1 = ContestSection::factory()->create([
        'contest_id' => $contest->id,
        'code' => 'DIG',
    ]);
    $section2 = ContestSection::factory()->create([
        'contest_id' => $contest->id,
        'code' => 'PHO',
    ]);

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->assertSet('code_list', ['DIG', 'PHO']);
});

it('successfully creates a new contest section', function () {
    // Arrange
    $contest = Contest::factory()->create();
    
    $sectionData = [
        'code' => 'VID',
        'under_patronage' => 'N',
        'name_en' => 'Video Category',
        'name_local' => 'Categoria Video',
    ];

    // Act
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', $sectionData['code'])
        ->set('under_patronage', $sectionData['under_patronage'])
        ->set('name_en', $sectionData['name_en'])
        ->set('name_local', $sectionData['name_local'])
        ->call('addSectionToContest');

    // Assert
    expect(ContestSection::where('contest_id', $contest->id)
        ->where('code', 'VID')
        ->exists())->toBeTrue();
    
    $created = ContestSection::where('contest_id', $contest->id)
        ->where('code', 'VID')
        ->first();
    
    expect($created->name_en)->toBe('Video Category');
    expect($created->name_local)->toBe('Categoria Video');
    expect($created->under_patronage)->toBeFalse(); // stored as boolean
});

it('requires code field', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', '')
        ->set('name_en', 'Test Section')
        ->call('addSectionToContest')
        ->assertHasErrors(['code']);
});

it('requires name_en field', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('name_en', '')
        ->set('name_local', 'Test')
        ->call('addSectionToContest')
        ->assertHasErrors(['name_en']);
});

it('enforces uppercase code', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'vid')
        ->set('name_en', 'Video Section')
        ->call('addSectionToContest');

    // Assert - code should be automatically uppercased by validation rule
    $section = ContestSection::where('contest_id', $contest->id)->first();
    expect($section->code)->toBe('VID');
});

it('prevents duplicate section codes within same contest', function () {
    // Arrange
    $contest = Contest::factory()->create();
    
    ContestSection::factory()->create([
        'contest_id' => $contest->id,
        'code' => 'DIG',
    ]);

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'DIG')
        ->set('name_en', 'Another Digital Section')
        ->call('addSectionToContest')
        ->assertHasErrors(['code']);
});

it('allows same code in different contests', function () {
    // Arrange
    $contest1 = Contest::factory()->create();
    $contest2 = Contest::factory()->create();
    
    ContestSection::factory()->create([
        'contest_id' => $contest1->id,
        'code' => 'DIG',
    ]);

    // Act
    Livewire::test(Add::class, ['contest' => $contest2])
        ->set('code', 'DIG')
        ->set('name_en', 'Digital Section')
        ->call('addSectionToContest');

    // Assert
    expect(ContestSection::where('contest_id', $contest2->id)
        ->where('code', 'DIG')
        ->exists())->toBeTrue();
});

it('accepts under_patronage as Y or N', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act - with 'Y'
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'PAT1')
        ->set('under_patronage', 'Y')
        ->set('name_en', 'Patronage Section 1')
        ->call('addSectionToContest');

    // Assert
    $section1 = ContestSection::where('code', 'PAT1')->first();
    expect($section1->under_patronage)->toBeTrue();

    // Act - with 'N'
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'PAT2')
        ->set('under_patronage', 'N')
        ->set('name_en', 'Patronage Section 2')
        ->call('addSectionToContest');

    // Assert
    $section2 = ContestSection::where('code', 'PAT2')->first();
    expect($section2->under_patronage)->toBeFalse();
});

it('defaults to N for invalid under_patronage value', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('under_patronage', 'INVALID')
        ->set('name_en', 'Test Section')
        ->call('addSectionToContest');

    // Assert - invalid value should default to 'N'
    $section = ContestSection::where('code', 'TST')->first();
    expect($section->under_patronage)->toBeFalse();
});

it('validates code length maximum 10 characters', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'VERYLONGCODE')
        ->set('name_en', 'Test Section')
        ->call('addSectionToContest')
        ->assertHasErrors(['code']);
});

it('validates name_en length maximum 255 characters', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('name_en', str_repeat('a', 256))
        ->call('addSectionToContest')
        ->assertHasErrors(['name_en']);
});

it('validates name_local length maximum 255 characters', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('name_en', 'Test')
        ->set('name_local', str_repeat('a', 256))
        ->call('addSectionToContest')
        ->assertHasErrors(['name_local']);
});

it('allows empty name_local field', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('name_en', 'Test Section')
        ->set('name_local', '')
        ->call('addSectionToContest');

    // Assert - should create section successfully
    $section = ContestSection::where('code', 'TST')->first();
    expect($section)->not->toBeNull();
    expect($section->name_local)->toBeNull();
});

it('redirects to contest-section.add route after successful creation', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('name_en', 'Test Section')
        ->call('addSectionToContest')
        ->assertRedirect(route('organization.contest-section.add', ['contest' => $contest]));
});

it('displays success message after section creation', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act & Assert
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'TST')
        ->set('name_en', 'Test Section')
        ->call('addSectionToContest')
        ->assertSessionHas('success');
});

it('creates section with generated UUID primary key', function () {
    // Arrange
    $contest = Contest::factory()->create();

    // Act
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'UUID_TEST')
        ->set('name_en', 'UUID Test Section')
        ->call('addSectionToContest');

    // Assert
    $section = ContestSection::where('code', 'UUID_TEST')->first();
    
    // Verify UUID format (36 chars, valid UUID)
    expect(strlen($section->id))->toBe(36);
    expect(preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $section->id))->toBe(1);
});

it('creates section with correct contest_id reference', function () {
    // Arrange
    $contest1 = Contest::factory()->create();
    $contest2 = Contest::factory()->create();

    // Act - create section in contest1
    Livewire::test(Add::class, ['contest' => $contest1])
        ->set('code', 'TST1')
        ->set('name_en', 'Test Contest 1')
        ->call('addSectionToContest');

    // Act - create section in contest2
    Livewire::test(Add::class, ['contest' => $contest2])
        ->set('code', 'TST2')
        ->set('name_en', 'Test Contest 2')
        ->call('addSectionToContest');

    // Assert
    $section1 = ContestSection::where('code', 'TST1')->first();
    $section2 = ContestSection::where('code', 'TST2')->first();
    
    expect($section1->contest_id)->toBe($contest1->id);
    expect($section2->contest_id)->toBe($contest2->id);
});

it('preserves special characters in names', function () {
    // Arrange
    $contest = Contest::factory()->create();
    $specialName = "Photography & Art (2025)";

    // Act
    Livewire::test(Add::class, ['contest' => $contest])
        ->set('code', 'SPC')
        ->set('name_en', $specialName)
        ->call('addSectionToContest');

    // Assert
    $section = ContestSection::where('code', 'SPC')->first();
    expect($section->name_en)->toBe($specialName);
});
