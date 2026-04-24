@props([
    'for' => null,
    'labelClass' => 'text-xs font-semibold uppercase tracking-[0.16em] text-gray-500',
])

@if ($for)
    <label for="{{ $for }}" class="{{ $labelClass }}">{{ $slot }}</label>
@else
    <span class="{{ $labelClass }}">{{ $slot }}</span>
@endif
