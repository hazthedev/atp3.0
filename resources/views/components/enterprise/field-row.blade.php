@props([
    'label',
    'for' => null,
    'labelClass' => 'text-xs font-semibold uppercase tracking-[0.16em] text-gray-500',
    'columns' => null,
])

@php
    $resolvedColumns = $columns ?? 'grid-cols-[112px_minmax(0,1fr)]';
@endphp

<div {{ $attributes->class(['grid items-center gap-3', $resolvedColumns]) }}>
    <x-enterprise.label :for="$for" :labelClass="$labelClass">{{ $label }}</x-enterprise.label>

    {{ $slot }}
</div>
