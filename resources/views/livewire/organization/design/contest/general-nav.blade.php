@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Name n Infos" 
        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Calendar" 
        url="{{ route('organization.design.contest.modify-calendar', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Web links" 
        url="{{ route('organization.design.contest.modify-url', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="LAST: Contest details" 
        url="{{ route('organization.design.contest.detail', ['contest' => $contest]) }}" />
</div>