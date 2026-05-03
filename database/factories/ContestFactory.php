<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<Contest>
 */
class ContestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // need a valid organization.id
        $organization = DB::table(Organization::TABLENAME)
            ->select('*')
            ->inRandomOrder()
            ->first();

        $opening = now()->addDays(rand(1, 30)); // from tomorrow to next month

        return [
            'organization_id' => $organization->id,
            'country_id' => $organization->country_id,
            'name_en' => fake()->text(20),
            'name_local' => fake()->text(20),
            'contact_info' => 'HQ ' . $organization->name . '\n'
                . 'email: ' . $organization->email . '\n'
                . 'website: ' . $organization->website,
            'is_circuit' => 'N',
            'timezone_id' => 'Europe/Rome',
            'day_1_opening'      => $opening,
            'day_2_closing'      => $opening->addMonths(2),
            'day_3_jury_opening' => $opening->addMonths(2)->addDays(2),
            'day_4_jury_closing' => $opening->addMonths(2)->addDays(10),
            'day_5_revelations'  => $opening->addMonths(2)->addDays(15),
            'day_6_awards'       => $opening->addMonths(3),
            'day_7_catalogues'   => $opening->addMonths(3)->addDays(7),
            'day_8_closing'      => $opening->addMonths(4),
            'award_ceremony_info' => 'online',
            'fee_info' => 'Free participation',
            'vote_rule' => 'num:1..30',
        ];
    }
}
