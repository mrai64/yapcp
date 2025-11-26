<?php
/**
 * Board of vote sorted by [sum(vote) desc] with rank
 * Single section list:
 * - sum ( vote ) desc
 * - work_id 
 * - user_id 
 * 
 * 2025-11-25 pagination
 * 
 */


?>
<div>
    <!-- contest and section info -->
    <!-- livewire:contest.section.header :sid="$section_id" lazy /--> 

    <h2 class="fyk text-2xl">Sum of votes</h2>

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
