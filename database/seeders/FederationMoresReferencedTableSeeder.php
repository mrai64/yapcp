<?php

namespace Database\Seeders;

use App\Models\FederationMoresReferencedTable;
use Illuminate\Database\Seeder;

class FederationMoresReferencedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fixed set - table name
        FederationMoresReferencedTable::factory()->create([
            'referenced_table' => 'user_contacts',
        ]);
        FederationMoresReferencedTable::factory()->create([
            'referenced_table' => 'user_works',
        ]);
    }
}
