@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Award List" 
        url="{{ route('organization.design.contest-award.listed', ['contest' => $contest]) }}" />
    <x-yapcp.header-link 
        txt="Add Award" 
        url="{{ route('organization.design.contest-award.add', ['contest' => $contest]) }}" />
</div>
