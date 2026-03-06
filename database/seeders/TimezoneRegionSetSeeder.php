<?php

namespace Database\Seeders;

use App\Models\TimezoneRegionSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimezoneRegionSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        TimezoneRegionSet::factory()->create(['id' => 'Africa']);
        TimezoneRegionSet::factory()->create(['id' => 'America']);
        TimezoneRegionSet::factory()->create(['id' => 'Antarctica']);
        TimezoneRegionSet::factory()->create(['id' => 'Arctic']);
        TimezoneRegionSet::factory()->create(['id' => 'Asia']);
        TimezoneRegionSet::factory()->create(['id' => 'Atlantic']);
        TimezoneRegionSet::factory()->create(['id' => 'Australia']);
        TimezoneRegionSet::factory()->create(['id' => 'Europe']);
        TimezoneRegionSet::factory()->create(['id' => 'Indian']);
        TimezoneRegionSet::factory()->create(['id' => 'Pacific']);
    }
}
