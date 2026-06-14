<?php

/**
 * Organization design for contest-section
 * follow the contest main and the contest-patronages
 * precede the contest-jury and the contest-awards
 *
 * TODO refine UI with other pages
 */
use Livewire\Volt\Component;
use App\Models\Contest;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public Contest $contest;

    // public $sections; // implicit in with()

    public function mount(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function with(): array
    {
        return [
            'sections' => $this->contest->sections()->paginate(10),
        ];
    }

    // no rules()

    // no action()

}; 

?>

<div>
    <div class="header">

        <h2 class="fyk text-xl font-bold mb-4">
            {{ __('Contest Sections') }}
        </h2>
        <h3>
            <a href="{{ route('organization.contest.modify', ['contest' => $contest ]) }}">
                <span class="fyk text-xl">{{ __('Main') }}</span>
            </a>
            . .
            <a href="{{ route('organization.design.contest-section.listed', ['contest' => $contest]) }}">
                <span class="fyk text-xl">{{ __('Sections') }}</span>
            </a>
            . .
            <a href="{{ route('organization.contest-jury.listed', ['sid' => ContestSection::firstContestSectionId( $contest->id )] ); }}">
                <span class="fyk text-xl">{{ __('Jury') }}</span>
            </a>
            . .
            <a href="{{ route('organization.contest-award.listed', ['contest' => $contest]) }}">
                <span class="fyk text-2xl">{{ __('Awards') }}</span>
            </a>
            . .
            <a href="{{ route('contest-participant.modify', ['contest' => $contest]) }}">
                <span class="fyk text-xl">{{ __('Participants') }}</span>
            </a>
            . .
            <a href="{{ route('organization.contest.list', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">{{ __('Works') }}</span>
            </a>
        </h3>
    </div>

    <p>
        <a href="{{ route('organization.contest-section.add', ['contest' => $contest]) }}">
            <span class="fyk text-xl">+ {{ __('Add New Section')}}</span>
        </a>
    </p>

    @if($sections->isEmpty())
        <p>{{ __('No sections defined yet. Add first.') }}</p>
    @else
        <dl class="space-y-4">
            @foreach($sections as $section)
                <div class="border-b pb-2">
                    <dt class="font-semibold text-lg text-indigo-600">
                        {{ $section->code }} 
                        / {{ $section->name_en }} 
                        <span class="text-sm font-normal text-gray-500">({{ $section->short_name }})</span>
                    </dt>
                    <dd class="mt-1 text-gray-700">
                        {{ $section->synopsis ?? __('No description provided.') }}
                    </dd>
                    <dd class="mt-1 text-xs text-gray-400">
                        {{ __('Rule details') }}: 
                        <br >
                        {{ __('formats')}} : {{ $section->file_formats }}.
                        {{ __(' From :minW to :maxW works.', ['minW' => $section->min_works, 'maxW' => $section->max_works']) }}
                        {{ __('Max :short px short-size',['short' => $section->short_size_max]) }},
                        {{ __('Max :long px long-size',['long' => $section->long_size_max]) }}.
                        {{ __('Max :weight Bytes file size',['weight' => $section->file_size_max]) }}.<br />
                        @if ($section->monochromatic_required)
                            {{ __('Monochromatic required')}}<br />
                        @else
                            {{ __('Color')}}<br />
                        @endif
                        @if ($section->raw_required)
                            {{ __('RAW required')}}<br />
                        @else
                            {{ __('RAW not required')}}<br />
                        @endif
                        @if ($section->unique_prize)
                            {{ __('There is only one prize per author per section-theme')}}<br />
                        @else
                            {{ __('Combinable prizes per author')}}<br />
                        @endif
                    </dd>
                    <dd class="mt-1 text-xs text-gray-400">
                        <a href="{{ route('organization.contest-section.modify', ['section' => $section ]) }}">
                            <span class="fyk text-xl">{{ __('Modify')}}</span>
                        </a>
                        . .
                        <a href="{{ route('organization.contest-section.remove', ['section' => $section ]) }}">
                            <span class="fyk text-xl">{{ __('Remove')}}</span>
                        </a>
                    </dd>
                </div>
            @endforeach
        </dl>

        <div class="mt-4">
            {{ $sections->links() }}
        </div>
    @endif
</div>
