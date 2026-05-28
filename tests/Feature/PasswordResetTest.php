<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Features;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, 'Password updates are not enabled.');

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post('/forgot-password', [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, 'Password updates are not enabled.');

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post('/forgot-password', [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);

    $notification = Notification::sent($user, ResetPassword::class)->first();
    $response = $this->get('/reset-password/'.$notification->token);

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, 'Password updates are not enabled.');

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post('/forgot-password', [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);

    $notification = Notification::sent($user, ResetPassword::class)->first();
    $response = $this->post('/reset-password', [
        'token' => $notification->token,
        'email' => $user->email,
        'password' => 'Password@12345',
        'password_confirmation' => 'Password@12345',
    ]);

    $response->assertSessionHasNoErrors();
    expect(Hash::check('Password@12345', $user->fresh()->password))->toBeTrue();
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, 'Password updates are not enabled.');
