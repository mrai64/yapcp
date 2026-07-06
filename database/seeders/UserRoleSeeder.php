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
        ds('Class ' . __CLASS__ . ' Rainato Massimo admin creating');
        $userId = UserContact::where('last_name', 'Rainato')
                ->where('first_name', 'Massimo')->pluck('id')->first();
        ds('Class ' . __CLASS__ . ' userId' . json_encode($userId) );
        // 1st as admin - read
        $adminRole = UserRole::factory()->make([
            'user_id' => $userId,
            'role' => 'admin',
            'organization_id' => (string) Organization::where('name', '.admin')->pluck('id')->first(),
            'contest_id' => null,
            'federation_id' => null,
            // 'role_opening' => CarbonImmutable::now(),
            // 'role_closing' => CarbonImmutable::parse('9999-12-31T23:59:59'),
        ])->toArray();
        ds('Class ' . __CLASS__ . ' adminRole' . json_encode($adminRole) );
        
        $adminCreate = UserRole::updateOrCreate(
            [
                'user_id'         => $adminRole['user_id'],
                'role'            => $adminRole['role'],
                'organization_id' => $adminRole['organization_id'],
            ],
            $adminRole
        );
        ds('Class ' . __CLASS__ . ' Rainato massimo admin created');
        UserRole::factory()->count(25)->create();
    }
}
