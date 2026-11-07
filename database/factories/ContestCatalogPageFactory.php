<?php

/**
 * no factory for contest catalog page
 *
 */

namespace Database\Factories;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\ContestCatalogPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContestCatalogPage>
 */
class ContestCatalogPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var Contest $contest */
        $contest = Contest::inRandomOrder()->first() ?? Contest::factory()->create();
        /** @var ContestSection $section */
        $section = $contest->contestSections()->inRandomOrder()->first()
            ?? ContestSection::factory()->create(['contest_id' => $contest->id]);
        /** @var ContestAward $award */
        $award = $contest->contestAwards()->inRandomOrder()->first()
            ?? ContestAward::factory()->create(['contest_id' => $contest->id]);

        return [
            // id
            'contest_id'          => $contest->id,
            'contest_section_id'  => $section->id,

        ];
    }
}
