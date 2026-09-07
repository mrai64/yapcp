<?php

/**
 * Test for Contest Section Modification Feature
 *
 * Tests the Livewire Volt component for modifying a contest section (modify.blade.php)
 * Structure follows AAA pattern (Arrange, Act, Assert)
 */

namespace Tests\Features\m004\i0279;

use App\Models\User;
use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\ContestSection;
use App\Models\Federation;
use App\Models\FederationSection;
use App\Models\Organization;
use Livewire\Volt\Volt;

it('can render the contest section modify component', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create();

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->assertStatus(200);
});

it('initializes component with existing contest section data on mount', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create([
        'under_patronage' => false,
        'code' => 'OPEN',
        'name_en' => 'Open Theme',
        'name_local' => 'Tema Libero',
        'synopsis' => 'Open theme description',
        'file_formats' => 'jpg,png',
        'min_works' => 1,
        'max_works' => 4,
        'short_size_max' => 1920,
        'long_size_max' => 1080,
        'file_size_max' => 2000000,
        'monochromatic_required' => false,
        'raw_required' => false,
        'unique_prize' => true,
    ]);

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->assertSet('contestSectionUnderPatronage', false)
        ->assertSet('contestSectionCode', 'OPEN')
        ->assertSet('contestSectionNameEn', 'Open Theme')
        ->assertSet('contestSectionSynopsis', 'Open theme description')
        ->assertSet('contestSectionFileFormats', 'jpg,png')
        ->assertSet('contestSectionMinWorks', 1)
        ->assertSet('contestSectionMaxWorks', 4)
        ->assertSet('contestSectionShortSizeMax', 1920)
        ->assertSet('contestSectionLongSizeMax', 1080)
        ->assertSet('contestSectionFileSizeMax', 2000000)
        ->assertSet('contestSectionMonochromaticRequired', false)
        ->assertSet('contestSectionRawRequired', false)
        ->assertSet('contestSectionUniquePrize', true);
});

it('successfully modifies an existing contest section without patronage', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create([
        'under_patronage' => false,
        'code' => 'NAT',
        'name_en' => 'Nature',
        'file_formats' => 'jpg',
        'min_works' => 0,
        'max_works' => 4,
        'short_size_max' => 1000,
        'long_size_max' => 2000,
        'file_size_max' => 1000000,
    ]);

    // Act
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('contestSectionNameEn', 'Nature & Wildlife')
        ->set('contestSectionNameLocal', 'Natura e Vita Selvatica')
        ->set('contestSectionSynopsis', 'New synopsis for nature section')
        ->set('contestSectionFileFormats', 'jpg,png')
        ->set('contestSectionMinWorks', 1)
        ->set('contestSectionMaxWorks', 6)
        ->set('contestSectionShortSizeMax', 1200)
        ->set('contestSectionLongSizeMax', 2400)
        ->set('contestSectionFileSizeMax', 3000000)
        ->set('contestSectionMonochromaticRequired', true)
        ->set('contestSectionRawRequired', true)
        ->set('contestSectionUniquePrize', true)
        ->call('modifyContestSection');

    // Assert
    $contestSection->refresh();
    expect($contestSection->name_en)->toBe('Nature & Wildlife');
    expect($contestSection->name_local)->toBe('Natura e Vita Selvatica');
    expect($contestSection->synopsis)->toBe('New synopsis for nature section');
    expect($contestSection->file_formats)->toBe('jpg,png');
    expect($contestSection->min_works)->toBe(1);
    expect($contestSection->max_works)->toBe(6);
    expect($contestSection->short_size_max)->toBe(1200);
    expect($contestSection->long_size_max)->toBe(2400);
    expect($contestSection->file_size_max)->toBe(3000000);
    expect((bool) $contestSection->monochromatic_required)->toBeTrue();
    expect((bool) $contestSection->raw_required)->toBeTrue();
    expect((bool) $contestSection->unique_prize)->toBeTrue();
});

it('resets patronage fields when under patronage is toggled off', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $federation = Federation::first() ?? Federation::factory()->create(['id' => 'FIAP']);
    $federationSection = FederationSection::factory()->create([
        'federation_id' => $federation->id,
        'code' => 'COL',
    ]);

    $contestSection = ContestSection::factory()->create([
        'under_patronage' => true,
        'federation_section_id' => $federationSection->id,
        'code' => 'COL',
    ]);

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('contestSectionUnderPatronage', false)
        ->assertSet('selectedFederationId', null)
        ->assertSet('selectedSectionCode', null)
        ->assertSet('contestSectionFederationId', '')
        ->assertSet('contestSectionFederationSectionId', 0);
});

it('populates fields automatically when selecting federation and section under patronage', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $federation = Federation::first() ?? Federation::factory()->create(['id' => 'FIAP']);
    $federationSection = FederationSection::factory()->create([
        'federation_id' => $federation->id,
        'code' => 'TRAD',
        'name_en' => 'Traditional Photo',
        'synopsis' => 'Traditional photography description',
        'file_formats' => 'jpg',
        'min_works' => 1,
        'max_works' => 4,
        'short_size_max' => 1920,
        'long_size_max' => 1080,
        'file_size_max' => 2000000,
        'monochromatic_required' => 0,
        'raw_required' => 1,
        'unique_prize' => 0,
    ]);

    $contestSection = ContestSection::factory()->create([
        'under_patronage' => true,
    ]);

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('selectedFederationId', $federation->id)
        ->set('selectedSectionCode', 'TRAD')
        ->assertSet('contestSectionFederationId', $federation->id)
        ->assertSet('contestSectionFederationSectionId', $federationSection->id)
        ->assertSet('contestSectionCode', 'TRAD')
        ->assertSet('contestSectionNameEn', 'Traditional Photo')
        ->assertSet('contestSectionSynopsis', 'Traditional photography description')
        ->assertSet('contestSectionFileFormats', 'jpg')
        ->assertSet('contestSectionMinWorks', 1)
        ->assertSet('contestSectionMaxWorks', 4);
});

it('requires contestSectionNameEn field', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create();

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('contestSectionNameEn', '')
        ->call('modifyContestSection')
        ->assertHasErrors(['contestSectionNameEn' => 'required']);
});

it('validates file formats using ValidFileFormats rule', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create();

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('contestSectionFileFormats', 'exe,bat,sh')
        ->call('modifyContestSection')
        ->assertHasErrors(['contestSectionFileFormats']);
});

it('validates min_works and max_works constraints', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create();

    // Act & Assert: max_works must be greater than or equal to min_works
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('contestSectionMinWorks', 5)
        ->set('contestSectionMaxWorks', 2)
        ->call('modifyContestSection')
        ->assertHasErrors(['contestSectionMaxWorks' => 'gte']);
});

it('validates long_size_max must be greater than or equal to short_size_max', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contestSection = ContestSection::factory()->create();

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->set('contestSectionShortSizeMax', 2000)
        ->set('contestSectionLongSizeMax', 1000)
        ->call('modifyContestSection')
        ->assertHasErrors(['contestSectionLongSizeMax' => 'gte']);
});

it('redirects to contest-section listed route after successful update', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $contest = Contest::factory()->create();
    $contestSection = ContestSection::factory()->create([
        'contest_id' => $contest->id,
    ]);

    // Act & Assert
    Volt::test('organization.design.contest-section.modify', ['contest_section' => $contestSection])
        ->call('modifyContestSection')
        ->assertRedirect(route('organization.design.contest-section.listed', ['contest' => $contest]))
        ->assertSessionHas('success');
});
