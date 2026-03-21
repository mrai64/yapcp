<?php

/**
 * Pest test learning
 * version base not livewire
 *
 * that's: FederationCreateTest.php
 * Memo: remember AAA
 * A arrange
 * A act
 * A assert
 *
 * info:
 *   bash: php artisan test tests/Feature/Admin/FederationCreateTest.php
 *   blade: /resources/views/federations/add.blade.php
 *   controller: /app/Http/Controllers/FederationController.php
 *
 */

use App\Models\Organization;
use App\Models\User;
use App\Models\UserRole;

// a) add federation - admin can see page
it('can render add federation page as admin ', function () {
    // arrange
    $user = User::factory()->create(); //
    $adminOrganization = Organization::whereName('.admin')->firstOrFail();
    $userRole = UserRole::factory()->create([
      // id
      'user_id'          => $user->id,
      'role'             => 'admin',
      'organization_id'  => $adminOrganization->id,
      'contest_id'       => null,
      'federation_id'    => null,
      // 'role_opening'     => now(),
      // 'role_closing'     => 9999-12-31 23:59:59
    ]);
    // echo "\n" . 'User: ' . json_encode($user);
    // echo "\n" . 'Organization: ' . json_encode($adminOrganization);
    // echo "\n" . 'UserRole: ' . json_encode($userRole);

    // act
    $response = $this->actingAs($user)
        ->get('/admin/federation/add'); // route('federation.add');
    // assert
    $response->assertOk();
});

// b) add federation - admin can use page
it('can use add federation page as admin ', function () {
    // arrange
    $user = User::factory()->create(); //
    $adminOrganization = Organization::whereName('.admin')->firstOrFail();
    $userRole = UserRole::factory()->create([
      // id
      'user_id'          => $user->id,
      'role'             => 'admin',
      'organization_id'  => $adminOrganization->id,
      'contest_id'       => null,
      'federation_id'    => null,
      // 'role_opening'     => now(),
      // 'role_closing'     => 9999-12-31 23:59:59
    ]);
    // act
    $response = $this->actingAs($user)
        ->get('/admin/federation/add');
    // assert
    $response->assertOk();

    // act
    $response = $this->actingAs($user)->post('/admin/federation/store', [
        //  form fields
            'federationName'   => 'A federation name',
            'federationId'     => 'FID',
            'countryId'        => 'ITA',
            'contactInfo'      => 'Mr. Massimo Rainato',
            'website'          => 'https://example.com',
        ]);

    // assert
    $response->assertSessionHasNoErrors(); // Verifica che non ci siano errori di validazione
    $response->assertRedirect(); // Solitamente dopo un post c'è un redirect
});

// c) test errors
it('cannot access page as not admin', function () {
    // arrange
    $user = User::factory()->create(); //
    $adminOrganization = Organization::whereName('.admin')->firstOrFail();
    $userRole = UserRole::factory()->create([
      // id
      'user_id'          => $user->id,
      'role'             => 'member', // not admin
      'organization_id'  => $adminOrganization->id,
      'contest_id'       => null,
      'federation_id'    => null,
      // 'role_opening'     => now(),
      // 'role_closing'     => 9999-12-31 23:59:59
    ]);
    // act
    $response = $this->actingAs($user)
        ->get('/admin/federation/add'); // route('federation.add');

    // assert
    $response->assertForbidden();
});

// d) form fields missing
it('fails validation with missing fields in form ', function ($federationName, $federationId, $countryId, $contactInfo, $website, $errorField) {
    // arrange
    $user = User::factory()->create(); //
    $adminOrganization = Organization::whereName('.admin')->firstOrFail();
    $userRole = UserRole::factory()->create([
      // id
      'user_id'          => $user->id,
      'role'             => 'admin',
      'organization_id'  => $adminOrganization->id,
      'contest_id'       => null,
      'federation_id'    => null,
      // 'role_opening'     => now(),
      // 'role_closing'     => 9999-12-31 23:59:59
    ]);
    // act
    $response = $this->actingAs($user)
        ->get('/admin/federation/add');
    // assert
    $response->assertOk();

    // act
    $response = $this->actingAs($user)->post('/admin/federation/store', [
        //  form fields
            'federationName'   => $federationName,
            'federationId'     => $federationId,
            'countryId'        => $countryId,
            'contactInfo'      => $contactInfo,
            'website'          => $website,
        ]);

    // assert
    $response->assertSessionHasErrors(); // Verifica che non ci siano errori di validazione
})->with([
    // Arrange
    'empty federationName' => ['',                  'FIDES', 'ITA', 'Mr. Massimo Rainato', 'https://example.com', 'federationName'],
    'empty federationId'   => ['A federation name', '',      'ITA', 'Mr. Massimo Rainato', 'https://example.com', 'federationId'],
    'empty countryId'      => ['A federation name', 'FIDES', '',    'Mr. Massimo Rainato', 'https://example.com', 'countryId'],
    'empty contactInfo'    => ['A federation name', 'FIDES', 'ITA', '',                    'https://example.com', 'contactInfo'],
    'empty website'        => ['A federation name', 'FIDES', 'ITA', 'Mr. Massimo Rainato', '',                    'website'],
]);
