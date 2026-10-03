<?php

/**
 * User Contest participatio - Remove ContestWork from a ContestSection
 *
 * Not a full page but a form
 *
 */

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;

new class extends Component {
    //
    public ContestWork $contestWork;
    //
    public function mount(ContestWork $contestWork) // from livewire
    {
        $this->contestWork = $contestWork->loadMissing(['contest', 'contestSection']);
    }
    //
    public function removeContestWork()
    {
        $contestWork = $this->contestWork;
        $contestId   = $this->contestWork->contest_id;
        $userId      = $this->contestWork->user_id;
        DB::transaction(function () use($contestId, $userId, $contestWork) {
            $contestWork->delete();
            $remain = ContestWork::where('contest_id', $contestId)
                ->where('user_id', $userId)
                ->count();
            if ($remain === 0) {
                $cp = ContestParticipant::where('contest_id', $contestId)
                    ->where('user_contact_id', $userId)
                    ->first();
                $cp?->delete();
            }
        });
        $contest = Contest::findOrFail($contestId);
        return redirect()
            ->route('user.contest.participate', ['contest' => $contest])
            ->with('success', __('Work Removed, Ok!'));
    }
}; ?>

<div class="text-center">
    [ {{ $contestWork->contestSection?->code }} ]
    / 
    {{ $contestWork->portfolio_sequence }}
    <br />
    <form wire:submit="removeContestWork">

        <x-button class="mt-2 ms-4">
            {{ __("Leave from") }}
        </x-button>
    </form>
</div>
