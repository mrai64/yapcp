@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Name, calendar, url" 
        url="#" />
    <x-yapcp.header-link 
        txt="Name n Infos" 
        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Calendar" 
        url="{{ route('organization.design.contest.modify-calendar', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Web links" 
        url="{{ route('organization.design.contest.modify-url', ['contest' => $contest]) }}" />
</div>