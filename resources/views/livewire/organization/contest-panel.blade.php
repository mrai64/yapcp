<div>
    {{-- The whole world belongs to you. --}}
    <div class="fyk text-2xl">{{ $contest->country->flag_code }} | {{$contest->name_en}}</div>
    <div class="small">Few contest info</div>
    <hr />
    <div class="p-4 border rounded-md">
        [ 
            <a href="{{route('public-participant-list', ['cid' => $contest->id ])}}">
                {{__("Participant list - complete fee payment")}} 
            </a>
        ]
    </div>
    <div>
        [ work pre-jury review ]
    </div>
    <div>
        pre - jury
        <hr />
        during jury individual work
    </div>
    <div>
        [ juror votes board monitoring ]
    </div>
    <div>
        [ ask vote review for a limited set of...]
    </div>
    <div>
        during jury individual work
        <hr />
        last jury meet
    </div>
    <div>
        [loop section link]
        [ Admission to a set of works ]
        [ Award assignment ]
        [/loop section link]
    </div>
    <div>
        [ Contest award assignment ]
    </div>
    <div>
        [ Jury send n receive ]
    </div>
    <div>
        [ Contest list participant / admit ] <br />
        [ contest list award list ]
    </div>

</div>
