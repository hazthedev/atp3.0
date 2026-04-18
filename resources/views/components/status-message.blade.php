@props([
    'message' => null,
    'tone' => 'blue',
])

@php
    $classes = match ($tone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };
@endphp

@if ($message)
    <div {{ $attributes->merge(['class' => 'flex items-center rounded-lg border p-4 text-sm ' . $classes]) }} role="alert">
        <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
        <span>{{ $message }}</span>
    </div>
@endif
