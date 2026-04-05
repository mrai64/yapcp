<?php
/**
 * admin only
 * 
 * @see /app/Livewire/Federation/Section/Listed.php
 * 
 */
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
                rel="noopener noreferrer">
                {{ __('Back to Federation list') }} 
            </a>
            ]
            <br />
            [ 
            <a href="{{ route('federation-section.add', ['federation' => $federation ]) }}" 
                rel="noopener noreferrer">
                {{ __('Add New Federation Section') }} 
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
        <table class="table table-primary table-striped w-full"        >
            <thead>
                <tr>
                    <th scope="col">{{__('Code')}}</th>
                    <th scope="col">{{__('Description')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @foreach ($section as $sec)
                <tr class="border my-2 py-2">
                    <td scope="row">{{$sec->code}}</td>
                    <td >{{$sec->name_en}}<br />{{$sec->rule_definition}}</td>
                    <td nowrap>
                        <!-- TODO change string w/objects -->
                        <a href="{{ route('federation-section.modify', ['federation-section' => $sec] )}}">[Mod]</a>
                        &nbsp;|&nbsp;
                        <!-- TODO change string w/objects -->
                        <a href="{{ route('federation-section.delete', ['federation-section' => $sec] )}}">[Rem]</a>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div><!-- section list table -->
</div>
