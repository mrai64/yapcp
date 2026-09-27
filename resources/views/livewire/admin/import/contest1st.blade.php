<?php

/**
 * Start a job to import 3 models
 * from a yaml file written by admin.backup.user
 *
 */

use App\Models\User;
use App\Jobs\Imports\ContestAndRelated1stRestoreJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Volt\Component;

new class () extends Component {
    use WithFileUploads; // file import
    //
    public User $requesterUser;
    public $dirtYamlFile;
    public $dirtYamlPath;
    //
    public function mount()
    {
        $this->requesterUser = Auth::user();
        $this->dirtYamlFile = null; // file
        $this->dirtYamlPath = '';
    }
    //
    public function rules()
    {
        return [
            'dirtYamlFile' => 'required|file|extensions:yaml,yml,txt|max:512',
        ];
    }
    //
    public function startImportContestAndRelated()
    {
        // 1. Esegue la validazione delle regole ($this->rules())
        $this->validate();
        Log::info('Import ' . __FUNCTION__ . ' 1. requested by: ' . $this->requesterUser->name . ' id:' . $this->requesterUser->id);
        Log::info('Import ' . __FUNCTION__ . ' 2. validated');

        // 2. Salva il file in storage/app/public/imports
        // Restituisce un percorso relativo come "public/imports/filename.yaml"
        $filename = time() . '_' . $this->dirtYamlFile->getClientOriginalName();
        $relativePath = $this->dirtYamlFile->storeAs('imports', $filename, 'public');
        Log::info('Import ' . __FUNCTION__ . ' 3. file: ' . $filename);
        Log::info('Import ' . __FUNCTION__ . ' 4. path: ' . $relativePath);

        // 3. Dispatch del Job di importazione - avvio immediato
        ContestAndRelated1stRestoreJob::dispatchSync(
            $this->requesterUser,
            $relativePath
        );

        Log::info('Import ' . __FUNCTION__ . ' 5. started ');
        // 4. Feedback all'utente e reset dell'input
        session()->flash('success', __('Import started.'));
        $this->reset('dirtYamlFile');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("A Contest, adn ContestPatronage, ContestSection... importer") }}
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

                <form wire:submit="startImportContestAndRelated">
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
                            {{ __("Upload a previously written backup Contest and related. a YAML file. See manual") }}
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
