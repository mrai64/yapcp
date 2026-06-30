<?php

/**
 * Organization Contest Design / define section n themes for the contest
 * 
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest      $contest;
    public              $contestSectionsSet;
    public Organization $organization;
    //

    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;
        $this->contestSectionsSet = $contest->sections;
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="sections" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-section.section-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
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

                @if ($contestSectionsSet->isEmpty())
                <h3>
                    {{ __('Add first Section n theme to your Contest') }}
                </h3>
                <x-yapcp.inline-link 
                    txt="Add Section"
                    url="{{ route('organization.design.contest-section.add', ['contest' => $contest]) }}" />
                @else
                <h3>
                    {{ __('Section n themes List') }}
                </h3>
                <x-yapcp.inline-link 
                    class="fyk text-2xl float-end font-medium rounded-md px-4 py-2"
                    txt="Add Section"
                    url="{{ route('organization.design.contest-section.add', ['contest' => $contest]) }}" />
                <p class="small">{{  __('Sorted by code') }}</p>
                    @foreach ($contestSectionsSet as $section)
                    <table class="data-table-container w-half mx-4 my-4">
                        <tbody>
                            <tr>
                                <td colspan="2" class="fyk text-3xl font-medium nowrap">
                                    {{ $section->code }} / {{ $section->name_en }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <x-yapcp.inline-link 
                                        txt="Modify"
                                        url="{{ route('organization.design.contest-section.modify', ['contest_section' => $section->id]) }}" />
                                    <x-yapcp.inline-link 
                                        txt="Remove"
                                        url="{{ route('organization.design.contest-section.remove', ['contest_section' => $section]) }}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="small" nowrap>{{ __('Under Patronage') }}</td>
                                <td class="small">
                                    {{ ($section->under_patronage) ? __('Under patronage') : __('Free of patronage') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small" nowrap>{{ __('Accepted file extension / image type') }}</td>
                                <td class="small">
                                    {{ $section->file_formats }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('Number of works / min .. max') }}</td>
                                <td class="small">
                                    {{ __('from :min to :max included', ['min' => $section->min_works, 'max' => $section->max_works]) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('Max size px for shorter side') }}</td>
                                <td class="small">
                                    {{ __(':val px', ['val' => $section->short_size_max]) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('Max size px for longer side') }}</td>
                                <td class="small">
                                    {{ __(':val px', ['val' => $section->long_size_max]) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('Max size byte for image') }}</td>
                                <td class="small">
                                    {{ __(':val B', ['val' => $section->file_size_max]) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('Monochromatic') }}</td>
                                <td class="small">
                                    {{ ($section->monochromatic_required) ? __('Monochrome only') : __('No. Color') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('RAW required') }}</td>
                                <td class="small">
                                    {{ ($section->raw_required) ? __('Required') : __('NOT required') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="small">{{ __('Unique prize for section') }}</td>
                                <td class="small">
                                    {{ ($section->unique_prize) ? __('YES, unique prize for section') : __('No. Cumulative prizes admitted') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                </dl>

                @endif

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
