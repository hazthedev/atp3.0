@props([
    'label',
    'for' => null,
    'columns' => 'sm:grid-cols-[160px_minmax(0,320px)]',
    'labelClass' => 'text-xs font-semibold uppercase tracking-[0.16em] text-gray-500',
])

<div {{ $attributes->class(['grid items-end gap-4', $columns]) }}>
    <x-enterprise.label :for="$for" :labelClass="$labelClass">{{ $label }}</x-enterprise.label>

    <div class="w-full">
        {{ $slot }}
    </div>
</div>
