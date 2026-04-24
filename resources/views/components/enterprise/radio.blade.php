@props([
    'value',
    'label' => null,
    'labelClass' => 'inline-flex items-center gap-3 text-sm text-gray-700',
])

@if ($label === null || $label === '')
    <input type="radio" value="{{ $value }}" {{ $attributes->class(['h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500']) }} />
@else
    <label class="{{ $labelClass }}">
        <input type="radio" value="{{ $value }}" {{ $attributes->class(['h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500']) }} />
        <span>{{ $label }}</span>
    </label>
@endif
