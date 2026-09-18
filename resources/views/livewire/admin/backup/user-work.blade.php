<?php

/**
 * Start a job to backup N models
 * - UserWork
 * - User
 * - UserContact
 * - UserWorkMore
 *
 */

use App\Jobs\Backups\UserWorkAndRelatedSingleBackupJob;
use App\Models\User;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

new class () extends Component {
    //
    public DateTimeImmutable $startBackupFrom;
    public $backuppedUsers;
    //
    // TODO bisogna chiedere un array di utenti? checkbox di selezione e via
    //
    public function mount(string $backuppedUser)
    {   // era User $backupped, poi User|string ma arriva sempre string all|uuid
        // 0. authorized? - done in route
        if (! Auth::user()->isAdmin()) {
            $this->redirectRoute('user.dashboard', navigate: true);
            return;
        }
        // 1. whois the backupped User?
        // $this->backuppedUsers = ($backuppedUser === 'all') ? $backuppedUser : $backuppedUser->contact;
        if ($backuppedUser === 'all') {
            $this->backuppedUsers = 'all';
        } else {
            // pick uuid
            $userContact = UserContact::withTrashed()->findOrFail($backuppedUser);
            // log
            $this->backuppedUsers = $userContact;
        }
    }
    //
    public function startBackupJob()
    {
        // $validated
        // register
        Log::info('UserWorkAndRelatedSingleBackupJob requested by: ' . Auth::user()->name . ', id:' . Auth::user()->id);

        if ($this->backuppedUsers === 'all') {
            Log::info('UserWorkAndRelatedSingleBackupJob requested for: all');
            UserWorkAndRelatedSingleBackupJob::dispatchSync(
                requesterUser: Auth::user(),
            );
        } else {
            Log::info('UserWorkAndRelatedSingleBackupJob requested for: ' . $this->backuppedUsers->user->name);
            UserWorkAndRelatedSingleBackupJob::dispatchSync(
                requesterUser: Auth::user(),
                backuppedUser: $this->backuppedUsers->user,
            );
        }
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
            txt="User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link 
            txt="Admin dashboard" 
            url="{{ route('admin.dashboard') }}" />
        <x-yapcp.header-link 
            txt="User Contact Index" 
            url="{{ route('admin.user-contact.listed') }}" />
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

                <div class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Start Backup Job') }}
                    @if ($backuppedUsers === 'all')
                    <br />
                    {{ __("For All, Ok, but it's a long and huge work.")}}
                    @else
                    <br />
                    {{ $backuppedUsers->country->flag_code }}
                    {{ $backuppedUsers->country->country }}
                    <br />
                    {{ $backuppedUsers->last_name }}
                    {{ $backuppedUsers->first_name }}
                    <br />
                    {{ $backuppedUsers->email }}
                    <br />
                    {{ $backuppedUsers->city }}
                    {{ $backuppedUsers->address }}
                    @endif
                </div>

                <form wire:submit="startBackupJob">
                    @csrf

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
