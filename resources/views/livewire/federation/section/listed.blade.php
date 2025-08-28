<div>
<h1 class="fyk text-xl">Coded Section for Federation 
    {{$federation->name}} |
    {{$federation->id}}
</h1>
<psmall>That's the coded list picked from Regulatory doc found in Federation official site.
    When you see some difference say us for a fast alignment. </small>
<p>&nbsp;</p>
<div
    class="table-responsive"
>
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
                <td>{{$sec->name}}</td>
                <td nowrap>
                    <a href="/federation/section/modify/{{$sec->id}}">[Mod]</a>
                    &nbsp;|&nbsp;
                    <a href="/federation/section/modify/{{$sec->id}}">[Rem]</a>
                </td>
            </tr>
            @endforeach
            <tr class="">
                <td scope="row">&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <a href="#">[Add New]</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>
