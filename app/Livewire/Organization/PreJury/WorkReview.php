<?php

/**
 * Contest live - Pre Jury - Work Review
 *
 * Here the works are under very-first judgment, organization must
 * review if works should be introduced to jury or appears
 * any trouble that be communicated to author.
 *
 * 2026-01-17 PSR-12
 */

namespace App\Livewire\Organization\PreJury;

use App\Models\ContestWaiting;
use App\Models\ContestWork;
use App\Models\WorkValidation;
use Livewire\Component;

class WorkReview extends Component
{
    public $contestWork;

    public $contestSection;

    public $work;

    public int $reviewedWorkCount; // counter

    public int $warningWorkCount; //  counter

    /**
     * 1. Before the show (if)
     */
    public function mount(string $wid) // livewire work_id
    {
        $this->contestWork = ContestWork::where('id', $wid)->first();

        $this->contestSection = $this->contestWork->contest_section;

        $this->work = $this->contestWork->work;

        $this->reviewedWorkCount = WorkValidation::where('work_id', $this->work->id)->where('federation_section_id', $this->contestSection->federationSection_id)->count();
        if ($this->reviewedWorkCount) {
            $this->warningWorkCount = 0;
        } else {
            $this->warningWorkCount = ContestWaiting::where('work_id', $this->work->id)->count();
        }

    }

    /**
     * 2. Show but not even
     */
    public function render()
    {
        if ($this->reviewedWorkCount || $this->warningWorkCount) {
            return view('livewire.organization.pre-jury.section-review-work-hidden'); // empty display hidden
        }

        return view('livewire.organization.pre-jury.section-review-work-show');
    }
}
