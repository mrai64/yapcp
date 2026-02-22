<?php

/**
 * Organization Contest Section Work Review Pass
 * When a work is reviewed and obtain a go!, is translated
 * from user depot to contest depot, then return back to work list, so
 * Go, Next Up!
 *
 * CLASS: app/Livewire/Organization/Contest/PassNext.php
 * VIEW:  resources/views/livewire.organization.pre-jury.pass-next.blade.php
 *
 * 2026-01-17 PSR-12
 *
 * TODO Probably that's a wrong way to do the right job. Should be Service?
 */

namespace App\Livewire\Organization\PreJury;

use App\Models\ContestWork;
use App\Models\UserWorkValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PassNext extends Component
{
    public $contest;

    public $contestWork;

    public $contestSection;

    public $userWork;

    public string $fileFromWork;

    public string $fileToContest;

    // public $work_validation = []; unused

    /**
     * 1. Before the show - no: do the job
     *
     * wid is contest_works.work_id not contest_works.id
     */
    public function mount(string $wid) // route()
    {
        $this->contestWork = ContestWork::where('work_id', $wid)->first();
        $this->contestSection = $this->contestWork->contest_section;
        $this->contest = $this->contestWork->contest;
        $this->userWork = $this->contestWork->userWork;
        //
        //  from: photos/country_id/last_name/first_name_user_id/work_id.work.extension
        //    to: contests/contest_id/section_id/work_id.work.extension anon
        // where: in public disk
        $this->fileFromWork = 'photos/' . $this->userWork->work_file;
        $this->fileToContest = 'contests/' . $this->contestSection->contest_id
            . '/' . $this->contestSection->id
            . '/' . $this->userWork->id . '.' . $this->userWork->extension;

        $copyResult = Storage::disk('public')->copy($this->fileFromWork, $this->fileToContest);

        // save validation rec only if $this->contestSection->federationSection_id is NOT NULL
        if (($this->contestSection->under_patronage === 'N') || (is_null($this->contestSection->federationSection_id))) {
            return;
        }

        $insertedResult = UserWorkValidation::updateOrCreate(
            [
                'user_work_id' => $this->userWork->id,
                'federation_section_id' => $this->contestSection->federationSection_id,
            ],
            ['validator_user_id' => Auth::id()]
        );
    }

    /**
     * 2. Show, no here we U turn
     */
    public function render()
    {
        ds('Component Organization/Contest/' . __CLASS__ . ' f:' . __FUNCTION__ . ':' . __LINE__ . ' called');

        session()->flash('message', __("Done."));
        return view('');
        // try return back()->with('success', __('Done.'));
    }
}
