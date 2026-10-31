<?php

/**
 * Organization Contest Docs Manage - List, download, delete, upload files in
 * /storage/app/public/contests/<contest.id>/_docs
 */

use App\Models\Contest;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
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
     * Retrieve the list of files in the _docs directory with metadata
     *
     * @return array<int, array{name: string, path: string, size: int, size_formatted: string, last_modified: Carbon, last_modified_formatted: string, extension: string}>
     */
    #[Computed]
    public function files(): array
    {
        $folder = 'contests/' . $this->contest->id . '/_docs';

        if (! Storage::disk('public')->exists($folder)) {
            return [];
        }

        $allPaths = Storage::disk('public')->files($folder);
        $fileList = [];

        foreach ($allPaths as $path) {
            $filename = basename($path);

            // Skip hidden or system files (.DS_Store, .gitignore, etc.)
            if (str_starts_with($filename, '.')) {
                continue;
            }

            $size = Storage::disk('public')->size($path);
            $lastModified = Carbon::createFromTimestamp(Storage::disk('public')->lastModified($path));
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            $fileList[] = [
                'name' => $filename,
                'path' => $path,
                'size' => $size,
                'size_formatted' => $this->formatBytes($size),
                'last_modified' => $lastModified,
                'last_modified_formatted' => $lastModified->format('d/m/Y H:i:s'),
                'extension' => $extension,
            ];
        }

        // Sort files by last modified descending (most recently updated first)
        usort($fileList, fn ($a, $b) => $b['last_modified']->timestamp <=> $a['last_modified']->timestamp);

        return $fileList;
    }

    /**
     * Download a file from the _docs folder
     */
    public function downloadFile(string $filename)
    {
        $safeFilename = basename($filename);
        $path = 'contests/' . $this->contest->id . '/_docs/' . $safeFilename;

        if (! Storage::disk('public')->exists($path)) {
            session()->flash('error', __('File ":file" not found.', ['file' => $safeFilename]));
            return null;
        }

        return Storage::disk('public')->download($path, $safeFilename);
    }

    /**
     * Delete a file from the _docs folder
     */
    public function deleteFile(string $filename): void
    {
        $safeFilename = basename($filename);
        $path = 'contests/' . $this->contest->id . '/_docs/' . $safeFilename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            session()->flash('success', __('File ":file" deleted successfully.', ['file' => $safeFilename]));
        } else {
            session()->flash('error', __('File ":file" not found.', ['file' => $safeFilename]));
        }
    }

    /**
     * Upload one or more files to the _docs directory
     */
    public function uploadFiles(): void
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

        session()->flash('success', __(':count file(s) uploaded successfully.', ['count' => $count]));
    }

    /**
     * Format bytes into a readable string (B, KB, MB, GB)
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight">
            {{ __("Contest Documents (_docs):") }}
            <br />
            {{ $contest->name_en }}
        </h2>
        <hr class="my-2" />
        <p class="fyk text-xl">
            {{ __("Your org: :organization", ['organization' => $organization->name]) }}
        </p>
        <hr class="my-2" />
        <div class="fyk text-xl text-gray-600">
            {{ __("Folder path:") }}
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
        @if (Route::has('organization.contest-work.listed'))
        <x-yapcp.header-link
            txt="Contest Review"
            url="{{ route('organization.contest-work.listed', ['contest' => $contest]) }}" />
        @endif
        @if (Route::has('organization.docs.add'))
        <x-yapcp.header-link
            txt="Dedicated Upload Page"
            url="{{ route('organization.docs.add', ['contest' => $contest]) }}" />
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

            @if (session('error'))
            <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-md fyk text-xl">
                ❌ {{ session('error') }}
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

            <!-- Upload Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk font-semibold text-2xl text-gray-800 mb-2">
                    📤 {{ __("Upload new file(s) into _docs") }}
                </h3>
                <p class="text-gray-600 mb-4 text-sm">
                    {{ __("Select one or more documents (PDF, scans, signed minutes, regulations, images, archives) up to 50 MB each.") }}
                </p>

                <form wire:submit="uploadFiles" class="space-y-4">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-500 transition-colors">
                        <input 
                            type="file" 
                            wire:model="uploads" 
                            multiple 
                            id="uploads-input"
                            class="hidden"
                        />
                        <label for="uploads-input" class="cursor-pointer block">
                            <div class="text-4xl mb-2">📁</div>
                            <span class="text-indigo-600 hover:text-indigo-800 font-medium">
                                {{ __("Click here to choose files") }}
                            </span>
                            <span class="text-gray-500"> {{ __("or select multiple files") }}</span>
                        </label>

                        <div wire:loading wire:target="uploads" class="mt-3 text-indigo-600 font-medium">
                            ⏳ {{ __("Uploading to temporary storage, please wait...") }}
                        </div>
                    </div>

                    <!-- Selected files preview before submitting -->
                    @if (!empty($uploads))
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h4 class="font-semibold text-sm text-gray-700 mb-2">
                            {{ __("Selected files ready to upload:") }}
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

                    <div class="flex items-center space-x-3">
                        <x-button type="submit" wire:loading.attr="disabled" :disabled="empty($uploads)">
                            <span wire:loading.remove wire:target="uploadFiles">💾 {{ __("Save Files to _docs") }}</span>
                            <span wire:loading wire:target="uploadFiles">⏳ {{ __("Saving...") }}</span>
                        </x-button>

                        @if (!empty($uploads))
                        <x-secondary-button wire:click="$set('uploads', [])">
                            {{ __("Cancel") }}
                        </x-secondary-button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Files List Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4 border-b pb-3">
                    <h3 class="fyk font-semibold text-2xl text-gray-800">
                        📂 {{ __("Files in _docs") }}
                    </h3>
                    <span class="text-sm text-gray-500 font-medium">
                        {{ __("Total files:") }} {{ count($this->files) }}
                    </span>
                </div>

                @if (empty($this->files))
                <div class="text-center py-10 text-gray-500">
                    <div class="text-5xl mb-3">📭</div>
                    <p class="fyk text-2xl font-medium text-gray-700">
                        {{ __("No documents uploaded yet.") }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ __("Files uploaded into _docs will appear here with their last update timestamp.") }}
                    </p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="data-table-container w-full text-left">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-600 text-sm">
                                <th class="py-3 px-4">#</th>
                                <th class="py-3 px-4">{{ __("File name") }}</th>
                                <th class="py-3 px-4">{{ __("Size") }}</th>
                                <th class="py-3 px-4">{{ __("Last updated") }}</th>
                                <th class="py-3 px-4 text-right">{{ __("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @foreach ($this->files as $index => $file)
                            <tr class="hover:bg-gray-50" wire:key="doc-{{ $file['name'] }}">
                                <td class="py-3 px-4 text-gray-400 font-mono text-xs">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-800">
                                    <div class="flex items-center space-x-2">
                                        @if (in_array($file['extension'], ['pdf']))
                                            <span class="text-red-500 text-lg">📕</span>
                                        @elseif (in_array($file['extension'], ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                                            <span class="text-blue-500 text-lg">🖼️</span>
                                        @elseif (in_array($file['extension'], ['zip', 'rar', '7z', 'tar', 'gz']))
                                            <span class="text-yellow-600 text-lg">📦</span>
                                        @elseif (in_array($file['extension'], ['doc', 'docx', 'odt', 'rtf', 'txt', 'md']))
                                            <span class="text-blue-600 text-lg">📝</span>
                                        @elseif (in_array($file['extension'], ['xls', 'xlsx', 'csv']))
                                            <span class="text-green-600 text-lg">📊</span>
                                        @else
                                            <span class="text-gray-500 text-lg">📄</span>
                                        @endif
                                        <span class="font-mono text-sm break-all">{{ $file['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-mono text-xs text-gray-600">
                                    {{ $file['size_formatted'] }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    <div class="font-medium text-gray-800">
                                        {{ $file['last_modified_formatted'] }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $file['last_modified']->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <!-- Download Button -->
                                    <x-secondary-button 
                                        wire:click="downloadFile('{{ $file['name'] }}')"
                                        title="{{ __('Download') }}"
                                    >
                                        📥 {{ __("Download") }}
                                    </x-secondary-button>

                                    <!-- Delete Button -->
                                    <x-danger-button 
                                        wire:click="deleteFile('{{ $file['name'] }}')"
                                        wire:confirm="{{ __('Are you sure you want to permanently delete: :file?', ['file' => $file['name']]) }}"
                                        title="{{ __('Delete') }}"
                                    >
                                        🗑️ {{ __("Delete") }}
                                    </x-danger-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>

    <x-footer-app />
</div>
