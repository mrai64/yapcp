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
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContestAwardAssign extends Component
{
    public $contest_id;

    public $award_code;

    public $contest_award;

    public $awarded_peoples;

    // form fields
    public $winner_user_id = '';

    public $winner_name = '';

    public function mount(string $ciac) // livewire contest uuid '+' award_code
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        // uuid+award_code
        [$this->contest_id, $this->award_code] = explode(' ', $ciac);
        // first check
        $this->contest_award = ContestAward::where('contest_id', $this->contest_id)
            ->where('award_code', $this->award_code)->first();

        /**
         * Count for # prizes and list names
         * having almost a winner_user_id (some prizes should be have only a winner_name)
         *
         * Note: using selectRaw we must prefix table name in it but not everywhere
         */
        $this->awarded_peoples = DB::table('user_contacts')
            ->selectRaw('
                count(pcp_user_contacts.id) as n_prizes,
                pcp_user_contacts.country_id,
                pcp_user_contacts.last_name,
                pcp_user_contacts.first_name,
                pcp_countries.flag_code,
                pcp_user_contacts.user_id
            ')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->leftJoin('contest_awards', 'user_contacts.user_id', '=', 'contest_awards.winner_user_id')
            ->where('contest_awards.contest_id', $this->contest_id)
            ->groupBy(
                'user_contacts.country_id',
                'user_contacts.last_name',
                'user_contacts.first_name',
                'user_contacts.user_id'
            )
            ->orderByDesc('n_prizes') // equivalent to order by 1 DESC
            ->orderBy('user_contacts.country_id') // equivalent to order by 2
            ->orderBy('user_contacts.last_name') // equivalent to order by 3
            ->orderBy('user_contacts.first_name') // equivalent to order by 4
            ->get();

    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return view('livewire.organization.award.contest-award-assign');
    }

    public function rules()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return [
            // 1st
            'award_code' => [
                'string',
                'required',
                'max:10',
                new UserInContest(),
            ],
            // 2nd
            'winner_user_id' => [
                'string',
                'max:36',
                new UserInContest(),
            ],
            'winner_name' => [
                'string',
                'max:255',
                'required_without:winner_user_id',
            ],
        ];
    }

    public function assign_contest_award()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        $validated = $this->validate();

        // integration from mount()
        $validated['contest_id'] = $this->contest_id;
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' validated: '.json_encode($validated));
        // update 1
        if ($validated['winner_name']) {
            $AssignedAward = ContestAward::where('contest_id', $this->contest_id)
                ->where('award_code', $validated['award_code'])
                ->update(['winner_name' => $validated['winner_name']]);
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' assigned 1: '.json_encode($AssignedAward));
        }
        // update 2
        if ($validated['winner_user_id']) {
            $AssignedAward = ContestAward::where('contest_id', $this->contest_id)
                ->where('award_code', $validated['award_code'])->first();
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' assigned 2: '.json_encode($AssignedAward));
            $AssignedAward->winner_user_id = $validated['winner_user_id'];
            $AssignedAward->save();
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' assigned 2: '.json_encode($AssignedAward));
        }

        return redirect()
            ->route('organization-award-contest-assign', ['cid' => $this->contest_id])
            ->with('success', __('Yes! Great!'));
    }
}
