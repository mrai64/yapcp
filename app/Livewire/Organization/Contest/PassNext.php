<?php
/**
 * Organization Contest Section Work Review Pass
 *
 * CLASS: app/Livewire/Organization/Contest/PassNext.php
 * VIEW:  resources/views/livewire/organization/contest/pass-next.blade.php
 *
 */

namespace App\Livewire\Organization\Contest;

use App\Models\ContestWork;
use App\Models\WorkValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PassNext extends Component
{
    public $contest;
    public $contest_work;
    public $contest_section;
    public $work;
    public string $file_from;
    public string $file_to;
    public $work_validation = [];

    /**
     * 1. Before the show
     *
     */
    public function mount(string $wid) // route()
    {
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $this->contest_work    = ContestWork::where('work_id', $wid)->first();
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' wid:' . json_encode($wid) );
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' contest_work:' . json_encode($this->contest_work) );
        
        $this->contest_section = $this->contest_work->contest_section;
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' contest_section:' . json_encode($this->contest_section) );

        $this->contest = $this->contest_work->contest;
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' contest_section:' . json_encode($this->contest) );

        $this->work            = $this->contest_work->work;
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' work:' . json_encode($this->work) );

        // from: photos/country_id/last_name/first_name_user_id/work_id.work.extension
        //   to: contests/contest_id/section_id/work_id.work.extension anon
        // where: in public disk
        $this->file_from       = 'photos/'  . $this->work->work_file;
        $this->file_to         = 'contests/'. $this->contest_section->contest_id .'/'. $this->contest_section->id .'/'. $this->work->id .'.'. $this->work->extension;
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' file_from:' . json_encode($this->file_from) );
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' file_to:' . json_encode($this->file_to) );

        $copy_result = Storage::disk('public')->copy( $this->file_from, $this->file_to );
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' copy result:' . json_encode($copy_result) );

        // save validation rec only if $this->contest_section->federation_section_id is NOT NULL
        if ( ($this->contest_section->under_patronage == 'N') || (is_null($this->contest_section->federation_section_id) ) ) {
            return;
        }

        $inserted = WorkValidation::updateOrCreate(
            [
                'work_id' => $this->work->id,
                'federation_section_id' => $this->contest_section->federation_section_id,
            ],
            [   'validator_user_id' => Auth::id(), ]
        );
        Log::info('Component ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' validation_insert:' . json_encode($inserted) );

    }

    /**
     * 2. Show, but here we U turn 
     */
    public function render()
    {
        Log::info('Component Organization/Contest/' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        return view('livewire.organization.contest.pass-next');
    }

}
