<?php

use App\Models\User;
use App\Models\UserContact;

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
});

it('allows authenticated users with contact to access user.work.listed1 page', function () {
    $this->actingAs($this->user)
        ->get(route('user.work.listed1'))
        ->assertSuccessful()
        ->assertSeeLivewire('user.work.listed1');
});
