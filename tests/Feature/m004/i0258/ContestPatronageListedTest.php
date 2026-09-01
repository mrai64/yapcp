<?php

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Country;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->country = Country::firstOrCreate(
        ['id' => 'ITA'],
        [
            'country' => 'Italy',
            'lang_code' => 'it_IT',
            'flag_code' => '🇮🇹',
        ]
    );

    $this->user = User::factory()->create();

    $this->organization = Organization::factory()->create([
        'country_id' => $this->country->id,
        'name' => 'Photographic Association Alpha',
    ]);

    // Contest creato al volo per i test
    $this->contest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
        'country_id' => $this->country->id,
        'name_en' => 'Annual International Photo Trophy 2026',
        'name_local' => 'Trofeo Fotografico Internazionale 2026',
    ]);
});

test('guest cannot access contest patronage listed page and is redirected to login', function () {
    $this->get(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertRedirect(route('login'));
});

test('authenticated user can access contest patronage listed page via HTTP get for a contest created on the fly', function () {
    $response = $this->actingAs($this->user)
        ->get(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]));

    $response->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.listed')
        ->assertSee(__('Federation Patronage Code Index'))
        ->assertSee(__('Annual International Photo Trophy 2026'))
        ->assertSee(route('user.dashboard'))
        ->assertSee(route('organization.dashboard', ['organization' => $this->organization]))
        ->assertSee(route('organization.design.contest-patronage.add', ['contest' => $this->contest]));
});

test('renders empty state when contest has no patronages assigned', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.listed', ['contest' => $this->contest])
        ->assertSet('contest.id', $this->contest->id)
        ->assertCount('contestPatronagesSet', 0)
        ->assertSee(__('Missing Patronage, but they are facultative... Add one?'))
        ->assertDontSee(__('Federation Patronage assigned to '));
});

test('renders list of patronages for a contest created on the fly with federation details and codes', function () {
    $countryFr = Country::firstOrCreate(
        ['id' => 'FRA'],
        [
            'country' => 'France',
            'lang_code' => 'fr_FR',
            'flag_code' => '🇫🇷',
        ]
    );

    $federation1 = Federation::factory()->create([
        'id' => 'IFIAF',
        'country_id' => $this->country->id,
        'name_en' => 'Federazione Italiana Associazioni Fotografiche',
    ]);

    $federation2 = Federation::factory()->create([
        'id' => 'IFIAP',
        'country_id' => $countryFr->id,
        'name_en' => 'Federation Internationale de l\'Art Photographique',
    ]);

    $patronage1 = ContestPatronage::create([
        'contest_id' => $this->contest->id,
        'federation_id' => $federation1->id,
        'patronage_code' => '2026/01',
    ]);

    $patronage2 = ContestPatronage::create([
        'contest_id' => $this->contest->id,
        'federation_id' => $federation2->id,
        'patronage_code' => '2026/999',
    ]);

    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.listed', ['contest' => $this->contest])
        ->assertSet('contest.id', $this->contest->id)
        ->assertCount('contestPatronagesSet', 2)
        ->assertSee(__('Federation Patronage assigned to '))
        ->assertSee('Annual International Photo Trophy 2026')
        ->assertSee(__('Not in priority order'))
        // Federation 1 details
        ->assertSee($this->country->flag_code)
        ->assertSee('IFIAF')
        ->assertSee('2026/01')
        ->assertSee('Federazione Italiana Associazioni Fotografiche')
        // Federation 2 details
        ->assertSee($countryFr->flag_code)
        ->assertSee('IFIAP')
        ->assertSee('2026/999')
        ->assertSee('Federation Internationale de l\'Art Photographique')
        // Empty state must not be visible
        ->assertDontSee(__('Missing Patronage, but they are facultative... Add one?'));
});

test('only displays patronages belonging to the specific contest and ignores other contests', function () {
    $otherContest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
        'country_id' => $this->country->id,
        'name_en' => 'Other Contest 2026',
    ]);

    $federation = Federation::factory()->create([
        'id' => 'GPUFED',
        'country_id' => $this->country->id,
        'name_en' => 'Global Photographic Union',
    ]);

    // Patronage associato a un altro concorso
    ContestPatronage::create([
        'contest_id' => $otherContest->id,
        'federation_id' => $federation->id,
        'patronage_code' => 'GPU-2026-99',
    ]);

    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.listed', ['contest' => $this->contest])
        ->assertCount('contestPatronagesSet', 0)
        ->assertSee(__('Missing Patronage, but they are facultative... Add one?'))
        ->assertDontSee('GPU-2026-99')
        ->assertDontSee('Global Photographic Union');
});
