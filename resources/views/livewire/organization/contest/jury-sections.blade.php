<?php
/**
 * State f the Art for contest section
 * - infos of contest
 * - infos of section
 * - for every juror how many voted
 * - sum of votes (no compensations)
 *
 * Page used by the competition organization to review
 * the jury's scoreboard, and to request a review of the
 * score on a limited group of works to reduce the number
 * and percentage of admitted works. When required.
 * 
 * 2025-11-25 pagination
 * 
 */


?>
<div>
    <!-- contest and section info -->
    <livewire:contest.section.header :sid="$section_id" lazy /> 

    <h2 class="fyk text-2xl"><strong> {{__("Contest pre-jury IN / OUT for: ")}} {{$section->code}} {{ $section->name_en }}</strong></h2>
    <div class="header mb-4">
        {{ __("As member of organization, in that page you check in human way")}}
        {{ __("if these works can be pass to Jury work. ")}}<br />
        {{ __("Or advice author that her/him work have a little trouble.")}}<br >
        {{ __("For every img choice Ok/IN or KO/WARN.)")}}
    </div>

    <!-- sectionResult nav page -->
    <div class="paginationDiv">
      {{ $sectionResult->links() }}
    </div>

    <!-- paginated dias -->
    <hr>
    @foreach($sectionResult as $singleResult)
    <!-- dias card -->
    <div class="mb-4 border rounded-md">
      temporary rank : {{$singleResult->rank_by_votes }} |
      from top % : {{ (floor($singleResult->admission_percent))/100 }} |
      vote: {{$singleResult->voted_sum }} | 
      {{ $singleResult->work_id }} |
      ask review 
      <input type="checkbox" name="askreview" id="" />
    </div>
    <!-- livewire:contest.section.votedcard :sid="$section_id" lazy / -->
    @endforeach

    <!-- sectionResult nav page -->
    <div class="paginationDiv">
      {{ $sectionResult->links() }}
    </div>


  </div>
