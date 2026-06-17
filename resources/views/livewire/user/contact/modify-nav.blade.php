@props(['user_contact'])

@php
    $userContact = $user_contact;
@endphp

<div>
    <x-header-link-app 
        txt="Your name n Country / 1" 
        url="{{ route('user.contact.modify1', ['user_contact' => $userContact]) }}" />
    <x-header-link-app 
        txt="Postal address / 2" 
        url="{{ route('user.contact.modify2', ['user_contact' => $userContact]) }}" />
    <x-header-link-app 
        txt="Cellular / 3" 
        url="{{ route('user.contact.modify3', ['user_contact' => $userContact]) }}" />
    <x-header-link-app 
        txt="Web n Socials / 4" 
        url="{{ route('user.contact.modify4', ['user_contact' => $userContact]) }}" />
    <x-header-link-app 
        txt="Federations related / 5" 
        url="{{ route('user.contact.modify5', ['user_contact' => $userContact]) }}" />
</div>
