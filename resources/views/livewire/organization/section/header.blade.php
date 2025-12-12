<!-- contest live header -->
<div class="header my-4">
    <h2 class="fyk text-2xl">
        Contest: 
        {{$contest->country->flag_code}}
        |
        {{$contest->name_en}}
    </h2>
    <!-- sections -->
    <div class="my-4">
        <table class="data-table-container w-full fyk">
            <tbody>
                <tr>
                    @foreach($counters_set as $section_counter)
                    <td>
                        {{$section_counter->code}}
                        | 
                        {{$section_counter->name_en}}
                        <br />
                        <span title="participants #">📽️: {{$section_counter->participants}}</span>
                        <span title="available awards #">🏆: {{$section_counter->prizes}}</span>
                        <span title="assigned awards #">👍🏻: {{$section_counter->assigned}}</span>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <hr />
    [ 
        <a href="{{ route('organization-dashboard', ['id' => $contest->organization_id ]) }}"> {{__("Organization dashboard")}} </a> 
    ] [ 
        <a href="{{ route('dashboard') }}"> {{  __("Personal dashboard")}} </a> 
    ]
    <br style="clear:both;" />
    <br style="clear:both;" />
</div>
