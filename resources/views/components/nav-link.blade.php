@props(['active' => 'false'])

@php
$clasess = ($active ?? false)
            ? 'nav-link active'
            : 'nav-link';
@endphp

<li class="nav-item">
    <a wire:navigate {{ $attributes->merge(['class' => $clasess]) }}>{{ $slot }}</a>
</li>