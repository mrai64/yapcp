<!-- contest live header -->
<div class="header my-4">
    <h2 class="fyk text-2xl font-medium text-gray-900">
        {{ __("Contest") }}
        : {{$contest->country->flag_code}}
        | {{$contest->name_en}}
    </h2>
    <!-- sections -->
    <div class="my-4">
        <h3 class="fyk text-2xl">
            {{ __("Contest Sections")}}
        </h3>
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
    <br />
    <p class="fyk text-xl font-medium mb-4">
        <a href="{{route('contest.dashboard', ['contest' => $contest ])}}">
            [ {{ __("Back to Contest dashboard") }} ]
        </a>
        . .
        <a href="{{route('organization.dashboard', ['organization' => $contest->organization_id ])}}">
            [ {{ __("Back to Organization dashboard") }} ]
        </a>
    </p>
</div>
