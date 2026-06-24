@props(['contest'])

<div>
    <x-header-link-app 
        txt="Name, calendar, url" 
        url="#" />
    <x-header-link-app 
        txt="Name n Infos" 
        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Calendar" 
        url="{{ route('organization.design.contest.modify-calendar', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Web links" 
        url="{{ route('organization.design.contest.modify-url', ['contest' => $contest]) }}" />
</div>