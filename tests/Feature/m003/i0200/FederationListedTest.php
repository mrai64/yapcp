<?php

use App\Models\Country;
use App\Models\Federation;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->admin()->create();
});

test('guest cannot access federation listed page and is redirected to login', function () {
    $this->get(route('federation.listed'))
        ->assertRedirect(route('login'));
});

test('regular user can access federation listed page via HTTP get', function () {
    $response = $this->actingAs($this->user)
        ->get(route('federation.listed'));

    $response->assertSuccessful()
        ->assertSeeLivewire('federation.listed')
        ->assertSee(__('Federations'))
        ->assertSee(route('user.dashboard'))
        // Admin actions are hidden
        ->assertDontSee(__('Add New Federation'))
        ->assertDontSee(route('federation.add'))
        ->assertDontSee('Update')
        ->assertDontSee('Removable');
});

test('admin user can access federation listed page via HTTP get and sees admin controls', function () {
    $firstFederation = Federation::first();

    $response = $this->actingAs($this->admin)
        ->get(route('federation.listed'));

    $response->assertSuccessful()
        ->assertSeeLivewire('federation.listed')
        ->assertSee(__('Federations'))
        ->assertSee(route('user.dashboard'))
        // Admin actions are visible
        ->assertSee('Add New Federation')
        ->assertSee(route('federation.add'))
        ->assertSee('Update')
        ->assertSee(route('federation.modify', ['federation' => $firstFederation]))
        ->assertSee('Removable')
        ->assertSee(route('federation.remove', ['federation' => $firstFederation]));
});

test('displays empty state message when no federations exist', function () {
    Federation::query()->delete();

    $this->actingAs($this->user);

    Volt::test('federation.listed')
        ->assertSee(__('There are no Federation in platform, at now. Check the manual to run Federation*Seeker or add first manually.'));
});

test('regular user renders Volt component with federations but without modification links', function () {
    $firstFederation = Federation::first();

    $this->actingAs($this->user);

    Volt::test('federation.listed')
        ->assertViewHas('isAdmin', false)
        ->assertSee($firstFederation->name_en)
        ->assertSee($firstFederation->id)
        ->assertSee('Federation Sections')
        ->assertSee(route('federation-section.listed', ['federation' => $firstFederation]))
        // Update and Remove links must NOT be visible for regular users
        ->assertDontSee('Update')
        ->assertDontSee(route('federation.modify', ['federation' => $firstFederation]))
        ->assertDontSee('Removable')
        ->assertDontSee(route('federation.remove', ['federation' => $firstFederation]));
});

test('admin user renders Volt component with federations and with modification and removal links', function () {
    $firstFederation = Federation::first();

    $this->actingAs($this->admin);

    Volt::test('federation.listed')
        ->assertViewHas('isAdmin', true)
        ->assertSee($firstFederation->name_en)
        ->assertSee($firstFederation->id)
        ->assertSee('Federation Sections')
        ->assertSee(route('federation-section.listed', ['federation' => $firstFederation]))
        // Update and Remove links MUST be visible for admin users
        ->assertSee('Update')
        ->assertSee(route('federation.modify', ['federation' => $firstFederation]))
        ->assertSee('Removable')
        ->assertSee(route('federation.remove', ['federation' => $firstFederation]));
});

test('renders federation details properly including website, contact info, and local name', function () {
    $country = Country::firstOrCreate(
        ['id' => 'JPN'],
        ['country' => 'Japan', 'lang_code' => 'ja_JP']
    );

    $federation = Federation::factory()->create([
        'id' => 'JPSFED',
        'country_id' => $country->id,
        'name_en' => 'Japan Photographic Society Test',
        'local_lang' => 'ja',
        'name_local' => '日本写真協会',
        'timezone_id' => 'Asia/Tokyo',
        'website' => 'https://example.jp/photo',
        'contact_info' => 'Tokyo headquarters info',
    ]);

    $this->actingAs($this->user);

    Volt::test('federation.listed')
        ->assertSee('JPSFED')
        ->assertSee('Japan Photographic Society Test')
        ->assertSee('日本写真協会')
        ->assertSee('https://example.jp/photo')
        ->assertSee('Tokyo headquarters info')
        ->assertSee('Asia/Tokyo');
});
