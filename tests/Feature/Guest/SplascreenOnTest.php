<?php

/**
 * Basic test with Pest
 *
 * Not only page show but also a check for dummy db creation,
 * even if not used
 *
 * Memo: remember AAA
 * A arrange
 * A act
 * A assert
 */

use function Pest\Laravel\get;

// no uses(Illuminate\Foundation\Testing\RefreshDatabase::class);
// because we had TestCase.php

it('check homepage response ok', function () {
    // arrange

    // act
    // assert
    get('/')
        ->assertStatus(200);
});


it('check credits page response ok', function () {
    // arrange

    // act
    // assert
    get('/credits')
        ->assertStatus(200);
});
