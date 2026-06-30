@props(['user_contact'])

@php
    $userContact = $user_contact;
@endphp

<div>
    <x-yapcp.header-link 
        txt="Your name n Country / 1" 
        url="{{ route('user.contact.modify1', ['user_contact' => $userContact]) }}" />
    <x-yapcp.header-link 
        txt="Postal address / 2" 
        url="{{ route('user.contact.modify2', ['user_contact' => $userContact]) }}" />
    <x-yapcp.header-link 
        txt="Cellular / 3" 
        url="{{ route('user.contact.modify3', ['user_contact' => $userContact]) }}" />
    <x-yapcp.header-link 
        txt="Web n Socials / 4" 
        url="{{ route('user.contact.modify4', ['user_contact' => $userContact]) }}" />
    <x-yapcp.header-link 
        txt="Federations related / 5" 
        url="{{ route('user.contact.modify5', ['user_contact' => $userContact]) }}" />
</div>
