<?php

/**
 * Organization Contest Docs Manage - Dedicated Upload form for files into
 * /storage/app/public/contests/<contest.id>/_docs
 */

use App\Models\Contest;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Volt\Component;

new class extends Component {
    use WithFileUploads;

    public Contest $contest;
    public Organization $organization;

    /**
     * Uploaded files from the input form
     *
     * @var array<\Livewire\Features\SupportFileUploads\TemporaryUploadedFile>
     */
    public array $uploads = [];

    public function mount(Contest $contest): void
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;

        // Authorize: only admin or members of contest organization
        $this->authorize('update', [Contest::class, $this->contest]);

        // Ensure the directory exists
        $folder = 'contests/' . $this->contest->id . '/_docs';
        if (! Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }
    }

    /**
     * Upload one or more files to the _docs directory and redirect to listed
     */
    public function uploadFiles()
    {
        $this->validate([
            'uploads' => 'required|array|min:1',
            'uploads.*' => 'file|max:51200', // max 50MB per file
        ]);

        $folder = 'contests/' . $this->contest->id . '/_docs';
        if (! Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        $count = 0;
        foreach ($this->uploads as $file) {
            $originalName = $file->getClientOriginalName();
            $safeName = basename($originalName);
            // Sanitize filename to avoid harmful path manipulation
            $safeName = preg_replace('/[^\w\s\d\-_~,;\[\]\(\).]/u', '', $safeName);
            $safeName = preg_replace('/\s+/', ' ', $safeName);

            $file->storeAs($folder, $safeName, 'public');
            $count++;
        }

        $this->reset('uploads');

        if (Route::has('organization.docs.listed')) {
            return redirect()
                ->route('organization.docs.listed', ['contest' => $this->contest])
                ->with('success', __(':count file(s) uploaded successfully to _docs.', ['count' => $count]));
        }

        session()->flash('success', __(':count file(s) uploaded successfully to _docs.', ['count' => $count]));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight">
            {{ __("Upload Documents to _docs:") }}
            <br />
            {{ $contest->name_en }}
        </h2>
        <hr class="my-2" />
        <p class="fyk text-xl">
            {{ __("Your org: :organization", ['organization' => $organization->name]) }}
        </p>
        <hr class="my-2" />
        <div class="fyk text-xl text-gray-600">
            {{ __("Destination folder:") }}
            <span class="font-mono text-sm text-gray-800 bg-gray-100 px-2 py-1 rounded">
                /storage/app/public/contests/{{ $contest->id }}/_docs/
            </span>
        </div>
        <hr class="my-4" />
        <x-yapcp.header-link 
            txt="User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Org Dashboard"
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        @if (Route::has('organization.docs.listed'))
        <x-yapcp.header-link
            txt="View Documents list"
            url="{{ route('organization.docs.listed', ['contest' => $contest]) }}" />
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash & Error Messages -->
            @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-md fyk text-xl">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-300 rounded-md">
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Dedicated Upload Form Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk font-semibold text-2xl text-gray-800 mb-2">
                    📤 {{ __("Select files to upload") }}
                </h3>
                <p class="text-gray-600 mb-6 text-sm">
                    {{ __("Upload documents for this contest (signed jury minutes, regulations, official scan copies, archives). Max 50 MB per file.") }}
                </p>

                <form wire:submit="uploadFiles" class="space-y-6">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-indigo-500 transition-colors">
                        <input 
                            type="file" 
                            wire:model="uploads" 
                            multiple 
                            id="dedicated-uploads-input"
                            class="hidden"
                        />
                        <label for="dedicated-uploads-input" class="cursor-pointer block">
                            <div class="text-5xl mb-3">📁</div>
                            <span class="text-indigo-600 hover:text-indigo-800 font-semibold text-lg">
                                {{ __("Click here to select files") }}
                            </span>
                            <div class="text-gray-500 text-sm mt-1">
                                {{ __("Select one or more files to upload to _docs") }}
                            </div>
                        </label>

                        <div wire:loading wire:target="uploads" class="mt-4 text-indigo-600 font-medium">
                            ⏳ {{ __("Uploading file(s) to temporary buffer, please wait...") }}
                        </div>
                    </div>

                    <!-- Selected files preview -->
                    @if (!empty($uploads))
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h4 class="font-semibold text-sm text-gray-700 mb-2">
                            {{ __("Files ready for upload:") }}
                        </h4>
                        <ul class="text-sm space-y-1 text-gray-600">
                            @foreach ($uploads as $file)
                            <li class="flex items-center space-x-2">
                                <span>📄 {{ $file->getClientOriginalName() }}</span>
                                <span class="text-xs text-gray-400 font-mono">({{ round($file->getSize() / 1024, 1) }} KB)</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="flex items-center space-x-4">
                        <x-button type="submit" wire:loading.attr="disabled" :disabled="empty($uploads)">
                            <span wire:loading.remove wire:target="uploadFiles">💾 {{ __("Upload and Save to _docs") }}</span>
                            <span wire:loading wire:target="uploadFiles">⏳ {{ __("Uploading...") }}</span>
                        </x-button>

                        @if (Route::has('organization.docs.listed'))
                        <a href="{{ route('organization.docs.listed', ['contest' => $contest]) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            {{ __("Cancel / View Files") }}
                        </a>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>

    <x-footer-app />
</div>
