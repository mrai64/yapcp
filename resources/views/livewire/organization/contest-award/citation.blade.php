<?php

/**
 * Organization Contest Manage / Award' Citation
 *
 * Show or insert citation for contestAward
 */

use App\Models\ContestAward;
use Livewire\Volt\Component;

new class extends Component {
    public ContestAward $contestAward;
    public $contest;
    public $contestSection;
    public string $contestAwardCitation;
    //
    public function mount(ContestAward $contestAward)
    {
        $this->contestAward = $contestAward;
        $this->contest = $this->contestAward->contest;
        $this->contestAwardCitation = $this->contestAward->citation ?? '';
    }
    //
    public function rules()
    {
        return [
            'contestAwardCitation' => 'nullable|string|max:2000',
        ];
    }
    //
    public function modifyContestAwardCitation()
    {
        $validated = $this->validate();

        $citation = $validated['contestAwardCitation'];
        // empty > null
        if (empty($citation) || $citation == '') {
            $citation = null;
        }

        $this->contestAward->update(['citation' => $citation]);

        session()->flash('success', __("Citation updated"));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ $contest->name_en }}
        </h2>
        <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __("Jury Citation for award: :code | :name" , ['code' => $contestAward->award_code, 'name' => $contestAward->award_name] ) }}
        </h3>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Award assignment"
            url="{{ route('organization.contest-award.listed', ['contest' => $contest]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                <hr />
                @endif

                <!-- errors list -->
                @if ($errors->any())
                <br />
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                <br />
                @endif

                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Award Jury Citation') }}
                </h3>
                <hr class="mb-4" />
                <form wire:submit="modifyContestAwardCitation">
                    @csrf

                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="contestAwardCitation" :value="__('Jury reasoning, english')" />
                        <textarea 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            type="text" name="contestAwardCitation"
                            wire:model="contestAwardCitation"
                        ></textarea>
                        <p class="test-sm">{{ __("Input area can be resized. Facultative. Empty for delete.")}}</p>
                        <x-input-error for="contestAwardCitation" class="mt-2" />
                    </div>


                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Confirm Citation') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>