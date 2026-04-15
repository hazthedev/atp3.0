@props([
    'label',
    'inline' => false,
])

<label class="flex items-center text-sm text-gray-600 {{ $inline ? 'gap-2' : 'gap-3' }}">
    <input type="checkbox" {{ $attributes->class(['h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500']) }} />
    <span>{{ $label }}</span>
</label>
