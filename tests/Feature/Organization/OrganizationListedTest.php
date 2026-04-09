<?php

use App\Livewire\Organization\Listed;
use App\Models\User;
use Livewire\Livewire;

it('renders the organization list', function () {
    // Arrange
    $user = User::factory()->create();

    // Act & Assert
    Livewire::actingAs($user)
        ->test(Listed::class)
        ->assertStatus(200)
        ->assertSet('organization_list', function ($list) {
            return $list->isNotEmpty();
        });
});
