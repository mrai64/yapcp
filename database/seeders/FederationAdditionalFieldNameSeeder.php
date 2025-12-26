<?php

namespace Database\Seeders;

use App\Models\FederationAdditionalFieldName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FederationAdditionalFieldNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        // FederationAdditionalFieldName::factory()->count(10)->create();
        FederationAdditionalFieldName::factory()->create([
            'federation_id' => 'FIAF',
            'federation_field_name' => 'codice_fiscale', // lang:it
            'federation_field_label' => 'Codice Fiscale',
            'federation_field_validation_rules' => 'string|min:16|max:16|alpha_num',
            // 'federation_field_validation_rules' => 'codice_fiscale',
        ]);
        FederationAdditionalFieldName::factory()->create([
            'federation_id' => 'FIAF',
            'federation_field_name' => 'numero_tessera', // lang:it
            'federation_field_label' => 'ID TEssera',
            'federation_field_validation_rules' => 'integer|min:10000|max:999999',
        ]);
        //
    }
}
