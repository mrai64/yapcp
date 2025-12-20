<div>
    <!-- Contest Header -->
    <div class="h2 fyk text-2xl">
        {{ __("Contest Works participant Board") }}
    </div>
    <livewire:organization.award.section-nav :cid="$contest_id" lazy />

    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    @foreach($sections as $section)
    <!-- Section Header -->
    <div class="h3 fyk text-2xl"><br />{{$section->name_en}}</div>

    <!-- tabled works list -->
    <table class="data-table-container w-auto my-4 border">
        <thead>
            <th>Country</th>
            <th>Participant Name</th>
            <th>Portfolio Seq.</th>
            <th>Work Title</th>
            <th>Admitted</th>
            <th>Award Assigned</th>
        </thead>
        <tbody>
        @foreach($section_works[$section->id] as $work)
            <tr class="{{ $loop->even ? 'row-even' : 'row-odd' }}"">
                <td nowrap>
                    {{$work->flag_code}} {{$work->country_id}}
                </td>
                <td nowrap>
                    {{$work->last_name}}, {{$work->first_name}}
                </td>
                <td>
                    {{$work->portfolio_sequence}}
                </td>
                <td>
                    {{$work->title_en}}
                </td>
                @if ($work->is_admit)
                <td style="background-color:lightgreen;color:black;font-weight:bold;">
                    Yes
                </td>
                @else
                <td>
                    No
                </td>
                @endif
                <td>
                    {{$work->award_assigned}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- /tabled works list -->
    <!-- /Section Header -->
    @endforeach 
    <div class="h2 fyk text-2xl">
        {{ __("That's all, guys!") }}
    </div>

</div>
