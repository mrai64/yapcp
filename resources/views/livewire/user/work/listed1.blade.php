<?php

/**
 * UserWork listed Gallery
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

    // pagination means:
    // no mount(), no render()
    // with() YES

    // Per il rendering con impaginazione di Volt
    public function with(): array
    {
        return [
            'userWorks' => UserWork::query()
                ->where('user_id', Auth::id())
                ->orderBy('title_en', 'asc')
                ->orderBy('updated_at', 'desc')
                ->paginate(10),
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <x-slot name="header">
            <h2 class="fyk text-2xl font-medium text-gray-900">
                {{ __('My Works Gallery') }}
        </h2>
        <p class="small">
            {{ __("Ordered by country_id, then organization name") }}
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

                @if ($userWorks->isEmpty())
                <!-- empty set -->
                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("There are no Works in platform, at now. Add one?") }}
                </h3>
                @else
                <!-- tabled list-->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3">{{ __('Title (EN)') }}</th>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('Width (px)') }}</th>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('Height (px)') }}</th>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('Updated At') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($userWorks as $work)
                                @php
                                    // Calcolo delle dimensioni (width / height) basato sui dati in DB (long_size / short_size)
                                    // Se non specificato diversamente, assumiamo landscape o adattiamo in base alla risoluzione
                                    $isLandscape = $work->long_size >= $work->short_size;
                                    $width = $isLandscape ? $work->long_size : $work->short_size;
                                    $height = $isLandscape ? $work->short_size : $work->long_size;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <!-- Title EN -->
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $work->title_en }}
                                    </td>

                                    <!-- Width -->
                                    <td class="px-6 py-4 text-center">
                                        {{ number_format($width) }} px
                                    </td>

                                    <!-- Height -->
                                    <td class="px-6 py-4 text-center">
                                        {{ number_format($height) }} px
                                    </td>

                                    <!-- Updated At -->
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        {{ $work->updated_at?->format('Y-m-d H:i') ?? 'N\A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginazione -->
                <div class="mt-4">
                    {{ $userWorks->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</div>