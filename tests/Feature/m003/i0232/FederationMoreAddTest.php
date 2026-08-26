<?php

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationMoresReferencedSet;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione di un utente admin e di una federazione di riferimento
    $this->admin = User::factory()->admin()->create();
    $this->federation = Federation::factory()->create();
});

test('federation-more list access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.listed', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('federation-more add access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.add', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});


test('can create a federation more field record via volt component', function () {
    // 1. Assicuriamoci che esista un record valido nel set di tabelle referenziate
    $referencedSet = FederationMoresReferencedSet::factory()->create([
        'id' => 'contest_work_mores',
    ]);

    // 2. Agiamo come utente admin e testiamo il componente Volt Livewire
    $this->actingAs($this->admin);

    Volt::test('federation-more.add', ['federation' => $this->federation])
        ->set('fedMoreReferencedId', $referencedSet->id)
        ->set('fedMoreFieldName', 'nullCardId')
        ->set('fedMoreFieldLabel', 'FIAP Card ID')
        ->set('fedMoreValidationRules', 'nullable|string|max:50')
        ->set('fedMoreDefaultValue', '0000')
        ->set('fedMoreSuggest', 'Enter your official FIAP card ID number')
        ->call('addFederationMore')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-more.listed', ['federation' => $this->federation]))
        ->assertSessionHas('success');

    // 3. Verifichiamo che il record sia stato effettivamente salvato nel database
    $this->assertDatabaseHas('federation_mores', [
        'federation_id' => $this->federation->id,
        'referenced' => 'contest_work_mores',
        'field_name' => 'nullCardId',
        'field_label' => 'FIAP Card ID',
        'field_validation_rules' => 'nullable|string|max:50',
        'field_default_value' => '0000',
        'field_suggest' => 'Enter your official FIAP card ID number',
    ]);
});
