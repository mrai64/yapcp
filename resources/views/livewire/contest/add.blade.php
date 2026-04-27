<?php 
/**
 * Contest Main Card Add
 * Contest definition 
 * - name of contest
 * - calendar
 * etc
 */

use App\Models\ContestSection;

?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('CONTEST Definition Main Card') }}
        </h2>
        <!-- navigation --> 
        <h3>
            <a href="{{ route('organization.contest.modify', ['contest' => $contest ]) }}">
                <span class="fyk text-2xl">Main</span>
            </a>
            . .
            <a href="{{ route('organization.contest-section.add', ['contest' => $contest]) }}">
                <span class="fyk text-xl">Sections</span>
            </a>
            {{ $sid = ContestSection::firstContestSectionId( $contest->id ); }}
            @if($sid > '')
            <a href="{{ route('organization.contest-jury.add', ['sid' => $sid] ); }}">
                <span class="fyk text-xl">Jury</span>
            </a>
            @else
            <a href="#no-section-no-jury" text='{{ __("Before, add a section")}}' alt='{{ __("No link, almost a section before")}}'>
                <span class="fyk text-xl">Jury</span>
            </a>
            @endif
            . .
            <a href="{{ route('organization.contest-award.add', ['contest' => $contest]) }}">
                <span class="fyk text-xl">Awards</span>
            </a>
            . .
            <a href="{{ route('contest-participant.modify', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Participants</span>
            </a>
            . .
            <a href="{{ route('organization.contest.list', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Works</span>
            </a>
        </h3>
    </div>

    <hr />
    
    <p class="mb-4">{{ __('Note: Contest record is already created.') }}<br />
        {{ __('If you interrupt compiling form, you can retrieve - incomplete - in your Organization Dashboard.') }}
    </p>
    <p class="mb-4">
        {{ __('After that contest general definition, next step are: section list, jury definition, prize list definition.') }}
    </p>    
    <p class="mb-4"> 
        <a  href="{{ route('user.dashboard') }}" rel="noopener noreferrer">
        [ {{ __('Back to Personal Dashboard')}} ]
        </a>
        <a  href="{{ route('organization.dashboard', [ 'id' => $organization_id ]) }}" rel="noopener noreferrer">
        [ {{ __('Back to organization Dashboard')}} ]
        </a>
    </p>

    <hr />

    <form wire:submit="saveNewContest">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="contestNameEn">
                {{ __('Contest Name') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="contestNameEn" 
                value="{{ old('contestNameEn') }}"
                required="required" 
                />
            <div class="alert alert-danger small">@error('contestNameEn') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="contestNameLocal">
                {{ __('Contest Name lang') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="contestNameLocal" 
                value="{{ old('contestNameLocal') }}"
                required="required" 
                />
            <div class="alert alert-danger small">@error('contestNameLocal') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="countryId">
                {{ __('Country') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" 
                wire:model="countryId"
                name="countryId" 
                required="required"
                >
                <option value="">{{ __('-- choose country --') }}</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="alert alert-danger small">@error('countryId') {{ $message }} @enderror</div>
        </div>

        <!-- removed lang_code select -->

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" for="timezoneId">
                {{ __('Timezone') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="timezoneId"
                name="timezoneId" 
                required="required"
                >
                @foreach ($timezoneSet as $timezone_item)
                <option value="{{ $timezone_item }}" {{ ($timezone_item == $timezoneId) ? 'selected' : '' }}> {{ $timezone_item }} </option>
                @endforeach
            </select>
            <div class="small">{{ __('As worldwide platform we need to manage correctly time.') }} {{ __('List is in alphabetically order A>Z') }}</div>
            <div class="alert alert-danger small">@error('timezoneId') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contactInfo">
                {{ __('Chairman contact') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="contactInfo"
                wire:model="contactInfo"
            >{{ old('contactInfo') }}</textarea>
            <div class="alert alert-danger small">@error('contactInfo') {{ $message }} @enderror</div>
        </div>

        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700">
                {{ __("Is that a Circuit record or a Contest record?") }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="isCircuit" id="" value="Y" />
                {{ __("That's a CIRCUIT record, NOT of a Contest") }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="isCircuit" id="" value="N" checked />
                {{ __("That's a CONTEST, NOT a Circuit") }}
            </label>
            <div class="alert alert-danger small">@error('isCircuit') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <!-- TODO replace w/select -->
            <label class="block font-medium text-sm text-gray-700" for="circuitId">
                {{ __('Circuit Id') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="circuitId" 
                value="{{ old('circuitId') }}"
                />
            <div class="small">{{ __("Leave empty if previous field was 'no'. If it's a contest in circuit, insert circuit id previously registered") }}</div>
            <div class="alert alert-danger small">@error('circuitId') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="federationPatronageList">
                {{ __('Patronage / Sponsor Federation List') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="federationPatronageList" 
                value="{{ old('federationPatronageList') }}"
                />
            <div class="small">{{ __("Insert comma separate federation codes.") }}</div>
            @error('federationPatronageList')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url1Rule">
                {{ __('Official Contest Rule url (with subscription link)') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url1Rule" 
                type="text" name="url1Rule" 
                value="{{ old('url1Rule') }}"
                required="required"
                >
            <div class="alert alert-danger small">@error('url1Rule') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url2Concurrents">
                {{ __('Official Contest Participant List url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url2Concurrents" 
                type="text" name="url2Concurrents" 
                value="{{ old('url2Concurrents') }}"
                >
            <div class="alert alert-danger small">@error('url2Concurrents') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url3Results">
                {{ __('Official Contest Result List url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url3Results" 
                type="text" name="url3Results" 
                value="{{ old('url3Results') }}"
                required="required"
                >
            <div class="alert alert-danger small">@error('url3Results') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url4Catalogs">
                {{ __('Official Contest Catalogues url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url4Catalogs" 
                type="text" name="url4Catalogs" 
                value="{{ old('url4Catalogs') }}"
                >
            <div class="alert alert-danger small">@error('url4Catalogs') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="feePaymentInfo">
                {{ __('Participation Fee info') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="feePaymentInfo"
                wire:model="feePaymentInfo"
            >{{ old('feePaymentInfo') }}</textarea>
            <div class="small">{{ __('Only for info, and replied in Rules pdf. Even for free fee.') }}</div>
            <div class="alert alert-danger small">@error('feePaymentInfo') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day1ParticipationOpening">
                {{ __('Date (n time) opening Contest') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day1ParticipationOpening" 
                type="datetime-local" name="day1ParticipationOpening" 
                value="{{ old('day1ParticipationOpening', $contest->day_1_opening?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Date format must be a sortable iso datetime: yyyy-mm-dd hh:mm:ss') }}</div>
            <div class="alert alert-danger small">@error('day1ParticipationOpening') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day2ParticipationClosing">
                {{ __('End of participation Contest') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day2ParticipationClosing" 
                type="datetime-local" name="day2ParticipationClosing" 
                value="{{ old('day2ParticipationClosing', $contest->day_2_closing?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day2ParticipationClosing') {{ $message }} @enderror</div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day3JuryOpening">
                {{ __('Begin of jury works') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day3JuryOpening" 
                type="datetime-local" name="day3JuryOpening" 
                value="{{ old('day3JuryOpening', $contest->day_3_jury_opening?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day3JuryOpening') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day4JuryClosing">
                {{ __('End of jury works') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day4JuryClosing" 
                type="datetime-local" name="day4JuryClosing" 
                value="{{ old('day4JuryClosing', $contest->day4JuryClosing?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day4JuryClosing') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day5Revelations">
                {{ __('Result communication') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day5Revelations" 
                type="datetime-local" name="day5Revelations" 
                value="{{ old('day5Revelations', $contest->day_5_revelations?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day5Revelations') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day6Ceremony">
                {{ __("Award' Ceremony 1 Date") }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day6Ceremony" 
                type="datetime-local" name="day6Ceremony" 
                value="{{ old('day6Ceremony', $contest->day_6_awards?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day6Ceremony') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="awardCeremonyInfo">
                {{ __("Award' Ceremony 2 location info") }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="awardCeremonyInfo"
                wire:model="awardCeremonyInfo"
                required="required"
            >{{ old('awardCeremonyInfo') }}</textarea>
            <div class="small">Location, date and time and/or Broadcast platform </div>
            <div class="alert alert-danger small">@error('awardCeremonyInfo') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day7Catalog">
                {{ __('Catalogue publication, printed or online') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day7Catalog" 
                type="datetime-local" name="day7Catalog" 
                value="{{ old('day7Catalog', $contest->day_7_catalogues?->format('Y-m-d\TH:i')) }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day7Catalog') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_8_closing">
                {{ __('Deadline for award postal send to awarded') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day_8_closing" 
                type="datetime-local" name="day_8_closing" 
                value="{{ old('day_8_closing') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="alert alert-danger small">@error('day_8_closing') {{ $message }} @enderror</div>
        </div>

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Completed, NEXT') }}
        </button>

    </form>

    <p class="mb-4"> 
        <a  href="{{ route('organization.dashboard', [ 'id' => $organization_id ]) }}" 
            rel="noopener noreferrer">
        [ {{ __('Back to Organization Dashboard')}} ]
        </a>?
    </p>

</div>
