<?php

/**
 * Start a job to backup n models
 * - Contest
 *   - ContestPatronage
 *   - ContestSection
 *   - ContestJury
 *   - ContestWork
 *
 */

use App\Jobs\Backups\ContestAndRelatedBackup2ndJob;
use App\Models\Contest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class () extends Component {
    use WithPagination;
    public DateTimeImmutable $startBackupFrom;
    public string $contestId = '';
    //
    public function with()
    {
        return [
            'contests' => Contest::query()
                ->with(['country'])
                ->orderBy('country_id', 'asc')
                ->orderBy('name_en', 'asc')
                ->paginate(10),
        ];
    }
    //
    function rules()
    {
        return [
            'contestId' => 'string|exists:contests,id',
        ];
    }
    //
    public function startBackupJob(?string $contestId = null)
    {
        // Se viene passato un ID lo assegna alla proprietà, altrimenti usa quella esistente o 'all'
        if ($contestId !== null) {
            $this->contestId =$contestId;
        }

        if ($this->contestId &&$this->contestId !== 'all') {
            $validated =$this->validate();
        } else {
            $validated = ['contestId' => 'all'];
        }

        Log::info('UserAndRelatedBackupJob requested by: ' . Auth::user()->name . ', id:' . Auth::user()->id);

        $res = ContestAndRelatedBackup2ndJob::dispatchSync(
            contestId: $validated['contestId'],
            requesterUser: Auth::user(),
            backupSince: null
        );

        return redirect()
            ->route('admin.dashboard')
            ->with('success', __('Backup Job requested!'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Start Backup Job') }}
        </h2>
        <hr class="my-2" />
        <p class="fyk text-xl">
            {{ __("Prepare a backup yaml file with all Contest and all ContestWork data") }}
        </p>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link 
            txt="Back to Admin dashboard" 
            url="{{ route('admin.dashboard') }}" />
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

                @if ($contests->isEmpty())
                <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
                    {{ __('There are currently no contest to backup.') }}
                </div>
                @else
                <div class="paginationDiv">
                    {{ $contests->links() }}
                </div>

                <table class="data-table-container w-auto">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-section-counter">{{ __("#")}}</th>
                            <th scope="col" class="data-table-section-counter">{{ __("Country")}}</th>
                            <th scope="col" class="data-table-section-code">{{ __("Contest")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contests as $deltaItem => $contest)
                        <tr class="border my-2">
                            <td valign="top" class="small">
                                {{ $contests->firstItem() + $deltaItem }}&nbsp;&nbsp;
                            </td>
                            <td valign="top" class="fyk text-2xl text-center">
                                <form wire:submit="startBackupJob('{{$contest->id}}')">
                                    {{ $contest->country->flag_code }} {{ $contest->country_id }}
                                    <x-button class="mt-2 ms-4 w-auto">
                                        {{ __('Backup me') }}
                                    </x-button>
                                </form>
                            </td>
                            <td valign="top" class="fyk text-xl">
                                {{ $contest->name_en }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                
                <hr class="my-4" />

                <form wire:submit="startBackupJob('all')">
                    <x-button class="mt-2 ms-4">
                        {{ __('Start Job, now!') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
