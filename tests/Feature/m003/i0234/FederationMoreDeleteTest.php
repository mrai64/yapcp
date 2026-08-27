<?php


use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione di un utente admin e di una federazione di riferimento
    $this->admin = User::factory()->admin()->create();
    $this->federation = Federation::factory()->create([
      'country_id' => 'ITA'
    ]);
});

test('federation-more list access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.listed', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can reach federation-more remove page', function () {
    $federationMore = FederationMore::factory()->create([
      'referenced' => 'user_work_mores',
      'federation_id' => $this->federation->id,
      'field_name' => 'aField'
    ]);

    $this->actingAs($this->admin)
        ->get(route('federation-more.remove', $federationMore))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can remove a federation-more record', function () {
    $federationMore = FederationMore::factory()->create([
      'referenced' => 'user_work_mores',
      'federation_id' => $this->federation->id,
      'field_name' => 'aField'
    ]);

    $this->actingAs($this->admin);

    Volt::test('federation-more.remove', ['federation_more' => $federationMore])
        ->call('removeFederationMore')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-more.listed', $this->federation));

    $this->assertSoftDeleted($federationMore);
});
