<?php
/**
 * 
 */
use \App\Livewire\Organization\Award\ContestAssignedDia;

?>

<div>
    @foreach ($sectionAwarded as $awarded)
    <div style="float:left;width:300px !important;margin-top:.5rem;margin-right:.5rem;">
        <div style="width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);margin-top:.5rem;margin-right:.5rem;">
            <img src="{{ asset('storage/photos') .'/'. self::miniature($awarded->work_file) }}"
            _loading="lazy"
            style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;"
            />
        </div>
        <br style="clear:both;" />
        <div class="small text-center">
            {{ $awarded->award_code }}<br>
            {{ $awarded->award_name }}
            <hr />
            {{ $awarded->flag_code }}
            {{ $awarded->country_id }}<br>
            {{ $awarded->last_name }}
            {{ $awarded->first_name }}
            <hr />
            {{ $awarded->title_en }} / 
            {{ $awarded->reference_year }}
        </div>
    </div>
    <br style="clear:both;" />
    <br style="clear:both;" />
    @endforeach
</div>
