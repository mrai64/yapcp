<?php

/**
 * Contest Section Juror Board
 * List of work that are in contest for section,
 * followed by works already voted
 *
 * reserved to juror
 *
 * juror_id == Auth::id()
 */

namespace App\Livewire\Juror;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SectionBoard extends Component
{
    use WithPagination;

    public string $jurorId;

    public UserContact $juror;

    public $contestSectionId;

    public ContestSection $contestSection;

    public Contest $contest;

    public $paginatedContestWorkSet;

    public $participantWorkSet;

    public $votedWorks;

    public $contestVoteIdSet;

    public $contestVoteRule;

    public $participantsCounter;

    public $votedCounter;

    /**
     * check if a path/namefile has a twin path/300px_namefile
     * otherwise return original path/namefile
     *
     * @return string miniature|original
     *
     * TODO in ContestWork Model
     */
    public static function miniature(string $originalPathName): string
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $lastSlashPosition = strrpos($originalPathName, '/');
        $originalPath = substr($originalPathName, 0, $lastSlashPosition + 1);
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' path:' . $originalPath);

        $miniatureName = '300px_' . substr($originalPathName, $lastSlashPosition + 1);
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' name:' . $miniatureName);

        if (Storage::disk('public')->exists('contests/' . $originalPath . $miniatureName)) {
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' found');

            return $originalPath . $miniatureName;
        }
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' not found');

        return $originalPathName;
    }

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // route()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        Gate::authorize('jury-panels', $sid);

        $this->jurorId = Auth::id();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' juror_id:' . $this->jurorId);

        $this->juror = UserContact::where('user_id', $this->jurorId)->first();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' juror:' . json_encode($this->juror));

        $this->contestSectionId = $sid;
        $this->contestSection = ContestSection::where('id', $this->contestSectionId)->first();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contestSection:' . json_encode($this->contestSection));

        $this->contest = Contest::where('id', $this->contestSection->contest_id)->first();
        $this->contestVoteRule = $this->contest->vote_rule;
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contest:' . json_encode($this->contest));

        // how that juror had voted
        // $this->contestVoteIdSet = ContestVote::contestVoteIdSet( $this->contest->id, $this->contestSection->id);
        $voted = ContestVote::select('work_id')
            ->where('juror_user_id', $this->jurorId)
            ->where('section_id', $sid)
            ->where('contest_id', $this->contest->id)
            ->get();
        $this->contestVoteIdSet = array_values(collect($voted)->toArray());
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contestVoteIdSet:' . json_encode($this->contestVoteIdSet));

        // SET of un-voted - limited to 12
        if (count($this->contestVoteIdSet)) {
            $this->paginatedContestWorkSet = DB::table(ContestWork::TABLENAME)
                ->select(['contest_id', 'section_id', 'work_id', 'extension'])
                ->where('section_id', $sid)
                ->where('contest_id', $this->contest->id)
                ->whereNotIn('work_id', $this->contestVoteIdSet)
                ->limit(12)
                ->get();
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' paginatedContestWorkSet:' . json_encode($this->paginatedContestWorkSet));

        } else {
            $this->paginatedContestWorkSet = ContestWork::where('contest_id', $this->contest->id)
                ->where('section_id', $sid)
                ->limit(12)
                ->get(['contest_id', 'section_id', 'work_id', 'extension']);
        }
        $this->participantWorkSet = [];
        foreach ($this->paginatedContestWorkSet as $contestWork) {
            $this->participantWorkSet[] = self::miniature($contestWork->contest_id . '/' . $contestWork->section_id . '/' . $contestWork->work_id . '.' . $contestWork->extension);
        }
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' participantWorkSet:' . json_encode($this->participantWorkSet));

        $this->participantsCounter = ContestWork::where('section_id', $sid)
            ->where('contest_id', $this->contest->id)->count();

    }

    /**
     * 2. pagination: index
     * The set must be refreshed, so we need recreate here
     */
    public function render(): View
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->votedCounter = ContestVote::where('section_id', $this->contestSectionId)->where('juror_user_id', $this->jurorId)->count();

        // select contest_votes . id
        $votedWorks = DB::table(ContestVote::TABLENAME)
            ->select('id')
            ->where('juror_user_id', $this->jurorId)
            ->where('section_id', $this->contestSectionId)
            ->where('contest_id', $this->contest->id)
            ->orderByDesc('vote')
            ->simplePaginate(12); // or 24 or 36
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' votedWorks:' . json_encode($votedWorks));

        return view('', [
            'votedWorks' => $votedWorks,
            'contest' => $this->contest,
            'contestSections' => $this->contestSection,
            'contestWorks' => $this->paginatedContestWorkSet,
            'participantWorks' => $this->participantWorkSet,
            'votedCounter' => $this->votedCounter,
            'participantsCounter' => $this->participantsCounter,
        ]);
    }
}
