<?php

/**
 * User Applied Contest, limited to "closed contest".
 * for use in User Dashboard
 * 
 * no full page
 * @livewire('user.contest.closed', ['userId' => (string) $user->id ])
 * 
 * ! WORK IN PROGRESS 
 */

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public $userId;
    public User $user;
    public      $userTimezone;
    public $contests;
    public function mount(string $userId)
    {
        $this->userId       = $userId;
        $this->user         = User::find($userId);
        $this->userTimezone = $this->user->contact->timezone_id ?? config('app.timezone');
    }
    // next
    public function with()
    {
        // all the oen contests
        $now = CarbonImmutable::now($this->userTimezone);
        $contests = Contest::query()
            ->with([
                'country', 
                'timezone',
                'myParticipation' => fn($query) => $query->where('user_contact_id', $this->userId),
                ])
            ->where('day_2_closing', '<', $now)
            ->whereHas('myParticipation', fn ($query) => $query->where('user_contact_id', $this->userId))
            ->orderBy('day_2_closing', 'asc') // Scadenza più vicina per prima
            ->orderBy('country_id', 'asc')
            ->orderBy('name_en', 'asc')
            ->paginate(5);

        return [
            'userTimezone' => $this->userTimezone,
            'contests' => $contests,
        ];
    }
}; ?>

<div>
    <!-- no header -->
    <p class="small">
        {{ __("Some results are not available at same day")}}
    </p>
    <!-- component -->
    @if ($contests->isEmpty())
    <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
        {{ __("No closed contest w/you as participant, at now.") }}
    </div>
    @else
    <div class="mt-8">
        {{ $contests->links() }}
    </div>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <th scope="col" class="fyk border text-2xl rounded-md px-2 py-2 w-1/2 text-start text-gray-500">
                    {{ __("Participated in") }}
                </th>
                <th scope="col" class="px-2 py-3 w-1/8 text-start">{{ __('Revelation') }}</th>
                <th scope="col" class="px-2 py-3 w-1/8">{{ __('Results') }}</th>
                <th scope="col" class="px-2 py-3 w-1/8">{{ __('General') }}</th>
                <th scope="col" class="px-2 py-3 w-1/8">{{ __('Catalogue') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        </tbody>
    </table>
</div>
