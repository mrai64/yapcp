<?php

use App\Livewire\Contest\Jury\Voteddias;

?>

<div style="float:left;width:300px;height:calc(300px + 2rem);display:block;text-center;background-color:#f0f0f0;margin-top:.5rem;margin-right:.5rem;">
    <p style="float:left;" class="fyk text-xl z-50">{{ __("Assigned vote: ") }}<span class="text-black font-semibold">{{ $contest_work->vote }}</span></p>
    <span class="inline-flex justify-end"><a href="{{ route('contest-jury-vote-mod', ['vid' => $contest_work->id ]) }}" >[ + / - ]</a></span>
    <div style="width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        <img src="{{ asset('storage/contests') .'/'. $contest_work->contest_id .'/'. $contest_work->section_id .'/300px_'. $contest_work->work_id .'.'. $contest_work->work->extension  }}" 
        _loading="lazy"
        style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;" 
        />
    </div>
</div>
