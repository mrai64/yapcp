<div>
    <a  href="#" 
        class="float-end font-medium rounded-md mb-4 py-2"
        >
        [ {{ __('Add new selected works') }} ]
    </a>

    <hr class="my-4" />

    <div class="mb-4 fyk" style="font-size:3rem">
        {{ ($country['flag_code']) ? $country['flag_code'] : '🏳️‍🌈' }} 
        {{ $user_contact['first_name']}} {{ $user_contact['last_name']}} [nick_name]
        <br />
    </div>
    <p class="text-xs">Your assigned id: {{ $user_contact['user_id'] }}</small></p>

    <hr class="my-4" />
    <div>
        @if ( !isset($work_list) || count($work_list) === 0)
        <p style="font-size:2rem">
            <a href="#">{{ __('Zero found, wanna add your works?') }}</a>
        </p>
        @else
        <table class="data-table-container">
            <thead>
                <tr>
                    <th scope="col" class="data-table-thumbs">{{__('Thumbs')}}</td>
                    <th scope="col" class="data-table-titles">{{__('Titles n info')}}</td>
                    <th scope="col" class="data-table-actions">{{ __('Actions') }}</td>
                </tr>
            </thead>
            <tbody>
            <?php $odd = true; ?>
            @foreach ($work_list as $work)
                <tr >
                    <td class="px-4" scope="row" style="background-color: {{ $odd ? '#f0f0f0' : '#ccffff' }}" >
                        <img src="{{ asset('storage/photos') . '/' . $work['work_file'] }}" 
                            style="max-width:300px !important;max-height:300px !important;" 
                            loading="lazy" />
                            <br style="clear: both;" />
                            <span class="text-xs">img assigned id: [{{$work['id']}}]</span>
                    </td>
                    <td class="px-4" style="background-color: {{ $odd ? '#f0f0f0' : '#ccffff' }}" >
                        <p>year: [{{$work['reference_year']}}] | long size: [{{$work['long_side']}}] | short size: [{{$work['short_side']}}] <br /> title: [{{$work['title_en']}}]<br/> local title: [{{$work['title_loca']}}] </p>
                    </td>
                    <td nowrap  style="background-color: {{ $odd ? '#f0f0f0' : '#ccffff' }}">
                        <a href="#">[Mod]</a>
                        &nbsp;|&nbsp;
                        <a href="#">[Rem]</a>
                    </td>
                </tr>
                {{ $odd = !($odd) }}
            @endforeach
            </tbody>
        </table>
        <a href="#">{{ __('Not enought? Add other works!') }}</a>
        @endif
    </div>

</div>
