<?php

/**
 * check if a user_id and a contest_id live in the same record
 * into contest_awards table
 *
 * MUST be done in a 1-2 way,
 * 1st call with contest_id to memorize in session()
 * 2nd call with user_id to check both
 */

namespace App\Rules;

use App\Models\Contest;
use App\Models\ContestParticipant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;

class UserInContest implements ValidationRule
{
    #[Session(key: 'contest_id')]
    public $contest_id;

    public $user_id;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        Log::info('ValidationRule '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' in attribute:'.$attribute.' value:'.$value);

        // 1st contest_id
        if ($attribute === 'contest_id') {
            $this->contest_id = $value;
            // check
            $contest = Contest::where('id', $this->contest_id)->first();
            session()->put('contest_id', $value);
        }

        // 2nd
        if ($attribute === 'work_winner_id') {
            $this->contest_id = json_decode(session()->get('contest_id'));
            Log::info('ValidationRule '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' in attribute:'.$attribute.' value:'.$value);

            $check = ContestParticipant::where('contest_id', $this->contest_id)
                ->where('user_id', $value)->count();
            if ($check === 0) {
                $fail('🟥 Not found', null);
            }

            Log::info('ValidationRule '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' ✅ ok found');
        }
    }
}
