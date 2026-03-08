<?php

/**
 * Database seeder
 *
 * 2025-10-17 Class commented must be build
 *            or should remain commented
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // lookup tables
            CountrySeeder::class,
            TimezoneRegionSetSeeder::class,
            TimezonesSeeder::class,
            UserRolesContextSetSeeder::class,
            UserRolesRoleSetSeeder::class,
            // UserRolesRoleContextSeeder::class,
            UserRolesRoleContextsTableSeeder::class,
            ContestsVoteRuleSetSeeder::class,
            //
            FederationSeeder::class,
            FederationSectionSeeder::class,
            OrganizationSeeder::class,
            UserSeeder::class,
            // UserContactSeeder::class, // in UserSeeder
            // UserRoleSeeder::class,
            // UserWorkSeeder::class,
            // ContestSeeder::class,
            // ContestSectionSeeder::class,
            // ContestJurySeeder::class,
            // ContestAwardSeeder::class,
            // ContestWorkSeeder::class,
            // ContestParticipantSeeder::class,
        ]);
        $this->call(UserRolesRoleContextsTableSeeder::class);
    }
}
