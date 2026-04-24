@props([
    'label' => null,
    'inline' => false,
    'labelClass' => 'flex items-center text-sm text-gray-600',
    'inputClass' => 'h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500',
])

@if ($label === null || $label === '')
    <input type="checkbox" {{ $attributes->class([$inputClass]) }} />
@else
    <label class="{{ $labelClass }} {{ $inline ? 'gap-2' : 'gap-3' }}">
        <input type="checkbox" {{ $attributes->class([$inputClass]) }} />
        <span>{{ $label }}</span>
    </label>
@endif
