<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        Country::factory()->create([
            'iso3' => 'ITA',
            'country' => 'ITALY',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Country::factory()->create([
            'iso3' => 'FRA',
            'country' => 'FRANCE',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Country::factory()->create([
            'iso3' => 'GBR',
            'country' => 'UNITED KINGDOM OF GREAT BRITAIN AND NORTHERN IRELAND',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
