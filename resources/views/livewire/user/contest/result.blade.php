<?php

/**
 * User have selected a closed contest and can see
 *   his/her participation with result
 * 
 * input: contest id + auth user
 * 
 * ! WORK IN PROGRESS 
 * Si tratta di definire l'elenco delle opere partecipanti del concorrente,
 * ordinate per sezione e titolo, affiancate dall'esito nel concorso
 * (ammissione si / no) e un eventuale premio ricevuto
 * più un eventuale premio di concorso
 *
 */

use App\Models\Contest;
use App\Models\ContestWork;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    //
    // NoPagination
    //
    public User     $user;
    public Contest  $contest;
    public          $userContact;
    public          $userWorks;
    public          $contestWorks;
    public          $contestSections;
    // first
    public function mount(Contest $contest)
    {
        // can / cannot ? class contestWork, but input contest
        $this->authorize('create', [ContestWork::class, $contest]);
        $this->userContact = Auth::user->userContact;
        //
        $this->contest = $contest;
        $this->contestSections = $contest->sections;
        $this->user = Auth::user();
        $this->contestWorks = ContestWork::query()
            ->with(['userContact.userWork.contestSection.contestAward'])
            ->where('user_id', $this->user->id)
            ->where('contest_id', $this->contest->id)
            ->orderBy('contestSection.code')
            ->orderBy('userWorks.title_en')
            ->get();

    }

}; ?>

    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Contest Result for :userName" , ['userName' => $userContact->first_name] . ' ' . $userContact->last_name) }}
        </h2>
        <p class="small">
            {{ __("Participated in contest :contestName", ['contestName' => $contest->name]) }}
            <br />
            {{ __("Note: upto 'revelation day' all admit counter are forced at zero") }}
        </p>
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

                <!-- board of participation for user -->
                @foreach ($contestSections as $contestSection)
                    {{$contestSection->code}}
                    |
                    {{$contestSection->name_en}}
                    | 
                    {{$contestSection->under_patronage ? __("under patronage") : __("patronage free")}}


                @endforeach
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
