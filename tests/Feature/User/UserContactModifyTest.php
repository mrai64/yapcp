<?php

use App\Models\User;
use App\Models\UserContact;

beforeEach(function () {
    $this->user = User::factory()->create([
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
});

it('allows authenticated users to access user.contact.modify1 page', function () {
    $this->actingAs($this->user)
        ->get(route('user.contact.modify1', ['user_contact' => $this->userContact]))
        ->assertSuccessful()
        ->assertSeeLivewire('user.contact.modify1');
});

it('allows authenticated users to access user.contact.modify2 page', function () {
    $this->actingAs($this->user)
        ->get(route('user.contact.modify2', ['user_contact' => $this->userContact]))
        ->assertSuccessful()
        ->assertSeeLivewire('user.contact.modify2');
});

it('allows authenticated users to access user.contact.modify3 page', function () {
    $this->actingAs($this->user)
        ->get(route('user.contact.modify3', ['user_contact' => $this->userContact]))
        ->assertSuccessful()
        ->assertSeeLivewire('user.contact.modify3');
});

it('allows authenticated users to access user.contact.modify4 page', function () {
    $this->actingAs($this->user)
        ->get(route('user.contact.modify4', ['user_contact' => $this->userContact]))
        ->assertSuccessful()
        ->assertSeeLivewire('user.contact.modify4');
});

it('allows authenticated users to access user.contact.modify5 page', function () {
    $this->actingAs($this->user)
        ->get(route('user.contact.modify5', ['user_contact' => $this->userContact]))
        ->assertSuccessful()
        ->assertSeeLivewire('user.contact.modify5');
});

it('can access all user contact modify pages using a dataset', function (string $routeName) {
    $this->actingAs($this->user)
        ->get(route($routeName, ['user_contact' => $this->userContact]))
        ->assertSuccessful();
})->with([
    'user.contact.modify1',
    'user.contact.modify2',
    'user.contact.modify3',
    'user.contact.modify4',
    'user.contact.modify5',
]);

it('redirects unauthenticated users trying to access modify pages', function (string $routeName) {
    $this->get(route($routeName, ['user_contact' => $this->userContact]))
        ->assertRedirect(route('login'));
})->with([
    'user.contact.modify1',
    'user.contact.modify2',
    'user.contact.modify3',
    'user.contact.modify4',
    'user.contact.modify5',
]);
