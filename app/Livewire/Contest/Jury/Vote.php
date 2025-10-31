<?php
/**
 * 
 * CLASS: app/Livewire/Contest/Jury/Vote.php
 * VIEW:  resources/views/livewire/contest/jury/vote.blade.php
 * 
 * Contest > section > Juror List > juror Vote
 * input: juror_id via Auth::id
 *        section_id via route
 * - check votes assigned in
 * - find works without vote
 * - when set of un-voted work become empty warn: end of jury, back to dashboard
 * 
 */
namespace App\Livewire\Contest\Jury;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Vote extends Component
{
    //
    public string $juror_user_id;
    public string $contest_id;
    public string $contest_section_id;
    public string $work_id;
    public        $contest_section;
    public        $contest;
    public        $vote_rule;
    public        $valid_votes;
    public        $voted_works_id;
    public        $unvoted_work_first;
    public        $vote = [];

    /**
     * 1. before the show
     */
    public function mount(string $sid) // route() 
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $this->contest_section_id = $sid;
        $this->juror_user_id      = Auth::id();
        $this->contest_section = ContestSection::where('id', $this->contest_section_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest_section: ' . json_encode( $this->contest_section) );
        $this->contest_id = $this->contest_section->contest_id;
        $this->contest = Contest::where('id', $this->contest_section->contest_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest_section: ' . json_encode( $this->contest_section) );

        $this->vote_rule = $this->contest->vote_rule;
        switch ($this->vote_rule) {
            case 'num:1..10':
                $this->valid_votes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
                break;
            case 'num:1..30':
                $this->valid_votes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10','11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22','23', '24', '25', '26', '27', '28', '29', '30'];
                break;
            case 'star:1..5':
                $this->valid_votes = [ '⭐️', '⭐️⭐️', '⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️⭐️' ];
                break;
            }
        
        $this->voted_works_id = ContestVote::voted_ids( $this->contest_id, $this->contest_section_id);
        if ($this->voted_works_id->count() > 0) {
            $this->unvoted_work_first = DB::table( ContestWork::table_name)->whereNotIn('work_id', $this->voted_works_id )->first();
            
        } else {
            $this->unvoted_work_first = ContestWork::where('contest_id', $this->contest->id)->where('section_id', $this->contest_section->id)->first();
        }
        $this->vote = [];
        
    }
    /**
     * 2. Show it
     */
    public function render()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        return view('livewire.contest.jury.vote');
    }

    /**
     * 3. Validation rule only
     */
    public function rules()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $rule = [
            'vote' => 'string|'.Rule::in($this->valid_votes),
        ];
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' rule' . json_encode($rule));
        return $rule;
    }

    /**
     * 4. Do the job
     */
    public function assign_vote( string $vote) // form
    {

        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called: ' . json_encode( $vote) );
        $this->vote = $vote;
        // check value 
        $validated = $this->validate();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' validated:' . json_encode($validated ));
        
        // integrate array
        $validated['contest_id']  = $this->contest_id;
        $validated['section_id']  = $this->contest_section_id;
        $validated['work_id']     = $this->unvoted_work_first->work_id;
        $validated['juror_user_id'] = $this->juror_user_id;
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' insert:' . json_encode( $validated ));
        // vote
        
        // register value
        $registered_vote = ContestVote::create($validated);
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' out:' . json_encode( $registered_vote ));

        // back / go to (another) vote
        return redirect()
          ->route('contest-jury-vote', ['sid' => $this->contest_section_id ])
          ->with('success', __('Vote registered successfully!') );
    }
}
