<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContestsVoteRuleSet>
 */
class ContestsVoteRuleSetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vote_rule' => fake()->text(20),
            'synopsis' => fake()->sentence(35, true),
        ];
    }
}
