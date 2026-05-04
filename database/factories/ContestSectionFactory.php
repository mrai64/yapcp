<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;


/**
 * @extends Factory<ContestSection>
 */
class ContestSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // need a valid contest_id
        $contest = DB::table(Contest::TABLENAME)
            ->select('*')
            ->inRandomOrder()
            ->first();
        //
        $codeList = ['BN', 'CL', 'LB', 'NA'];
        $randIndex = array_rand($codeList, 1);

        return [
            'contest_id' => $contest->id,
            'code' => $codeList[$randIndex],
            'under_patronage' => '0',
            'name_en' => fake()->text(20),
            'name_local' => fake()->text(20),
        ];
    }
}
