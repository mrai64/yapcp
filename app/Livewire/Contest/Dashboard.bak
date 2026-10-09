<?php

/**
 * Contest dashboard
 *
 * organization members
 * admin
 */

namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Dashboard extends Component
{
    public Contest $contest;

    public string $contestId;

    public $contestSectionsSet;

    // 1. before the show
    public function mount(Contest $contest) // route
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->contestId = $contest->id;
        $this->contest = $contest;

        $this->contestSectionsSet = ContestSection::where('contestId', $this->contestId)
            ->orderBy('code')
            ->get();
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' contestSectionsSet' . $this->contestSectionsSet);
    }

    // 2. show must go
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        return view('livewire.contest.dashboard');
    }
    // no more
}
