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
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    //
    protected function setUp(): void
    {

        // echo "\nTestCase start";
        parent::setUp(); // BaseTestCase

        // countries - delay for download file from web
        $this->seed(\Database\Seeders\CountrySeeder::class);

        // timezone' regions
        $this->seed(\Database\Seeders\TimezonesRegionSetSeeder::class);
        // timezones
        $this->seed(\Database\Seeders\TimezonesSeeder::class);

        // user role contexts
        $this->seed(\Database\Seeders\UserRolesContextSetSeeder::class);
        // user role roles
        $this->seed(\Database\Seeders\UserRolesRoleSetSeeder::class);
        // user roles pivot table context vs role w/ green/red flag
        $this->seed(\Database\Seeders\UserRolesRoleContextSeeder::class);

        // contest vote rules
        $this->seed(\Database\Seeders\ContestsVoteRuleSetSeeder::class);

        // federations
        $this->seed(\Database\Seeders\FederationSeeder::class);

        // federations more fields
        $this->seed(\Database\Seeders\FederationMoresReferencedSetsSeeder::class);

        // federations more fields
        $this->seed(\Database\Seeders\FederationMoreSeeder::class);

        // organizations
        $this->seed(\Database\Seeders\OrganizationSeeder::class);
        // echo "\nTestCase done\n";
    }
}
