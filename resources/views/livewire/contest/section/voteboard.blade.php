<?php
/**
 * vote board - list for section
 * - sum ( vote )
 * - work_id 
 * - user_id 
 * 
 */
?>
<div>
    <!-- contest and section info -->
    <!-- livewire:contest.section.header :sid="$section_id" lazy /--> 

    <!-- paginated dias -->
    <p>Sum of votes</p>
    <hr>
    @foreach($sectionResult as $singleResult)
    <div class="mb-4 border rounded-md">
        vote: {{$singleResult->total_vote }} | {{ $singleResult->work_file }} 
    </div>
    <!-- livewire:contest.section.votedcard :sid="$section_id" lazy / -->
  @endforeach
</div>
