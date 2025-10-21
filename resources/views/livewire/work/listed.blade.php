<div>
    <div class="mb-4 fyk" style="font-size:3rem">
        {{ ($country['flag_code']) ? $country['flag_code'] : '🏳️‍🌈' }}
        {{ $user_contact['first_name']}} {{ $user_contact['last_name']}}
        <br />
    </div>
    <p>{{ __('Works are sorted by english title.') }} </small></p>
    <hr class="my-4" />
    <div class="mb-4 fyk text-xl">
        <a  href="{{ route('photo-box-add') }}"
            class="float-end font-medium rounded-md mb-4 py-2"
            >
            [ {{ __('Add new selected works') }} ]
        </a>
    </div>

    <hr class="my-4" />
    <div>
        @if ( !isset($work_list) || count($work_list) === 0)
        <p style="font-size:2rem">
            <a href="#">{{ __('Zero found, wanna add your works?') }}</a>
        </p>
        @else
        <div class="mb-4 fyk text-xl">
            <a  href="{{ route('contest-list') }}"
                class="float-end font-medium rounded-md mb-4 py-2"
                >
                [ {{ __('Open Contest List') }} ]
            </a>
        </div>
        <hr class="my-4" />
        <table class="data-table-container">
            <thead>
                <tr>
                    <th scope="col" class="data-table-thumbs">{{__('Thumbs')}}</td>
                    <th scope="col" class="data-table-titles">{{__('Titles n info')}}</td>
                    <th scope="col" class="data-table-actions">{{ __('Actions') }}</td>
                </tr>
            </thead>
            <tbody>
            @foreach ($work_list as $work)
                <tr class="border">
                    <td class="px-4" scope="row" style="background-color: #808080">
                        <a href="{{ route( 'photo-box-modify', [ 'wid' => $work[ 'id' ] ] ) }}">
                        <br style="clear: both;" />
                        <img src="{{ asset('storage/photos') . '/' . $work['work_file'] }}"
                            style="max-width:300px !important;max-height:300px !important;"
                            loading="lazy" />
                        <br style="clear: both;" />
                        </a>
                    </td>
                    <td class="px-4" >
                        <a href="{{ route( 'photo-box-modify', [ 'wid' => $work[ 'id' ] ] ) }}">
                        <p>
                            English title : [{{$work['title_en']}}]<br/>
                            Local title: [{{$work['title_local']}}]<br />
                            Ref.Year: [{{$work['reference_year']}}] | Long size: [{{$work['long_side']}}] | Short size: [{{$work['short_side']}}] <br />
                        </p>
                        </a>
                    </td>
                    <td nowrap  class="fyk text-xl" >
                        <a href="{{ route( 'photo-box-modify', [ 'wid' => $work[ 'id' ] ] ) }}">[Mod]</a>
                        &nbsp;|&nbsp;
                        <a href="{{ route( 'delete-photo-box', [ 'wid' => $work[ 'id' ] ] ) }}">[Rem]</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4 fyk text-xl">
            <a href="{{ route('photo-box-add') }}">{{ __('Not enough? Add other works!') }}</a>
        </div>
        @endif
    </div>

</div>
