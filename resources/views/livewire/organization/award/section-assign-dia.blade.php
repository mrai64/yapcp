<div style="float:left;width:300px !important;margin-top:.5rem;margin-right:.5rem;">
    <div style="width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);margin-top:.5rem;margin-right:.5rem;">
        <img src="{{ asset('storage/contests') .'/'. $wid }}"
        _loading="lazy"
        style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;"
        />
    </div>
    <br style="clear:both;" />
    @foreach($unassigned_award_codes as $k => $awardCode)
        <button wire:click.prevent="assign_award('{{$awardCode->award_code}}')"
            class='inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'>
        {{$awardCode->award_code}}
        </button>
    @endforeach
    <hr />
    <hr />
</div>
