<?php

use App\Models\User;
use App\Models\UserContact;
use App\Models\UserWork;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Rossi, Mario',
        'email_verified_at' => now(),
    ]);

    $this->userContact = UserContact::firstOrCreate(
        ['id' => $this->user->id],
        [
            'email' => $this->user->email,
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'country_id' => 'ITA',
        ]
    );

    $this->userWork = UserWork::factory()->create([
        'user_id' => $this->user->id,
        'title_en' => 'Test Image To Remove',
        'is_monochromatic' => false,
        'has_raw_file' => false,
    ]);
});

it('allows authenticated user to access user.work.remove page', function () {
    $this->actingAs($this->user)
        ->get(route('user.work.remove', $this->userWork))
        ->assertSuccessful()
        ->assertSeeLivewire('user.work.remove');
});

it('redirects unauthenticated user trying to access user.work.remove page', function () {
    $this->get(route('user.work.remove', $this->userWork))
        ->assertRedirect(route('login'));
});

it('allows an authenticated user to remove (soft delete) their user work', function () {
    $this->actingAs($this->user);

    Volt::test('user.work.remove', ['user_work' => $this->userWork])
        ->call('removeUserWork')
        ->assertRedirect(route('user.dashboard'));

    $this->assertSoftDeleted('user_works', [
        'id' => $this->userWork->id,
    ]);
});
