<?php

use App\Models\User;
use App\Models\UserContact;
use App\Models\UserWork;
use App\Notifications\WorkUpdatedNotification;
use Illuminate\Support\Facades\Notification;
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
        'title_en' => 'Original Title',
        'is_monochromatic' => false,
        'has_raw_file' => false,
    ]);
});

it('allows authenticated user to access user.work.modify page', function () {
    $this->actingAs($this->user)
        ->get(route('user.work.modify', $this->userWork))
        ->assertSuccessful()
        ->assertSeeLivewire('user.work.modify');
});

it('redirects unauthenticated user trying to access user.work.modify page', function () {
    $this->get(route('user.work.modify', $this->userWork))
        ->assertRedirect(route('login'));
});

it('allows an authenticated user to update their user work', function () {
    Notification::fake();

    $this->actingAs($this->user);

    Volt::test('user.work.modify', ['user_work' => $this->userWork])
        ->set('userWorkTitleEn', 'Updated Title')
        ->set('userWorkIsMonochromatic', true)
        ->set('userWorkRawAvailable', true)
        ->call('updateUserWork')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('user_works', [
        'id' => $this->userWork->id,
        'title_en' => 'Updated Title',
        'is_monochromatic' => true,
        'has_raw_file' => true,
    ]);

    Notification::assertSentTo(
        $this->user,
        WorkUpdatedNotification::class
    );
});

it('fails validation when updating with an empty title', function () {
    $this->actingAs($this->user);

    Volt::test('user.work.modify', ['user_work' => $this->userWork])
        ->set('userWorkTitleEn', '')
        ->call('updateUserWork')
        ->assertHasErrors(['userWorkTitleEn']);
});
