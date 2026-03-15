<?php

/**
 * Pest test learning
 * naming with a numbering prefix ITS facultative
 *
 * that's: 01_HomepageOnTest.php
 * Memo: remember 3A
 * A arrange
 * A act
 * A assert
 */

use function Pest\Laravel\get;

// uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

it('check homepage response ok', function () {
  // arrange

  // act
  // assert
    get('/')
        ->assertStatus(200);
});