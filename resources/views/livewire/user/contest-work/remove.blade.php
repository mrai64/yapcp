<?php

/**
 * User Contest participatio - Remove ContestWork from a ContestSection
 *
 * Not a full page but a form
 *
 */

use App\Models\ContestParticipant;
use App\Models\ContestWork;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;

new class extends Component {
    //
    public $contestWork;
    //
    public function mount(ContestWork $contestWork) // from livewire
    {
        $this->contestWork = $contestWork;
    }
    //
    public function removeContestWork()
    {
        $contestWork = $this->contestWork;
        $contest = $this->contestWork->contest;
        DB::transaction(function () use($contest, $contestWork) {
            $contestWork->delete();
            $remain = ContestWork::where('contest_id', $contest->id)
                ->where('user_id', $contestWork->user_id)
                ->count();
            if (! $remain) {
                $cp = ContestParticipant::where('contest_id', $contest->id)
                    ->where('user_contact_id', $contestWork->user_id)
                    ->first();
                $cp->delete();
            }
        });
        return redirect()
            ->route('user.contest.participate', ['contest' => $contest])
            ->with('success', __('Work Removed, Ok!'));
    }
}; ?>

<div class="text-center">
    [ {{ $contestWork->contestSection->code }} ]
    / 
    {{ $contestWork->portfolio_sequence }}
    <br />
    <form wire:submit="removeContestWork">
        @csrf

        <x-button class="mt-2 ms-4">
            {{ __("Leave from") }}
        </x-button>
    </form>
</div>
