<?php
/**
 * Contest Section Jury Board 
 * List of work that are in contest for section, 
 * followed by works already voted
 * 
 * list (that)
 * CLASS: app/Livewire/Contest/Jury/Board.php
 * VIEW:  resources/views/livewire/contest/jury/board.blade.php
 * 
 * single (next)
 * CLASS: app/Livewire/Contest/Jury/BoardWork.php
 * VIEW:  resources/views/livewire/contest/jury/board-work.blade.php
 *
 * juror_id == Auth::id()
 *
 */

namespace App\Livewire\Contest\Jury;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\WithPagination;

class Board extends Component
{
    use WithPagination;

    public $juror_id;
    public $juror;

    public $contest_section_id;
    public $contest_section;
    public $contest;

    public $contest_works;
    public $participant_works;
    public $voted_works;
    public $voted_ids;
    public $vote_rule;
    public $participants_counter;
    public $voted_counter;

    /**
     * check if a path/namefile has a twin path/300px_namefile 
     * @return string miniature|original
     */
    public static function miniature(string $original_file) : string 
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $last_slash_pos = strrpos($original_file, '/');
        $path = substr($original_file, 0, $last_slash_pos + 1);
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' path:' . $path);
        $name_file  = '300px_'.substr($original_file, $last_slash_pos + 1);
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' name:' . $name_file);
        if (Storage::disk('public')->exists('contests/'.$path.$name_file) ) {
            Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' found' );
            return $path . $name_file;
        }
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' not found' );
        return $original_file;
    }

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // route()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');

        $this->juror_id = Auth::id();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juror_id:' . $this->juror_id );

        $this->juror    = UserContact::where('user_id', $this->juror_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juror:' . json_encode( $this->juror ) );

        $this->contest_section_id = $sid;
        $this->contest_section = ContestSection::where('id', $this->contest_section_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest_section:' . json_encode( $this->contest_section ) );

        $this->contest = Contest::where('id', $this->contest_section->contest_id)->first();
        $this->vote_rule = $this->contest->vote_rule;
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest:' . json_encode( $this->contest ) );

        // how that juror had voted
        // $this->voted_ids = ContestVote::voted_ids( $this->contest->id, $this->contest_section->id);
        $voted = ContestVote::select('work_id')
            ->where('juror_user_id', $this->juror_id)
            ->where('section_id', $sid)
            ->where('contest_id', $this->contest->id)
            ->get();
        $this->voted_ids = array_values( collect($voted)->toArray() );
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' voted_ids:' . json_encode( $this->voted_ids ) );
        
        // SET of un-voted - limited to 12
        if (count($this->voted_ids)) {
            $this->contest_works = DB::table( ContestWork::table_name)
                    ->select(['contest_id', 'section_id', 'work_id', 'extension'])
                    ->where('section_id',   $sid)
                    ->where('contest_id',   $this->contest->id)
                    ->whereNotIn('work_id', $this->voted_ids )
                    ->limit(12)
                    ->get();
            Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest_works:' . json_encode( $this->contest_works ) );

        } else {
            $this->contest_works = ContestWork::where('contest_id', $this->contest->id)
                ->where('section_id', $sid)
                ->limit(12)
                ->get(['contest_id', 'section_id', 'work_id', 'extension']);
        }
        $this->participant_works=[];
        foreach($this->contest_works as $contest_work) {
            $this->participant_works[] = self::miniature($contest_work->contest_id .'/'. $contest_work->section_id .'/'. $contest_work->work_id .'.'. $contest_work->extension);
        }
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' participant_works:' . json_encode( $this->participant_works ) );

        $this->participants_counter = ContestWork::where('section_id', $sid)
            ->where('contest_id', $this->contest->id)->count();

    }

    /**
     * 2. pagination: index
     * The set must be refreshed, so we need recreate here
     */
    public function render() : View
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $this->voted_counter = ContestVote::where('section_id', $this->contest_section_id )->where('juror_user_id', $this->juror_id)->count();

        // select contest_votes.id 
        $votedWorks = DB::table( ContestVote::table_name )
            ->select('id')
            ->where('juror_user_id', $this->juror_id)
            ->where('section_id',    $this->contest_section_id)
            ->where('contest_id',    $this->contest->id)
            ->orderByDesc('vote')
            ->simplePaginate(12); // or 24 or 36
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' voted_works:' . json_encode($votedWorks) );

        return view('livewire.contest.jury.board', [
            'votedWorks'        => $votedWorks,
            'contest'           => $this->contest,
            'contestSections'   => $this->contest_section,
            'contestWorks'      => $this->contest_works, 
            'participantWorks'  => $this->participant_works,
            'votedCounter'      => $this->voted_counter,
            'participantsCounter' => $this->participants_counter,
        ]);
    }

}
