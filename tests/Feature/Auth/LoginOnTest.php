<?php

/**
 * Pest test learning
 *
 * that's: LoginOnTest.php
 * Memo: remember AAA
 * A arrange
 * A act
 * A assert
 */

use function Pest\Laravel\get;

// uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

it('check login response ok', function () {
    // arrange

    // act
    // assert
    get('/login')
        ->assertStatus(200);
});
