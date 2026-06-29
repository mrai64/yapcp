<?php

/**
 * Organization Contest Design / list for every section the jury list
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    
    public Contest $contest;
    public         $contestWithData;
    public Organization $organization;
    public bool $noSections;
    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;

        // eager loading
        // contest > contestSections > contestJuries > userContact
        $this->contestWithData = Contest::with(['contestSections.contestJuries.userContact'])
            ->find($contest->id);

    }
    // that's all, folks!
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <livewire:organization.design.contest.modify-nav :contest="$contest" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-header-link-app 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
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

                @if ($contestWithData->contestSections->isEmpty())
                <h3>
                    {{ __('Add first Section n theme to your Contest') }}
                </h3>
                <x-inline-link-app 
                    txt="Add Section"
                    url="{{ route('organization.design.contest-section.add', ['contest' => $contest]) }}" />
                @else
                <h3>
                    {{ __('Section n themes Jurors List') }}
                </h3>
                <dl>
                    @foreach ($contestWithData->contestSections as $section)
                    <div class="mb-4 w-half">
                        <dt class="fyk text-2xl font-medium text-gray-900">
                            {{ $section->code }}
                            {{ $section->name_en }}
                        </dt>
                        <x-inline-link-app 
                            txt="Add Juror" 
                            url="{{ route('organization.design.contest-jury.add1', ['contest_section' => $section]) }}" />
                        @if ($section->contestJuries->isEmpty())
                            <dd>
                                {{ __('❌ No jurors for that section - theme, add ASAP')}}
                            </dd>
                        @else
                            @foreach ($section->contestJuries as $juror)
                            <dd class="w-auto inline-float">
                                {{ ($juror->is_president) ? __("Jury President") : __("Juror") }} 
                                {{ __("From") }}
                                {{ $juror->userContact->country->flag_code }} 
                                {{ $juror->userContact->country->country }} <br>
                                {{ $juror->userContact->last_name }}, 
                                {{ $juror->userContact->first_name }}<br>
                                <x-inline-link-app
                                    txt="Remove" 
                                    url="{{ route('organization.design.contest-jury.remove', ['contest_jury' => $juror]) }}" />
                            </dd>
                            @endforeach
                        @endif
                    </div>
                    <hr class="my-4" />
                    @endforeach
                </dl>
                @endif
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
