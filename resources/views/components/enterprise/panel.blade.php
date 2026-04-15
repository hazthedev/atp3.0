@props([
    'muted' => false,
])

<div {{ $attributes->class(['rounded-xl border border-gray-200 p-4 shadow-sm', 'bg-gray-50/80' => $muted]) }}>
    {{ $slot }}
</div>
