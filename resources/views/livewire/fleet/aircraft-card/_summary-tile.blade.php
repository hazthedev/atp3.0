@php
    $tone = $tone ?? null;
    $icon = $icon ?? 'check-circle';
    $value = $value ?? '0';
    $label = $label ?? '';

    $iconClasses = match ($tone) {
        'green' => 'text-emerald-600 bg-emerald-50',
        'amber' => 'text-amber-600 bg-amber-50',
        'red'   => 'text-red-600 bg-red-50',
        default => 'text-gray-500 bg-gray-100',
    };
@endphp

<div class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2.5 shadow-sm">
    <div class="flex h-9 w-9 items-center justify-center rounded-md {{ $iconClasses }}">
        <x-icon :name="$icon" class="h-5 w-5" />
    </div>
    <div class="min-w-0">
        <div class="text-lg font-bold text-gray-900">{{ $value }}</div>
        <div class="truncate text-[11px] text-gray-500">{{ $label }}</div>
    </div>
</div>
