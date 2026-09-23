<?php

/**
 * Job to import an editable or edited Yaml for models:
 * - User
 * - UserContact
 * - UserContactMore (TODO)
 * - UserWork
 * - UserWorkMore
 */

use App\Models\User;
use App\Jobs\Imports\UserWorkAndRelatedImportYamlJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Volt\Component;

new class () extends Component {
    //
    use WithFileUploads;
    public User $requesterUser;
    public $dirtYamlFile; // file input
    public $dirtYamlPath; // uploaded input file path
    //
    public function mount()
    {
        $this->requesterUser  = Auth::user();
        $this->dirtYamlFile   = null;
        $this->dirtYamlPath   = '';
    }
    //
    public function rules()
    {
        return [
            'dirtYamlFile' => 'required|file|extensions:yaml,yml,txt|max:512',
        ];
    }
    //
    public function startImportUserWorkAndRelated()
    {
        // 1. Esegue la validazione delle regole ($this->rules())
        Log::info('Import ' . __FUNCTION__ . ' 1. requested by: ' . $this->requesterUser->name . ' id:' . $this->requesterUser->id);
        $this->validate();
        Log::info('Import ' . __FUNCTION__ . ' 2. validated');

        // 2. Salva il file in storage/app/public/imports
        // Restituisce un percorso relativo come "public/imports/filename.yaml"
        $filename = time() . '_' . $this->dirtYamlFile->getClientOriginalName();
        $relativePath = $this->dirtYamlFile->storeAs('imports', $filename, 'public');
        Log::info('Import ' . __FUNCTION__ . ' 3. file: ' . $filename);
        Log::info('Import ' . __FUNCTION__ . ' 4. path: ' . $relativePath);

        // 3. Dispatch del Job di importazione - avvio immediato
        UserWorkAndRelatedImportYamlJob::dispatchSync(
            $this->requesterUser,
            $relativePath
        );

        Log::info('Import ' . __FUNCTION__ . ' 5. started ');
        // 4. Feedback all'utente e reset dell'input - non 'salta' fuori
        session()->flash('success', __('Import started.'));
        $this->reset('dirtYamlFile');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("A User, UserContact, UserWork, UserWorkMore importer for an edited yaml file") }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.header-link
            txt="Back to dashboard"
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
                @endif

                <!-- errors list -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="fyk text-xl">
                    {{ __("As member of admins group you can do backup and restore.") }}
                    <br />
                    {{ __("So, that form allow you to upload ad insert in platform a yaml file edited.") }}
                    <br />
                    {{ __("Unload the sample file from the manual, edit it than.") }}
                    <br />
                    <x-yapcp.inline-link
                        txt="The Manual | Import Yaml for UserWork"
                        url="/docs/1.0/admin/import/userwork" />
                </div>

                <form wire:submit="startImportUserWorkAndRelated">
                    @csrf

                    <!-- passport photo upload -->
                    <div class="block mb-4">
                        <x-input-label for="dirtYamlFile" :value="__('A previous Backup file')" />
                        <input
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1"
                            type="file" accept="text/plain,text/yaml,application/x-yaml,text/x-yaml,.yaml,.yml,.txt"
                            name="dirtYamlFile" wire:model="dirtYamlFile"
                            aria-describedby="yamlHelp" />
                        <div wire:loading wire:target="dirtYamlFile">{{ __("Uploading...")}}</div>
                        <div class="small" id="yamlHelp">
                            {{ __("Upload a previously written backup User, UserContact, UserContactMore. a YAML file. See manual.") }}
                        </div>
                        <x-input-error for="dirtYamlFile" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Submit a yaml file') }}
                    </x-button>

                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
