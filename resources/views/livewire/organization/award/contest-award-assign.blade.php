<div>
    <form wire:submit="assignContestAward">
        @csrf

        <input name="contestId" 
            type="hidden"
            wire:model="contestId" 
            value="{{$contestId}}" readonly />
        <input name="awardCode" 
            type="hidden"
            wire:model="awardCode" 
            value="{{$awardCode}}" readonly />

        <select 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            wire:model.live="winnerUserId"
            name="winnerUserId" 
            >
            <option value="">-- choice participant from list OR type in next field</option>
            @foreach ($awardedPeoples as $winner)
            <option value="{{$winner->user_id}}"><code> {{ $winner->flag_code }} {{ $winner->country_id }} {{ $winner->last_name }}, {{ $winner->first_name }} </code></option>
            @endforeach
        </select>
        <div class="small">{{ __("Assign Jury Choice OR type name in next field.") }}</div>
        <br />

        <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            type="text" 
            wire:model="winnerName" 
            name="winnerName" 
            />
        <div class="small">{{ __("Leave empty if previous field was used.") }}</div>

        @foreach ($errors->all() as $message)
        <div class="alert alert-danger small">{{$message}}</div>
        @endforeach

        <x-secondary-button type="submit">
            {{ __("🏆 ASSIGN 🏆") }}
        </x-secondary-button>
    </form>
</div>
