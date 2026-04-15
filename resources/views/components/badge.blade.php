@props([
    'color' => 'default',
])

@php
    $palette = [
        'success' => 'bg-emerald-100 text-emerald-700',
        'danger' => 'bg-red-100 text-red-700',
        'warning' => 'bg-amber-100 text-amber-700',
        'info' => 'bg-blue-100 text-blue-700',
        'default' => 'bg-gray-100 text-gray-700',
    ][$color] ?? 'bg-gray-100 text-gray-700';
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {$palette}") }}>
    {{ $slot }}
</span>
