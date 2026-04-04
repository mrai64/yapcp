<?php

?>

<div>
    <header>
        <h1 class="fyk text-2xl">
            {{__("Coded Section for Federation")}}: 
            {{$federation->id}} |
            {{$federation->name_en}} 
        </h1>
        <p class="small">
            {{ __("Federation(s) wrote Contest Regulatory doc(s), that must be followed by sponsored Contest Organizations.")}}
            {{ __("Then, when your Organization choose to follow any Federation Auspices / Patronage / Sponsorship")}}
            {{ __("that lst help them to follow right way when build a contest blueprint.")}}
            <br />
            {{ __("When, for the competition, you choose the sponsorship of two federations,")}}
            {{ __("you will have to apply, for the overlapping rules, the more restrictive one.")}}
            <br />
            {{ __("When you see some difference say us for a fast alignment.")}} </small>
        </p>
        <hr />
        <p class="fyk text-xl mb-4">
            [ 
            <a href="{{ route('federation.list') }}" 
                target="_blank" rel="noopener noreferrer">
                {{ __('Back to Federation list') }} 
            </a>
            ]
        </p>
    </header>
    <p>&nbsp;</p>

@if (session('success'))
<div class="float-end font-medium rounded-md px-4 py-2">
    {{ session('success') }}
</div> 
<hr />
@endif

<div class="table-responsive">
    <table
        class="table table-primary table-striped"
    >
        <thead>
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($section as $sec)
            <tr class="border my-2 py-2">
                <td scope="row">{{$sec->code}}</td>
                <td>{{$sec->name_en}}</td>
                <td nowrap>
                    <!-- TODO change string w/objects -->
                    <a href="{{ route('federation-section.modify', ['fid' => $federation->id, 'sid' => $sec->code] )}}">[Mod]</a>
                    &nbsp;|&nbsp;
                    <!-- TODO change string w/objects -->
                    <a href="{{ route('federation-section.delete', [ 'sid' => $sec->id] )}}">[Rem]</a>
                </td>
            </tr>
            @endforeach
            <tr class="my-2 py-2">
                <td scope="row">&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <a href="{{ route('federation-section.add', ['federation' => $federation ]) }}">[Add New]</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>
