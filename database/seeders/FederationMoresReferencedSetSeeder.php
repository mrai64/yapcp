<?php

namespace Database\Seeders;

use App\Models\FederationMoresReferencedSet;
use Illuminate\Database\Seeder;

class FederationMoresReferencedSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fixed set - table name
        FederationMoresReferencedSet::factory()->create([
            'id' => 'user_contact_mores',
        ]);
        FederationMoresReferencedSet::factory()->create([
            'id' => 'user_work_mores',
        ]);
    }
}
