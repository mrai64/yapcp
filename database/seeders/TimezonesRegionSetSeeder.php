<?php

namespace Database\Seeders;

use App\Models\TimezonesRegionSet;
use Illuminate\Database\Seeder;

class TimezonesRegionSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        TimezonesRegionSet::factory()->create(['id' => 'Africa']);
        TimezonesRegionSet::factory()->create(['id' => 'America']);
        TimezonesRegionSet::factory()->create(['id' => 'Antarctica']);
        TimezonesRegionSet::factory()->create(['id' => 'Arctic']);
        TimezonesRegionSet::factory()->create(['id' => 'Asia']);
        TimezonesRegionSet::factory()->create(['id' => 'Atlantic']);
        TimezonesRegionSet::factory()->create(['id' => 'Australia']);
        TimezonesRegionSet::factory()->create(['id' => 'Europe']);
        TimezonesRegionSet::factory()->create(['id' => 'Indian']);
        TimezonesRegionSet::factory()->create(['id' => 'Pacific']);
    }
}
