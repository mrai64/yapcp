<?php

/**
 * Contest live - Pre Jury - Work Review
 *
 * Here the works are under very-first judgment, organization must
 * review if works should be introduced to jury or appears
 * any trouble that be communicated to author.
 * Are excluded user_works already reviewed or
 * already warned
 *
 * 2026-01-17 PSR-12
 */

namespace App\Livewire\Organization\PreJury;

use App\Models\ContestWaiting;
use App\Models\ContestWork;
use App\Models\UserWorkValidation;
use Livewire\Component;

class WorkReview extends Component
{
    public $contestWork;

    public $contestSection;

    public $userWork;

    public bool $alreadyReviewed; // counter

    public bool $alreadyWarned; //  counter

    /**
     * 1. Before the show (if)
     */
    public function mount(string $wid) // livewire work_id
    {
        $this->contestWork = ContestWork::findOrFail($wid);

        $this->contestSection = $this->contestWork->contest_section;

        $this->userWork = $this->contestWork->userWork;

        $this->alreadyReviewed = UserWorkValidation::where('user_work_id', $this->userWork->id)
            ->where('federation_section_id', $this->contestSection->federationSection_id)
            ->exists();

        if ($this->alreadyReviewed) {
            $this->alreadyWarned = false;
        } else {
            $this->alreadyWarned = ContestWaiting::where('user_work_id', $this->userWork->id)
            ->exists();
        }
    }

    /**
     * 2. Show but not even
     */
    public function render()
    {
        // already? show an empty view and U turn
        if ($this->alreadyReviewed || $this->alreadyWarned) {
            return view('livewire.organization.pre-jury.section-review-work-hidden'); // empty display hidden
        }
        // show and send the Validator Review
        return view('livewire.organization.pre-jury.section-review-work-show');
    }
}
