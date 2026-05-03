<?php

/**
 * Contest are build from organization
 * 
 */
namespace Database\Seeders;

use App\Models\Contest;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Contest::factory()->create();
    }
}
