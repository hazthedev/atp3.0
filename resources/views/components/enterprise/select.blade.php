@props([
    'variant' => null,  {{-- null | 'cell' --}}
])

@php
    $base = 'input-field';

    // Borderless select sized for a <td> in an inline-edit grid. Mirrors the
    // raw pattern used by counter-ref-manager's inline selects so those pages
    // can migrate without visual regression.
    $cellClass = 'w-full border-0 bg-transparent px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-100';
@endphp

@if ($variant === 'cell')
    <select {{ $attributes->class([$cellClass]) }}>
        {{ $slot }}
    </select>

@else
    <select {{ $attributes->class([$base]) }}>
        {{ $slot }}
    </select>
@endif
