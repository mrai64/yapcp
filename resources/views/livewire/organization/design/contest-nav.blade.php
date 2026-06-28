@props(['contest'])

<div>
    <x-header-link-app 
        txt="Name, calendar, url" 
        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Section n themes" 
        url="{{ route('organization.design.contest-section.listed', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Juries" 
        url="{{ route('organization.design.contest-jury.listed', ['contest' => $contest]) }}" />
    <x-header-link-app 
        txt="Awards" 
        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
</div>