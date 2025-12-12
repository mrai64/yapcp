<div>
    <div class="fyk text-2xl">{{ $contest->country->flag_code }} | {{$contest->name_en}}</div>
    <div class="small">Few contest info</div>
    <hr />
    <div class="p-4 border rounded-md">
        [ 
            <a href="{{route('contest-live-dashboard', ['cid' => $contest->id ])}}">
                {{__("Back to contest live panel")}} 
            </a>
        ]
    </div>
    <div class="p-4 border rounded-md">
        [ 
            <a href="{{route('public-participant-list', ['cid' => $contest->id ])}}">
                {{__("Participant list - w/fee payment status")}} 
            </a>
        ]
    </div>
    <div class="p-4 border rounded-md">
        {{ __("Pre Jury window")}}
        <hr />
        [ 
            <a href="{{route('organization-contest-list', ['cid' => $contest->id ])}}">
                {{__("Works Validation - Section List")}} 
            </a>
        ]
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        @foreach( $section_set as $section_item)
        <div>
            <a href="{{ route('organization-contest-section-list', ['sid' => $section_item->id])}}">
                [ {{ __("Section Works Preview") }} ]
            </a>
            &gt; 
            <span class="fyk">{{$section_item->code}} | {{$section_item->name_en }}</span>
        </div>
        @endforeach
    </div>
    <div class="p-4 border rounded-md">
        Jury window
        <hr />
        during jury individual work
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        @foreach( $section_set as $section_item)
        <div>
            <a href="{{ route('contest-before-final-jury', ['sid' => $section_item->id ]) }}">
                [ {{ __("Sum Votes Board + Ask Vote Change") }} ]
            </a>
            &gt;
            <span class="fyk">{{$section_item->code}} | {{$section_item->name_en }}</span>
        </div>
        @endforeach
    </div>
    <div class="p-4 border rounded-md">
        {{__("Jury Final meet - admission")}}
        <hr />
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        @foreach( $section_set as $section_item)
        <div>
            <a href="{{ route('organization-contest-admit', ['sid' => $section_item->id ]) }}">
                [ {{ __("Admission based on Sum Votes") }} ]
            </a>
            &gt;
            <span class="fyk">{{$section_item->code}} | {{$section_item->name_en }}</span>
        </div>
        @endforeach
    </div>
    <div class="p-4 border rounded-md">
        {{__("Jury Final meet - Awards assignment")}}
        <hr />
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        @foreach( $section_set as $section_item)
        <div>
            <a href="{{ route('organization-award-section-assign', ['sid' => $section_item->id ]) }}">
                [ {{ __("Section Awards assignment") }} ]
            </a>
            &gt;
            <span class="fyk">{{$section_item->code}} | {{$section_item->name_en }}</span>
        </div>
        @endforeach
    </div>
    <div class="p-4 border rounded-md">
        {{__("Jury Final meet - Contest Awards")}}
        <hr />
        <div>
            <a href="{{ route('organization-award-contest-assign', ['cid' => $contest->id ]) }}">
                [ {{ __("Contest Awards assignment") }} ]
            </a>
        </div>
    </div>
    <div class="p-4 border rounded-md">
        {{__("Jury Final meet - Contest Minute")}}
        <hr />
        [ Jury send n receive ]
    </div>
    <div class="p-4 border rounded-md">
        {{__("After Jury works - List for Report Catalogue etc")}}
        <hr />
        [ Contest list participant / admit ] <br />
        [ contest list award list ]
    </div>
    <div class="p-4 border rounded-md">
        {{ __("Send Results to participants") }}
    </div>
    <div class="p-4 border rounded-md">
        {{ __("Publish web result") }}
    </div>

</div>
