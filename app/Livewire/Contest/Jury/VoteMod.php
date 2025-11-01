<?php
/**
 * Juror Vote modification 
 * CLASS: app/Livewire/Contest/Jury/VoteMod.php
 * VIEW:  resources/views/livewire/contest/jury/vote-mod.blade.php
 * 
 * Change vote +1 -1 in vote_rule scale
 * 
 */

namespace App\Livewire\Contest\Jury;

use App\Models\ContestVote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class VoteMod extends Component
{
    public string $juror_user_id;
    public string $vote_id;
    public        $vote;
    public        $contest;
    public string $vote_rule;
    public        $valid_votes = [];
    public        $vote_change;
    public        $work;
    public        $old_index;
    public        $index;
    public string $voted_work_id;

    // 1. Before the show 
    public function mount(string $vid) // route()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $this->juror_user_id = Auth::id();
        $this->vote_id    = $vid;
        $this->vote       = ContestVote::where('id', $this->vote_id)->where('juror_user_id', $this->juror_user_id)->first();
        $this->vote_change = '';
        $this->contest    = $this->vote->contest;
        $this->vote_rule  = $this->contest->vote_rule;
        $this->work       = $this->vote->work;

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

        $this->index = array_search( $this->vote->vote, $this->valid_votes, true);
        $this->old_index = $this->index;
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' this:' . json_encode( $this ));
    }

    // 2. Show
    public function render()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        return view('livewire.contest.jury.vote-mod');
    }

    // 3. Validation rules only 
    public function rules()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        return [
            'vote_change' => 'string|in:"up","down"',
        ];
    }
    
    // 4. Do the job
    public function change_that_vote(string $up_down)
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called in:' . $up_down);
        $this->vote_change = $up_down;
        $validated= $this->validate();

        if ($this->vote_change == 'down') {
            if ($this->index > 0){
                Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' was:' . $this->vote->vote);
                $this->vote->vote = $this->valid_votes[ --$this->index ];
                Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' changed:' . $this->vote->vote);
            }
        }
        if ($this->vote_change == 'up'){
            if ($this->index < count($this->valid_votes)){
                Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' was:' . $this->vote->vote);
                $this->vote->vote = $this->valid_votes[ ++$this->index ];
                Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' changed:' . $this->vote->vote);
            }
        }
        // should update not must
        if ($this->old_index !== $this->index ){
            $this->vote->update( ['vote' => $this->vote->vote] );
            Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' update:' . $this->vote->vote);
        }
        // then back to? 
        return redirect()
          ->route('contest-jury-board', ['sid' => $this->vote->section_id ])
          ->with('success', __('Vote '.$up_down.' successfully!') );
    }
}
