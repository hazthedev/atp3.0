@props([
    'label',
    'for' => null,
    'labelClass' => 'text-xs font-semibold uppercase tracking-[0.16em] text-gray-500',
])

<div {{ $attributes->class(['grid grid-cols-[112px_minmax(0,1fr)] items-center gap-3']) }}>
    <x-enterprise.label :for="$for" :labelClass="$labelClass">{{ $label }}</x-enterprise.label>

    {{ $slot }}
</div>
