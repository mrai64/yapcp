<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->create();
});

test('admin can reach federation add page', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('federation.add'));

    $response->assertOk();
});

test('non admin user cannot reach federation add page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('federation.add'));

    $response->assertForbidden();
});

test('guest cannot reach federation add page', function () {
    $response = $this->get(route('federation.add'));

    $response->assertRedirect(route('login'));
});
