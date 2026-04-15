@props([
    'ghost' => false,
])

<button {{ $attributes->merge(['type' => 'button'])->class([
    'inline-flex h-9 items-center justify-center rounded-lg border border-gray-300 px-2 text-xs font-medium text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-900',
    'bg-gray-50' => $ghost,
    'bg-white' => ! $ghost,
]) }}>
    {{ $slot }}
</button>
