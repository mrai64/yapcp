<?php

namespace Database\Seeders;

use App\Models\FederationMoresReferencedTable;
use Illuminate\Database\Seeder;

class FederationMoresReferencedSetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fixed set - table name
        FederationMoresReferencedSets::factory()->create([
            'id' => 'user_contact_mores',
        ]);
        FederationMoresReferencedSets::factory()->create([
            'id' => 'user_work_mores',
        ]);
    }
}
