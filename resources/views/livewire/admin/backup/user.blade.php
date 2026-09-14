<?php

/**
 * Start a job
 */

use App\Jobs\Backups\UserAndRelatedBackupJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Volt\Component;

new class extends Component {
    //
    public DateTimeImmutable $startBackupFrom;
    // mount() read a datetime
    // rules() datetime 
    public function startBackupJob()
    {
        // $validated
        // register
        Log::info('UserAndRelatedBackupJob requested by: ' . Auth::user()->name . ', id:' . Auth::user()->id );
        // accodamento
        // nota: dispatch() richiede uno sblocco dei lavori, dispatchSync() avvia subito i lavori
        $res = UserAndRelatedBackupJob::dispatchSync(
            requesterUser: Auth::user(),
            backupSince: null
        );
        // redirect
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

                <form wire:submit="startBackupJob">
                    @csrf

                    <!-- insert datetime field-->

                    <br style="clear:both;" />

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
