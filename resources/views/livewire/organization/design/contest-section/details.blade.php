<?php

/**
 * Organization Contest Design / Contest Section themes and juries
 */

use App\Models\Contest;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest       $contest;
    public Organization  $organization;
    public               $contestWithData;

    public function mount(Contest $contest)
    {
        $this->contest =      $contest;
        $this->organization = $contest->organization;
        // eager loading
        // contest > contestSections > contestJuries > userContact
        $this->contestWithData = Contest::with(['contestSections.contestJuries.userContact'])
            ->find($contest->id);
    }
}; ?>

<div>
    <p class="fyk text-2xl mt-6">
        {{ __("Sections n themes") }}
    </p>
    <dl>
        @foreach ($contestWithData->contestSections as $section)
        <div class="mb-4 w-full">
            <div class="fyk text-2xl font-medium text-gray-900">
                {{ $section->code }}
                {{ $section->name_en }}
            </div>
            <div class="grid grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-4">
                <div class="p-2 border rounded shadow">
                    @if ($section->min_works)
                    {{ __("Between :min to :max works ", ['min' => $section->min_works, 'max' => $section->max_works]) }}
                    @else
                    {{ __("Up to :max works ", ['max' => $section->max_works]) }}
                    @endif
                </div>
                <div class="p-2 border rounded shadow">
                    {{ __("Max shorter size: :max px", ['max' => $section->short_size_max]) }}
                </div>
                <div class="p-2 border rounded shadow">
                    {{ __("Max longer size: :max px", ['max' => $section->long_size_max]) }}
                </div>
                <div class="p-2 border rounded shadow">
                    {{ __("Max file size: :max B", ['max' => $section->file_size_max]) }}
                </div>
                <div class="p-2 border rounded shadow">
                    {{ ($section->monochromatic_required) ? __("Exclusively Monochromatic") : __("Colored") }}
                </div>
                <div class="p-2 border rounded shadow">
                    {{ ($section->raw_required) ? __("RAW maybe requested anytime") : __("RAW not required") }}
                </div>
                <div class="p-2 border rounded shadow">
                    {{ ($section->unique_prize) ? __("NO cumulative prizes in section") : __("Auth CAN cumulate prize in section") }}
                </div>
            </div>
            @foreach ($section->contestJuries as $juror)
            <div class="w-auto inline-float my-2">
                {{ ($juror->is_president) ? __("Jury President") : __("Juror") }} 
                {{ __("From") }}
                {{ $juror->userContact->country->flag_code }} 
                {{ $juror->userContact->country->country }} 
                <strong class="fyk text-xl">
                    {{ $juror->userContact->last_name }}, 
                    {{ $juror->userContact->first_name }} 
                </strong>
            </div>
            @endforeach
        </div>
        <hr class="my-4" />
        @endforeach
    </dl>
</div>
