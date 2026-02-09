<?php

namespace Database\Seeders;

use App\Models\UserRolesContextSet;
use Illuminate\Database\Seeder;

class UserRolesContextSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRolesContextSet::factory()->create(['context_type' => 'contests']);
        UserRolesContextSet::factory()->create(['context_type' => 'organizations']);
        UserRolesContextSet::factory()->create(['context_type' => 'federations']);
    }
}
