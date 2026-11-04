@component('mail::message')
{{ __("Good { morning, afternoon, evening } ") }} {{ $userContact->first_name }},
{{ __("we're delighted that you took part in our photo contest,") }}
{{ $contest->name_en }}
{{ __("and here are the results of your entry") }}

@if ($contestWorks->isEmpty())
  {{ __("No works found") }}

@else
  @component('mail::table')
  | Section | {{ __("Work Title") }} | {{ __("Result") }} |
  | :---    | :---                   | :---:              |
  @foreach ($contestWorks as $contestWork)
  | {{$contestWork->contestSection->code}} {{$contestWork->contestSection->name_en}} | {{ $contestWork->userWork->title_en }} | {{ $contestWork->is_admit ? __('ADMIT') : __('not admit') }} |
  @endforeach
@endcomponent

@endif

{{__("We know how important it is to receive recognition from a judging panel, ")}}
{{__("and that it acts as an incentive to do better; but even if the result ")}}
{{__("doesn’t quite live up to your expectations, it’s still ‘just’ a result, ")}}
{{__("and we encourage you to carry on and keep improving. ")}}
{{__("Even the best have room for improvement!")}}

{{ __("We invite you to participate at our award ceremony, here the infos: ")}}
{{ $contest->award_ceremony_info }}

{{ __("Please contact us to confirm your participation.") }}

Warm regards,<br />
The Organising Committee of {{ $contest->name_en }}

@endcomponent