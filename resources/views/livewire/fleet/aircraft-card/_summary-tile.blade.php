@php
    $tone  = $tone ?? null;
    $icon  = $icon ?? 'check-circle';
    $value = $value ?? ($count ?? '0');
    $label = $label ?? '';

    $iconClasses = match ($tone) {
        'green' => 'text-emerald-600 bg-emerald-50',
        'amber' => 'text-amber-600 bg-amber-50',
        'red'   => 'text-red-600 bg-red-50',
        default => 'text-gray-500 bg-gray-100',
    };
@endphp

<div class="flex items-center gap-2 rounded border border-gray-200 bg-white px-2 py-1.5">
    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded {{ $iconClasses }}">
        <x-icon :name="$icon" class="h-4 w-4" />
    </div>
    <div class="min-w-0 leading-tight">
        <div class="text-base font-bold text-gray-900">{{ $value }}</div>
        <div class="truncate text-[10px] text-gray-500">{{ $label }}</div>
    </div>
</div>
