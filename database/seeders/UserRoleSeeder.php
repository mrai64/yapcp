<?php

namespace Database\Seeders;

use App\Models\UserContact;
use App\Models\UserRole;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        UserRole::factory()->create([
            'user_id' => UserContact::where('last_name', 'Rainato')
                ->where('first_name', 'Massimo')->pluck('id'),
            'role' => 'admin',
            'organization_id' => UserContact::where('last_name', 'Rainato')
                ->where('first_name', 'Massimo')->pluck('id'),
            'role_opening' => CarbonImmutable::now(),
            'role_closing' => CarbonImmutable::parse('9999-12-31T23:59:59'),
        ]);
        // UserRole::factory()->create(5);
    }
}
