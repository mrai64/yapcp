<?php

namespace Database\Seeders;

use App\Models\ContestSection;
use Illuminate\Database\Seeder;

class ContestSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ContestSection::factory()->create();
    }
}
