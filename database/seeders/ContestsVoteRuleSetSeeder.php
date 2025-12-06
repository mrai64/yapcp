<?php

namespace Database\Seeders;

use App\Models\ContestsVoteRuleSet;
use Illuminate\Database\Seeder;

class ContestsVoteRuleSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // actually it's only a label but should become a coded definition
        // num:1..30 == [1, 2, 3, ..., 29, 30];
        // star:1..5 == ['⭐️', '⭐️⭐️', '⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️']
        ContestsVoteRuleSet::factory()->create([
            'vote_rule' => 'num:1..10',
            'synopsis' => 'A simple numeric integer positive evaluation between 1 (worst) and 10 (best).',
        ]);
        ContestsVoteRuleSet::factory()->create([
            'vote_rule' => 'num:1..30',
            'synopsis' => 'A simple numeric integer positive evaluation between 1 (worst) and 30 (best).',
        ]);
        ContestsVoteRuleSet::factory()->create([
            'vote_rule' => 'star:1..5',
            'synopsis' => 'A simple graphic evaluation between ⭐️ (worst) and ⭐️⭐️⭐️⭐️⭐️ (best).',
        ]);
    }
}
