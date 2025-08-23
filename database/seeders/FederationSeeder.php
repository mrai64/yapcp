<?php

namespace Database\Seeders;

use App\Models\Federation;
use Database\Factories\FederationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Federation::factory()->count(2)->create();
    }
}
