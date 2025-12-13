<?php
/**
 * Contest live - That component prepare n show for a contest
 * a set of works awarded for a section, revealing some infos
 * as author name, and title of work
 * 
 * Reserved for organization members only 
 * 
 * 
 */
namespace App\Livewire\Organization\Award;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ContestAssignedDia extends Component
{
    public string $section_id; 

    public $section_awarded;


    /**
     * check if a path/namefile has a twin path/300px_namefile
     *
     * @return string miniature|original
     *
     * TODO in ContestWork Model
     */
    public static function miniature(string $original_file): string
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $last_slash_pos = strrpos($original_file, '/');
        $path = substr($original_file, 0, $last_slash_pos + 1);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' path:'.$path);

        $name_file = '300px_'.substr($original_file, $last_slash_pos + 1);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' name:'.$name_file);

        if (Storage::disk('public')->exists('contests/'.$path.$name_file)) {
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' found');

            return $path.$name_file;
        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' not found');

        return $original_file;
    }

    public function mount(string $sid) // livewire 
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->section_id = $sid;

        $this->section_awarded = DB::table('works')
            ->leftJoin('contest_awards', 'works.id', '=', 'contest_awards.winner_work_id')
            ->leftJoin('user_contacts', 'contest_awards.winner_user_id', '=', 'user_contacts.user_id')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->select(
                'contest_awards.award_code',
                'contest_awards.award_name',
                'countries.flag_code',
                'countries.id as country_id',
                'user_contacts.last_name',
                'user_contacts.first_name',
                'works.title_en',
                'works.reference_year',
                'works.work_file'
            )
            ->where('contest_awards.section_id', $this->section_id)
            ->orderBy('contest_awards.award_code')
            ->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

    }
    
    public function render()
    {
        return view('livewire.organization.award.contest-assigned-dia');
    }
}
