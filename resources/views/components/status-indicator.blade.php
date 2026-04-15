@props([
    'label',
    'tone' => 'success',
])

@php
    $tones = [
        'success' => ['dot' => 'bg-emerald-500', 'wrap' => 'bg-emerald-50 text-emerald-700 ring-emerald-100'],
        'warning' => ['dot' => 'bg-amber-500', 'wrap' => 'bg-amber-50 text-amber-700 ring-amber-100'],
        'danger' => ['dot' => 'bg-red-500', 'wrap' => 'bg-red-50 text-red-700 ring-red-100'],
        'info' => ['dot' => 'bg-blue-500', 'wrap' => 'bg-blue-50 text-blue-700 ring-blue-100'],
    ][$tone] ?? ['dot' => 'bg-gray-400', 'wrap' => 'bg-gray-100 text-gray-700 ring-gray-200'];
@endphp

<span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-semibold ring-1 ring-inset {{ $tones['wrap'] }}">
    <span class="h-2.5 w-2.5 rounded-full {{ $tones['dot'] }}"></span>
    <span>{{ $label }}</span>
</span>
