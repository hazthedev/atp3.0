@props([
    'label',
    'value',
    'trend' => null,
    'icon' => 'chart-bar',
    'trendColor' => 'text-emerald-600',
])

<div class="stat-card">
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-sm text-gray-500">{{ $label }}</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $value }}</p>
            @if ($trend)
                <p class="mt-2 text-xs font-medium {{ $trendColor }}">{{ $trend }}</p>
            @endif
        </div>

        <div class="rounded-lg bg-blue-50 p-2.5 text-blue-600">
            <x-icon :name="$icon" class="h-5 w-5" />
        </div>
    </div>
</div>
