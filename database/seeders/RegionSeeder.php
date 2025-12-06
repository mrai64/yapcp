<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::factory()->create(['id' => 'Africa']);
        Region::factory()->create(['id' => 'America']);
        Region::factory()->create(['id' => 'Antarctica']);
        Region::factory()->create(['id' => 'Arctic']);
        Region::factory()->create(['id' => 'Asia']);
        Region::factory()->create(['id' => 'Atlantic']);
        Region::factory()->create(['id' => 'Australia']);
        Region::factory()->create(['id' => 'Europe']);
        Region::factory()->create(['id' => 'Indian']);
        Region::factory()->create(['id' => 'Pacific']);
    }
}
