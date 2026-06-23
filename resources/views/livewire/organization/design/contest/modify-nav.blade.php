@props(['contest'])

<div>
    <x-header-link-app 
        txt="Name n Infos" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Calendar" 
        url="{{ route('organization.design.contest.modify2', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Web links" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Themes n Sections" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Juries" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Awards" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
</div>