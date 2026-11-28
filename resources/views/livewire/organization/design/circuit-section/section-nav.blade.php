@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Listed" 
        url="{{ route('organization.design.circuit-section.listed', ['contest' => $contest]) }}" />
</div>