<?php

use App\Models\Timezone;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('authenticated user can access country listed page', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.timezone.listed'));

    $response->assertStatus(200)
        ->assertSee('Timezones Index');
});
