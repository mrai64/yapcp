<?php

/**
 * after
 * - countries
 */

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin organization is
        $adminFirst = Organization::factory()->make([
            'country_id' => 'ITA',
            'name' => '.admin',
            'email' => 'yapcp.admin.group@athesis77.it',
            'website' => 'https://yapcp.org/',
            'contact' => 'Mr Massimo Rainato - yaPCP founder\nemail: massimo.rainato@gmail.com',
        ])->toArray();
        $organization = Organization::firstOrCreate(
            ['name' => $adminFirst['name']],
            $adminFirst
        );
        Organization::factory()->count(5)->create();
    }
}
