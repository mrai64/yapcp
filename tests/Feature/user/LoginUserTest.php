<?php

/**
 * Pest test learning
 * version for livewire w/breeze
 *
 * that's: LoginUserTest.php
 * Memo: remember AAA
 * A arrange
 * A act
 * A assert
 *
 * php artisan test tests/Feature/user/LoginUserTest.php
 *
 */

use App\Models\User;
use Livewire\Volt\Volt;

// a) test page reachable
it('can render login page ' . __FILE__, function () {
    $response = $this->get('/login');

    $response->assertOk();
});

// b) test page working
it('can authenticate using the login screen', function () {
    // 1. generate a on-fly user
    $user = User::factory()->create();

    // 2. test using component (under livewire/)
    // set     - arrange
    // call    - act
    // assert* - assert
    Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', $user->email) // it's a default in factory
        ->set('form.remember', true) // checkbox
        ->call('login') // method
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
