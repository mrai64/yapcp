@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Name, calendar, url" 
        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Section n themes" 
        url="{{ route('organization.design.contest-section.listed', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Juries" 
        url="{{ route('organization.design.contest-jury.listed', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Awards" 
        url="{{ route('organization.design.contest-award.listed', ['contest' => $contest]) }}" />
</div>