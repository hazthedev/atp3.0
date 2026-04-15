@props([
    'label',
    'for' => null,
    'columns' => 'sm:grid-cols-[160px_minmax(0,320px)]',
    'labelClass' => 'text-xs font-semibold uppercase tracking-[0.16em] text-gray-500',
])

<div {{ $attributes->class(['grid items-end gap-4', $columns]) }}>
    @if ($for)
        <label for="{{ $for }}" class="{{ $labelClass }}">{{ $label }}</label>
    @else
        <span class="{{ $labelClass }}">{{ $label }}</span>
    @endif

    <div class="w-full">
        {{ $slot }}
    </div>
</div>
