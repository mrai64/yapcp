<?php

namespace Database\Seeders;

use App\Models\Organization;
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
        $adminRole = UserRole::factory()->make([
            'user_id' => (string) UserContact::where('last_name', 'Rainato')
                ->where('first_name', 'Massimo')->pluck('id')->first(),
            'role' => 'admin',
            'organization_id' => (string) Organization::where('name', '.admin')->pluck('id')->first(),
            'contest_id' => null,
            'federation_id' => null,
            // 'role_opening' => CarbonImmutable::now(),
            // 'role_closing' => CarbonImmutable::parse('9999-12-31T23:59:59'),
        ])->toArray();

        UserRole::factory()->count(5)->create();
    }
}
