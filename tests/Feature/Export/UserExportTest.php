<?php

/**
 * Export test
 * - user Export
 * - FIAF 1 participants Export
 * - FIAF 2
 *
 */

use App\Models\User;
use App\Exports\UserExport;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

// uses(RefreshDatabase::class);

it('UserExport genera una risposta valida', function () {
    User::factory()->count(3)->create();

    $response = (new UserExport())->download('utenti.xlsx');

    expect($response)->toBeInstanceOf(StreamedResponse::class);
});
