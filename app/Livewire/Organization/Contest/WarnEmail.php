<?php

/**
 * Organization Contest Section Work Review Pass
 *
 * CLASS: app/Livewire/Organization/Contest/PassNext.php
 * VIEW:  resources/views/livewire/organization/contest/pass-next.blade.php
 */

namespace App\Livewire\Organization\Contest;

use App\Models\ContestWaiting;
use App\Models\ContestWork;
use App\Notifications\ContestWarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WarnEmail extends Component
{
    public $contest_work;

    public $work;

    public $because;

    /**
     * 1. Before the show
     */
    public function mount(string $wid) // route()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $this->contest_work = ContestWork::where('work_id', $wid)->first();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' wid:'.json_encode($wid));
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' contest_work:'.json_encode($this->contest_work));
        $this->because = '';
        $this->work = $this->contest_work->work;

    }

    /**
     * 2. Show must go
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');

        return view('livewire.organization.contest.warn-email');
    }

    /**
     * 3. Validation rules only
     */
    public function rules()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');

        return [
            'because' => 'required|string',
        ];
    }

    /**
     * 4. do the job
     */
    public function register_n_send() // blade form
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' validated:'.json_encode($validated));

        // integration
        $validated['contest_id'] = $this->contest_work->contest_id;
        $validated['section_id'] = $this->contest_work->section_id;
        $validated['participant_user_id'] = $this->contest_work->user_id;
        $validated['work_id'] = $this->contest_work->work_id;
        $validated['portfolio_sequence'] = $this->contest_work->portfolio_sequence;
        $validated['email'] = $this->contest_work->user_contact->email;
        $validated['organization_user_id'] = Auth::id();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' validated:'.json_encode($validated));

        $contest_waiting = ContestWaiting::create($validated);
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' contest_waiting:'.json_encode($contest_waiting));

        // ContestWarning notification w/ContestWaiting emailgram
        $contest_waiting->notifyNow(new ContestWarning($contest_waiting));

        return redirect()
            ->route('organization-contest-section-list', ['sid' => $this->contest_work->section_id])
            ->with('success', __('Warn Send. Next,...'));
    }
}
