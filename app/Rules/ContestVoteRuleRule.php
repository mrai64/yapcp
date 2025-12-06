<?php

/**
 * work in progress
 * work in progress
 * Apply in validation rules following contest.vote_role label
 *
 * In contests.vote_rule it's applied a label that' used here to
 * made the corresponding validation rule.
 * from contest_vote > contest > contest.vote_rule > switch
 *
 * As validation apply in sequence, we put a session() value
 * to maintain a value between different call, in order:
 * 1. contest_id (to pick contests.vote_rule)
 * 2. vote
 *
 * work in progress
 * work in progress
 */

namespace App\Rules;

use App\Models\Contest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class ContestVoteRuleRule implements ValidationRule
{
    public $contest;

    public $contest_id;

    public $vote_rule;

    /**
     * rule for label "num:1..10"
     * integer between 1 and 10
     * in_array['1',..'10']
     */

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        Log::info('ValidationRule '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' in: attribute:'.$attribute.', value:'.$value);

        // contest_id
        if ($attribute === 'contest_id') {
            $this->contest = Contest::where('id', $value)->first();
            $this->vote_rule = $this->contest->vote_rule;
            Log::info('ValidationRule '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' vote_rule:'.json_encode($this->vote_rule));

            return;
        }

        // vote follow vote_rule?
        switch ($this->vote_rule) {
            case 'value':
                // code...
                break;

            case 'value':
                // code...
                break;

            case 'value':
                // code...
                break;

            default:
                $fail(_("Seems a trouble w/vote_rule. It's not your fault. message to platform manager."));
                break;
        }
    }
}
