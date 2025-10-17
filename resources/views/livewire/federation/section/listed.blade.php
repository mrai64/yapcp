<?php

?>

<div>
    <header>
        <h1 class="fyk text-2xl">
            {{__("Coded Section for Federation:")}} 
            {{$federation->id}} |
            {{$federation->name_en}} 
        </h1>
    </header>
<p class="small">{{ __("That's the coded list picked from Regulatory doc found in Federation official site.")}}
    <br />
    {{ __("When you see some difference say us for a fast alignment.")}} </small>
<p>&nbsp;</p>

@if (session('success'))
<div class="float-end font-medium rounded-md px-4 py-2">
    {{ session('success') }}
</div> 
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
                    <a href="{{ route('federation-section-modify', ['fid' => $federation->id, 'sid' => $sec->code] )}}">[Mod]</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('delete-federation-section', [ 'sid' => $sec->id] )}}">[Rem]</a>
                </td>
            </tr>
            @endforeach
            <tr class="my-2 py-2">
                <td scope="row">&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <a href="{{ route('add-federation-section', ['fid' => $federation->id ]) }}">[Add New]</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>
