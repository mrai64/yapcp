<?php

/**
 * Contest live - Contest Works review from organization
 *   in the days between end-of-participation and start-jury-works.
 *   Here we start from ContestSection list.
 *
 * organization members can
 * admin can
 * other not
 *
 * That component will help organization to check works
 * participants before jury works begin. There are some
 * check automatically due, other are demanded to human
 * eyes and knowledge.
 *
 * For every work should be launched to participant an email
 * warning that one of the works seems don't compliant all
 * contest requirement. Maybe coloured picture against monochromatic
 * requirement; or the presence of a signature / mark that explain author.
 *
 * First task: give contest info, section list, then the blade
 *   is for go to review panel.
 *
 */

namespace App\Livewire\Organization\PreJury;

use App\Models\Contest;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SectionListed extends Component
{
    public Contest $contest;

    /**
     * 1. Before the show
     */
    public function mount(Contest $contest) // as in route()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $this->contest = $contest;
    }

    /**
     * 2. Show go
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        return view('livewire.organization.pre-jury.section-listed');
    }
}
