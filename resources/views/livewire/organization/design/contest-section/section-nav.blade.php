@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Listed" 
        url="{{ route('organization.design.contest-section.listed', ['contest' => $contest]) }}" />
</div>