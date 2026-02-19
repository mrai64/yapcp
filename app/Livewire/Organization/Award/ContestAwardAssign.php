<?php

/**
 * Form to assign in contest a prize without section_code,
 * i.e. for contest / circuit only.
 *
 * in: contest_id, award_code
 */

namespace App\Livewire\Organization\Award;

use App\Models\ContestAward;
use App\Rules\UserInContest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ContestAwardAssign extends Component
{
    public $contestId;

    public $awardCode;

    public $contestAward;

    public $awardedPeoples;

    // form fields
    public $winnerUserId = '';

    public $winnerName = '';

    public function mount(string $ciac) // livewire contest uuid '+' award_code
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // uuid+award_code
        [$this->contestId, $this->awardCode] = explode(' ', $ciac);
        // first check
        $this->contestAward = ContestAward::where('contest_id', $this->contestId)
            ->where('award_code', $this->awardCode)->first();

        /**
         * Count for # prizes and list names
         * having almost a winner_user_id (some prizes should be have only a winner_name)
         *
         * Note: using selectRaw we must prefix table name in it but not everywhere
         */
        $this->awardedPeoples = DB::table('user_contacts')
            ->selectRaw('
                count(pcp_user_contacts.id) as n_prizes,
                pcp_user_contacts.country_id,
                pcp_user_contacts.last_name,
                pcp_user_contacts.first_name,
                pcp_countries.flag_code,
                pcp_user_contacts.id
            ')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->leftJoin('contest_awards', 'user_contacts.id', '=', 'contest_awards.winner_user_id')
            ->where('contest_awards.contest_id', $this->contestId)
            ->groupBy(
                'user_contacts.country_id',
                'user_contacts.last_name',
                'user_contacts.first_name',
                'user_contacts.id'
            )
            ->orderByDesc('n_prizes') // equivalent to order by 1 DESC
            ->orderBy('user_contacts.country_id') // equivalent to order by 2
            ->orderBy('user_contacts.last_name') // equivalent to order by 3
            ->orderBy('user_contacts.first_name') // equivalent to order by 4
            ->get();

    }

    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return view('livewire.organization.award.contest-award-assign');
    }

    public function rules()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            // 1st
            'awardCode' => [
                'string',
                'required',
                'max:10',
                new UserInContest(),
            ],
            // 2nd
            'winnerUserId' => [
                'string',
                'max:36',
                new UserInContest(),
            ],
            'winnerName' => [
                'string',
                'max:255',
                'required_without:winnerUserId',
            ],
        ];
    }

    public function assignContestAward()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $validated = $this->validate();

        // integration from mount()
        $validated['contestId'] = $this->contestId;
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' validated: ' . json_encode($validated));

        // update 1
        if ($validated['winnerName']) {
            $assignedAward = ContestAward::where('contest_id', $this->contestId)
                ->where('award_code', $validated['awardCode'])
                ->update(['winner_name' => $validated['winnerName']]);
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' assigned 1: ' . json_encode($assignedAward));
        }
        // update 2
        if ($validated['winnerUserId']) {
            $assignedAward = ContestAward::where('contest_id', $this->contestId)
                ->where('award_code', $validated['awardCode'])->first();
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' assigned 2: ' . json_encode($assignedAward));
            $assignedAward->winner_user_id = $validated['winnerUserId'];
            $assignedAward->save();
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' assigned 2: ' . json_encode($assignedAward));
        }

        return redirect()
            ->route('organization-award-contest-assign', ['cid' => $this->contestId])
            ->with('success', __('Yes! Great!'));
    }
}
