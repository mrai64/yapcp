@props(['txt', 'url'])

@php
$classes = 'mb-4 fyk text-xl w-48 text-center inline-flex';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <a href="{{ $url }}">
        [ {{ __($txt) }} ]
    </a>
</div>
. .
