<div>
    <form wire:submit="assign_contest_award">
        @csrf

        <input name="contest_id" 
            type="hidden"
            wire:model="contest_id" 
            value="{{$contest_id}}" readonly />
        <input name="award_code" 
            type="hidden"
            wire:model="award_code" 
            value="{{$award_code}}" readonly />

        <select 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            wire:model.live="winner_user_id"
            name="winner_user_id" 
            >
            <option value="">-- choice participant from list OR type in next field</option>
            @foreach ($awarded_peoples as $winner)
            <option value="{{$winner->user_id}}"><code> {{ $winner->flag_code }} {{ $winner->country_id }} {{ $winner->last_name }}, {{ $winner->first_name }} </code></option>
            @endforeach
        </select>
        <div class="small">{{ __("Assign Jury Choice OR type name in next field.") }}</div>
        <br />

        <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            type="text" 
            wire:model="winner_name" 
            name="winner_name" 
            />
        <div class="small">{{ __("Leave empty if previous field was used.") }}</div>

        @foreach ($errors->all() as $message)
        <div class="small">{{$message}}</div>
        @endforeach

        <x-secondary-button type="submit">
            {{ __("🏆 ASSIGN 🏆") }}
        </x-secondary-button>
    </form>
</div>
