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
 * info:
 *   bash: php artisan test tests/Feature/user/LoginUserTest.php
 *   blade: /resources/livewire/pages/auth/login.blade.php
 *   controller: /app/Livewire/Forms/LoginForm.php
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

// c) test errors
it('fails validation with invalid inputs', function ($email, $password, $errorField) {
    // Act & Assert
    Volt::test('pages.auth.login')
        ->set('form.email', $email)
        ->set('form.password', $password)
        ->call('login')
        ->assertHasErrors(["form.$errorField"]);
})->with([
    // Arrange                email,          password,      field
    'empty email'         => ['',             'password123', 'email'],
    'wrong email'         => ['not-an-email', 'password123', 'email'],
    'empty password'      => ['test@example.com', '',        'password'],
    'too short password'  => ['test@example.com', '123',     'password'],
]);
