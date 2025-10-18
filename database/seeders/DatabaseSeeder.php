<?php
/**
 * Database seeder
 * 
 * 2025-10-17 Class commented must be build
 *            or should remain commented
 * 
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
            CountrySeeder::class,
         // LanglistSeeder::class,
         // TimezonelistSeeder::class,
            FederationSeeder::class,
            FederationSectionSeeder::class,
         // OrganizationSeeder::class,
            UserSeeder::class,
         // UserContactSeeder::class,
            UserRoleRoleSetSeeder::class,
         // UserRoleSeeder::class,
            WorkSeeder::class,
         // ContestSeeder::class,
         // ContestSectionSeeder::class,
         // ContestJurySeeder::class,
         // ContestAwardSeeder::class,
         // ContestWorkSeeder::class,
         // ContestParticipantSeeder::class,
         // ContestVoteSeeder::class,
        ]);        
    }
}
