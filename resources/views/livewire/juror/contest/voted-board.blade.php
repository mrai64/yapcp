<?php
/**
 * Contest Manage - Juror re-vote board
 *
 * For section - after voted, all images in miniature
 * are exposed for change vote. 12 or 18 or 24 pose.
 *
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\Organization;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public ContestSection $contestSection;
    public Organization   $organization;
    public Contest        $contest;
    public                $contestVotedSet;
    public                $juror;
    // first
    public function mount(ContestSection $contestSection) // as route
    {
        // can cannot
        $this->contestSection = $contestSection;
        $this->contest        = $contestSection->contest;
        $this->organization   = $this->contest->organization;
        $juror                = Auth::user();
        $this->juror          = $juror->userContact;
        //
    }
    // for every page
    public function with(): array
    {
        return [
            'contestVotedSet' => ContestVote::query()
                ->with(['contestWork'])
                ->where('section_id', $this->contestSection->id)
                ->where('juror_user_id', $this->juror->id)
                ->orderBy('updated_at')
                ->paginate(6),
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Jury works for Contest :contestName", ['contestName' => $contest->name_en ]) }}
        </h2>
        <hr class="my-2" />
        <h3 class="fyk text-xl font-medium text-gray-900">
            {{ __("From: :opening to :closing (last meet included)", ['opening' => $contest->day_3_jury_opening->format('Y-m-d') , 'closing' => $contest->day_4_jury_closing->format('Y-m-d') ]) }}
            <br />
            {{ __("Organization: " . $contest->organization->country->flag_code . ' ' . $contest->organization->country_id . ' | ' . $contest->organization->name ) }}
        </h3>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
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

                <div class="paginationDiv">
                    {{ $contestVotedSet->links() }}
                </div>
                <!-- griglia -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
                    @forelse ($contestVotedSet as $contestVote)
                    <div class="flex flex-col items-center">
                        <!-- Riquadro immagine fisso a 300px -->
                        <div style="width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);">
                            <img src="{{ asset('storage/contests') . '/' . $contestVote->contestWork->contest_id . '/' . $contestVote->contestWork->section_id . '/' . $contestVote->contestWork->id . '.' . $contestVote->contestWork->userWork->file_format }}" 
                            _loading="lazy"
                            style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;" 
                            />
                        </div>

                        <!-- Link sottostante e centrato -->
                        <div class="mt-2 fyk text-2xl">
                            Vote: {{ $contestVote->vote }}
                            <x-yapcp.inline-link 
                                txt="Change" 
                                url="{{ route('user.dashboard') }}" />
                        </div>
                    </div>
                    @empty
                    <h3 class="fyk text-xl font-medium text-gray-900 col-span-full">
                        {{ __("No vote here?!") }}
                    </h3>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
