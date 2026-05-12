<?php

/**
 * /tests/TestCase.php
 *
 * PHPUnit | Pest
 *
 * All the data loaded here is available in all test
 *
 * 2026-03-15 add countries
 * 2026-03-15 add timezoneregions
 * 2026-03-15 add timezones
 * 2026-03-15 add timezones
 *
 */

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //
    protected function setUp(): void
    {
        // echo "\nTestCase start";
        parent::setUp(); // BaseTestCase

        // countries - delay for download file from web
        $this->seed(\Database\Seeders\CountrySeeder::class);

        // timezone' regions
        $this->seed(\Database\Seeders\TimezoneRegionSetSeeder::class);

        // timezones
        $this->seed(\Database\Seeders\TimezonesSeeder::class);

        // user role contexts
        $this->seed(\Database\Seeders\UserRolesContextSetSeeder::class);

        // user role roles
        $this->seed(\Database\Seeders\UserRolesRoleSetSeeder::class);

        // user roles context role matrix w/green
        $this->seed(\Database\Seeders\UserRolesRoleContextsTableSeeder::class);

        // contest vote rules
        $this->seed(\Database\Seeders\ContestsVoteRuleSetSeeder::class);

        // federations
        $this->seed(\Database\Seeders\FederationSeeder::class);

        // federations more fields
        $this->seed(\Database\Seeders\FederationMoresReferencedTableSeeder::class);

        // federations more fields
        $this->seed(\Database\Seeders\FederationMoreSeeder::class);

        // organizations
        $this->seed(\Database\Seeders\OrganizationSeeder::class);
        // echo "\nTestCase done\n";
    }
}
