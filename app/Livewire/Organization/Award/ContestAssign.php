<?php

/**
 * Contest live - award assignment page - contest page
 *
 * After Jury admit assignment, next act is assign
 * section, then contest awards.
 * And that page serve it.
 *
 * TODO Organization members only
 */

namespace App\Livewire\Organization\Award;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContestAssign extends Component
{
    public string $contest_id;

    public $contest;

    public $contest_awards;

    public $award_assigned;

    public $all_assigned;

    public $incomplete_sections;

    public $sections; // incomplete section

    public $contest_sections;

    public $section_awards;

    public $awarded_peoples;

    // form fields
    public $award_code = '';

    public $winner_user_id = '';

    public $winner_name = '';

    /**
     * 1.
     */
    public function mount(string $cid) // route
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->first();

        /**
         * Check if every section prize and mention are assigned:
         * true: expose contest prizes form
         * false: expose section assignment links
         */
        // section_code, total_awards, assigned_awards
        $this->award_assigned = ContestAward::query()
            ->selectRaw('
                (CASE 
                    WHEN (section_code > "") THEN section_code 
                    ELSE "Contest" 
                END) as code
            ')
            ->selectRaw('
                count(*) AS total_awards
            ')
            ->selectRaw('
                SUM(
                    CASE
                        WHEN (`winner_work_id` IS NOT NULL AND `winner_work_id` != "")
                        OR (`winner_user_id` IS NOT NULL AND `winner_user_id` != "")
                        OR (`winner_name` IS NOT NULL AND `winner_name` != "")
                        THEN 1
                        ELSE 0
                    END
                ) AS assigned_awards
            ')
            ->selectRaw('section_id')
            ->where('contest_id', $this->contest_id)
            ->where('section_id', '>', '')
            ->groupBy('section_code')
            ->groupBy('section_id')
            ->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' set: '.json_encode($this->award_assigned));

        $this->incomplete_sections = [];
        foreach ($this->award_assigned as $section_award) {

            if ($section_award->total_awards > $section_award->assigned_awards) {
                $this->incomplete_sections[] = $section_award->section_id;
            }
        }
        $this->all_assigned = (count($this->incomplete_sections) === 0);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' set: '.json_encode($this->incomplete_sections));
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' all_assigned: '.json_encode($this->all_assigned));
        if (count($this->incomplete_sections)) {
            $this->sections = ContestSection::whereIn('id', $this->incomplete_sections)->get();
        } else {
            $this->sections = [];
        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' sections: '.json_encode($this->sections));

        $sectionAwards = ContestAward::where('contest_id', $this->contest_id)
            ->where('section_code', '>', '')->get();
        $this->section_awards = $sectionAwards;

        $this->contest_sections = ContestSection::where('contest_id', $this->contest_id)->get();

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

        // $this->contest_awards : see render()
    }

    /**
     * 2.
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        // $contestAwards = ContestAward::where('contest_id', $this->contest_id)
        //     ->whereNUll('section_id')->orderBy('award_code')->get();

        $contestAwards = ContestAward::select(
            'contest_awards.*',
            'countries.flag_code',
            DB::raw("COALESCE(pcp_user_contacts.country_id, '') AS country_id"),
            DB::raw("COALESCE(pcp_user_contacts.last_name, '') AS last_name"),
            DB::raw("COALESCE(pcp_user_contacts.first_name, '') AS first_name")
        )
            ->leftJoin('user_contacts', 'user_contacts.user_id', '=', 'contest_awards.winner_user_id')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->whereNull('contest_awards.section_id')
            ->where('contest_awards.contest_id', $this->contest_id)
            ->orderBy('contest_awards.award_code')
            ->get();
        $this->contest_awards = $contestAwards;

        return view('livewire.organization.award.contest-assign');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return [
            'winner_user_id' => 'string|exists:contest_participants,user_id', // TODO build a validation rule() to check 'AND contest_id', simple exists seems too large
            'winner_name' => 'string|max:255',
        ];

    }

    /**
     * 4. at last ASSIGN
     */
    public function assign_prizes()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' winner_user_id: '.$this->winner_user_id);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' winner_name: '.$this->winner_name);

        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' validated: '.json_encode($validated));

        $contest_prize = ContestAward::where('contest_id', $this->contest_id)->where('award_code', $validated['award_code'])->first();
        if (isset($validated['winner_user_id'])) {
            $contest_prize->update([
                'winner_user_id' => $validated['winner_user_id'],
            ])->save();
        }
        if (isset($validated['winner_name'])) {
            $contest_prize->update([
                'winner_name' => $validated['winner_name'],
            ])->save();
        }

        return view('livewire.organization.award.contest-assign');
    }
}
