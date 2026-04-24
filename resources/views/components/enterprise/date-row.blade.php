@props([
    'label',
    'compact' => false,
    'columns' => null,
])

@php
    $resolvedColumns = $columns ?? ($compact ? 'grid-cols-[112px_120px_32px_88px]' : 'grid-cols-[112px_120px_32px_88px_minmax(0,1fr)]');
@endphp

<div class="grid items-center gap-3 {{ $resolvedColumns }}">
    <x-enterprise.label>{{ $label }}</x-enterprise.label>
    {{ $slot }}
</div>
