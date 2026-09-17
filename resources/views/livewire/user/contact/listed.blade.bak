<?php

/**
 * The entire list of platform registered users
 * only for admin 
 * 
 */
?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("yaPCP user directory")}}
        </h2>
        <hr />
        <br />
    </header>
    <div>
        <table class="data-table-container w-auto">
            <thead>
                <tr>
                    <th scope="col" class="data-table-section-country">{{ __("Country")}}</td>
                    <th scope="col" class="data-table-section-name">{{__("Surname, Name")}}</td>
                    <th scope="col" class="data-table-section-actions">{{__("Action")}}</td>
                </tr>
            </thead>
            <tbody>
                @foreach($userContactSet as $uc)
                <tr>
                    <td class="small">{{ $uc->country->flag_code }} {{ $uc->country->country }}&nbsp;&nbsp;</td>
                    <td class="small">{{ $uc->last_name }}, {{ $uc->first_name }}</td>
                    <td class="small">
                        <p class="fyk">
                            <a  href="{{ route('user-contact.show', ['userContact' => $uc]) }}"
                                rel="noopener noreferrer">
                            [ {{ __('Show') }} ]
                            </a>
                        </p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="paginationDiv">
        {{ $userContactSet->links() }}
        </div>

    </div>

</div>
