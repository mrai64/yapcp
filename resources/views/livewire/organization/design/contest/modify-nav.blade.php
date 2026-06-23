@props(['contest'])

<div>
    <x-header-link-app 
        txt="Name n Infos / 1" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Calendar / 2" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Themes n Sections / 3" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Juries / 4" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Awards / 5" 
        url="{{ route('organization.design.contest.modify1', ['contest' => $contest]) }}" />
</div>