<?php

/**
 * User Jury Contest, limited to "under jury" window
 * for use in User Dashboard
 *
 * no full page
 * @livewire('user.contest.juror', ['userId' => (string) $user->id])
 *
 */

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\User;
use App\Models\UserRole;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Livewire\Volt\Component;

new class extends Component {
    //
    public string $userId;
    public User $user;
    public $contests;
    // first
    public function mount(string $userId) // from @livewire
    {
        // first can you ?
        // $this->authorize();
        $this->userId    = (Str::isUuid($userId)) ? $userId : '';
        $this->user      = User::findOrFail($this->userId);
        // what time is it?
        $now = CarbonImmutable::now($this->user->userContact->timezone);
        $this->contests = Contest::query()
            ->with(['country', 'organization'])
            ->whereHas('userRoles', function ($query) {
                $query->where('user_id', $this->userId)
                    ->where('role', UserRole::JUROR);
            })
            ->where('day_3_jury_opening', '<=', $now)
            ->where('day_4_jury_closing', '>', $now)
            ->get();
    }
}; ?>

<div>
    @if ($contests->isEmpty())
    <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
        {{ __("You are not a juror, or the application window for your jury is not yet / no longer open.") }}
    </div>
    @else
    <div class="fyk border text-2xl rounded-md px-4 pt-6 text-center text-gray-500">
        {{ __("You are at now Juror in") }}
    </div>
    <table class="w-full text-sm text-left text-gray-500">
        <tbody>
        @foreach ($contests as $contest)
        <tr class="border">
            <td valign="top" class="w-1/8">
                <x-yapcp.inline-link
                    class="w-auto"
                    txt="Jury work" 
                    url="#" />
            </td>
            <td valign="top" class="fyk text-2xl">
                {{ $contest->country->flag_code}}
                {{ $contest->country->country}}
                <br />
                {{ $contest->name_en}}
                <br />
                {{ $contest->organization->name }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
