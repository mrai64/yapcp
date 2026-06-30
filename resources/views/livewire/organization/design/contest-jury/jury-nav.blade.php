@props(['contest'])

<div>
    <x-yapcp.header-link 
        txt="Listed" 
        url="{{ route('organization.design.contest-jury.listed', ['contest' => $contest]) }}" />
</div>