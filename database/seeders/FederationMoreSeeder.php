<?php

namespace Database\Seeders;

use App\Models\FederationMore;
use Illuminate\Database\Seeder;

class FederationMoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // run after FederationMoresReferencedTableSeeder
        // run after FederationSeeder
        FederationMore::factory()->create([
            'federation_id' => 'FIAP',
            'referenced_table' => 'user_contacts',
            'field_name' => 'cardId', // may change ?personal number?
            'field_validation_rules' => 'required|string|size:6|regex:/^[0-9]+$/',
            'field_default_value' => '000000',
            'field_suggest' => 'Only 6 digit leading zeroes',
        ]);
        FederationMore::factory()->create([
            'federation_id' => 'FIAF',
            'referenced_table' => 'user_contacts',
            'field_name' => 'tessera',
            'field_validation_rules' => 'required|string|size:6|regex:/^[0-9]+$/',
            'field_default_value' => '000000',
            'field_suggest' => 'Only 6 digit leading zeroes',
        ]);
        FederationMore::factory()->create([
            'federation_id' => 'FIAF',
            'referenced_table' => 'user_works',
            'field_name' => 'reference_year',
            'field_validation_rules' => 'required|string|size:4|regex:/^[0-9]+$/',
            'field_default_value' => '2024',
            'field_suggest' => 'Year of first admission, in 4 digit form',
        ]);
    }
}
