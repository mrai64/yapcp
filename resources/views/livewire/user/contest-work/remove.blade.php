<?php

/**
 * User Contest participatio - Remove ContestWork from a ContestSection
 *
 * Not a full page but a form
 *
 */

use App\Models\ContestWork;
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
        $contest = $this->contestWork->contest;
        $this->contestWork->delete();
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
