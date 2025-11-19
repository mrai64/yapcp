<?php
/**
 * State f the Art for contest section 
 * - infos of contest 
 * - infos of section
 * - for every juror how many voted 
 * - sum of votes (no compensations)
 * 
 */
namespace App\Livewire\Contest\Section;

use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\Work;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Voteboard extends Component
{
    use WithPagination;

    public string $section_id;
    public        $contest_section;
    public string $contest_id;

    public        $jury_votes;
    public        $contest_votes;
    
    public function mount(string $sid) // route 
    {
        Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__.' l:'.__LINE__ . ' called');
        $this->section_id = $sid;
        
        $this->contest_section = ContestSection::where('id', $this->section_id)->first();
        $this->contest_id = $this->contest_section->contest_id;

        $juryVotes = DB::table( ContestVote::table_name );

    }
    public function render()
    {
        Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__.' l:'.__LINE__ . ' called');

        $SectionResult = DB::table('contest_votes')
            ->selectRaw(' SUM(pcp_contest_votes.vote) AS total_vote,
                            pcp_contest_votes.work_id,
                            pcp_works.user_id,
                            pcp_works.work_file,
                            pcp_works.title_en ')
            ->join('works', 'contest_votes.work_id', '=', 'works.id')
            ->where('contest_votes.section_id', $this->section_id)
            ->where('contest_votes.contest_id', $this->contest_id)
            ->groupBy('contest_votes.work_id', 'works.user_id', 'works.work_file', 'works.title_en') 
            ->orderByDesc('total_vote') 
            ->orderBy('works.work_file') 
            ->get();
            // ->simplePaginate(12);

            
        return view('livewire.contest.section.voteboard', [
            'sectionResult' => $SectionResult
        ]);
    }
}
