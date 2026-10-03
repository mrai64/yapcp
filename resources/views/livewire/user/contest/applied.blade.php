<?php

/**
 * User Applied Contest, limited to "open contest".
 * for use in User Dashboard
 * 
 * no full page
 * @livewire('user.contest.applied', ['userId' => (string) $user->id ])
 */

use App\Models\Contest;
use App\Models\ContestWork;
use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public $userId;
    public User $user;
    public $userTimezone;
    public $contests;
    // first
    public function mount(string $userId)
    {
        $this->user = User::find($userId);
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
            ->where('day_1_opening', '<=', $now)
            ->where('day_2_closing', '>=', $now)
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
    <!-- component -->
    @if ($contests->isEmpty())
    <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
        {{ __("No open contest w/you as participant, at now.") }}
    </div>
    @else
    <div class="mt-8">
        {{ $contests->links() }}
    </div>

    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <th scope="col" class="fyk border text-2xl rounded-md px-2 py-2 w-1/2 text-start text-gray-500">
                    {{ __("Participant in") }}
                </th>
                <th scope="col" class="px-2 py-3 w-1/6 text-start">{{ __('Deadline') }}</th>
                <th scope="col" class="px-2 py-3 w-1/6">{{ __('Rules') }}</th>
                <th scope="col" class="px-2 py-3 w-1/6">{{ __('Link to') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        @foreach ($contests as $index => $contest)
        <tr>
            <td valign="top" class="fyk text-2xl text-start w-1/2">
                {{ $contest->country?->flag_code }} {{ $contest->name_en }}
            </td>
            <td valign="top"  class="fyk text-xl">
                @if ($contest->myParticipation->fee_payment_completed)
                <span title="{{ __('Subscription completed') }}">✅</span>
                @else
                <span title="{{ __('Subscription NOT completed, contact organization') }}">🟨</span>
                @endif
                {{ $contest->day_2_closing->setTimezone($userTimezone)->format('Y-m-d H:i') }}
            </td>
            <td valign="top"  class="text-center">
                <x-yapcp.header-link 
                    class="w-auto"
                    txt="Rules" 
                    url="{{$contest->url_1_rule}}" />
            </td>
            <td valign="top"  class="text-center">
                <x-yapcp.header-link 
                    class="w-auto"
                    txt="Contest" 
                    url="{{ route('user.contest.participate', ['contest' => $contest->id]) }}" />
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
