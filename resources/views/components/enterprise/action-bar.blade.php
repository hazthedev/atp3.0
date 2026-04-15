@props([
    'justify' => 'start',
])

@php
    $justifyClass = match ($justify) {
        'end' => 'justify-end',
        'between' => 'justify-between',
        default => '',
    };
@endphp

<div {{ $attributes->class(['mt-5 flex flex-wrap items-center gap-3', $justifyClass]) }}>
    {{ $slot }}
</div>
