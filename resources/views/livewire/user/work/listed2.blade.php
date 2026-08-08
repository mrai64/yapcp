<?php

/**
 * UserWork Grid Gallery
 *
 * Order by title_en and updated_at
 *
 */

use App\Models\UserWork;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    // Per il rendering con impaginazione di Volt
    public function with(): array
    {
        return [
            'userWorks' => UserWork::query()
                ->where('user_id', Auth::id())
                ->orderBy('title_en', 'asc')
                ->orderBy('updated_at', 'desc')
                ->paginate(12), // Portato a 12 per una griglia bilanciata (2, 3, 4 colonne)
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('My Works Gallery') }}
        </h2>
        <p class="small">
            {{ __("Ordered by international title") }}
        </p>
        <hr class="mb-4 mt-4" />
        <x-yapcp.header-link
            txt="Back to User dashboard"
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Add a new Work"
            url="{{ route('user.work.add') }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Success Message -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Errors List -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($userWorks->isEmpty())
                <!-- Empty Set -->
                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("There are no Works in platform, at now. Add one?") }}
                </h3>
                @else
                <!-- Image Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($userWorks as $work)
                        @php
                            // URL dell'immagine o placeholder
                            $imageUrl = $work->file_path ?? $work->miniature() ?? asset('images/placeholder.webp');
                        @endphp

                        <div class="bg-gray-50 border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                            <!-- Miniature Container -->
                            <div class="relative aspect-square bg-gray-100 overflow-hidden">
                                <img
                                    src="{{ asset('storage/photos') . '/' . $imageUrl }}"
                                    alt="{{ $work->title_en }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                    loading="lazy"
                                />
                            </div>

                            <!-- Work Details -->
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900 text-base truncate" title="{{ $work->title_en }}">
                                        {{ $work->title_en }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ number_format($work->width) }} &times; {{ number_format($work->height) }} px
                                    </p>
                                </div>

                                <div class="mt-4 pt-3 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ __('Last updated:')}} {{ $work->updated_at?->format('Y-m-d') ?? 'N\A' }}</span>

                                    <x-yapcp.inline-link
                                        class="w-auto"
                                        txt="Details"
                                        url="{{ url('#') }}" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginazione -->
                <div class="mt-8">
                    {{ $userWorks->links() }}
                </div>
                @endif

            </div>
            <x-footer-app />
        </div>
    </div>
</div>
