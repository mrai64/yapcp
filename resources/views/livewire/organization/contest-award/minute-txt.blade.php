MINUTE DRAFT FOR CONTEST
Contest: {{ $contest->name_en }}  
Date: {{ now()->format('j F Y') }}  
Organized by: {{ $organization->name }}  

---

JURY MEMBERS

@foreach ($sectionJuries as $section)
#Section-Theme: {{ $section->code }} {{ $section->name_en }}
@foreach ($section->contestJuries as $jury)
* {{ ($jury->is_president) ? '[PRESIDENT]' : '[JUROR]' }} {{ $jury->userContact->country->flag_code }} {{ $jury->userContact->last_name }}, {{ $jury->userContact->first_name }}
@endforeach

@endforeach

---

SUBMITTED WORKS SUMMARY

@foreach ($sectionStats as $section)
* Section {{ $section->code }} ({{ $section->name_en }}): {{ $section->total_works_count }} works by {{ $section->total_authors_count }} authors from {{ $section->total_countries_count }} countries.
@endforeach

---

ADMITTED WORKS SUMMARY

@foreach ($sectionStats as $section)
* Section {{ $section->code }} ({{ $section->name_en }}): {{ $section->admitted_works_count }} works by {{ $section->admitted_authors_count }} authors from {{ $section->admitted_countries_count }} countries.
@endforeach

---

SECTIONs AWARDS

@foreach ($sectionAwards as $section)
#Section: {{ $section->code }} {{ $section->name_en }}
@foreach ($section->awards as $award)
* {{ $award->award_code }} - {{ $award->award_name }}
@if ($award->winner_work_id)
  * Work: *{{ $award->contestWork->userWork->title_en }}*
  * Author: {{ $award->contestWork->author->last_name }}, {{ $award->contestWork->author->first_name }} ({{ $award->contestWork->author->country->id }})
@endif
@if ($award->winner_user_id)
  * Author: {{ $award->userContact->last_name }}, {{ $award->userContact->first_name }} ({{ $award->userContact->country->id }})
@endif
@if ($award->winner_name)
  * Winner: {{ $award->winner_name }}
@endif
@if ($award->citation)
  * *Citation:* {{ $award->citation }}
@endif

@endforeach
@endforeach

Global Contest Awards

@foreach ($contestAwards as $award)
* {{ $award->award_code }} - {{ $award->award_name }}
@if ($award->winner_work_id)
  * Work: *{{ $award->contestWork->userWork->title_en }}*
  * Author: {{ $award->contestWork->author->last_name }}, {{ $award->contestWork->author->first_name }}
@endif
@if ($award->winner_user_id)
  * Author: {{ $award->userContact->last_name }}, {{ $award->userContact->first_name }}
@endif
@if ($award->winner_name)
  * Winner: {{ $award->winner_name }}
@endif
@endforeach

---

SIGNATURES

Signed, read, approved.



____________________________________________
^ City n Date



____________________________________________
^ President of Organization / Contest Manager

@foreach ($sortedJurors as $juror)


____________________________________________
^ Juror {{ $juror->userContact->last_name }}, {{ $juror->userContact->first_name }}

@endforeach
