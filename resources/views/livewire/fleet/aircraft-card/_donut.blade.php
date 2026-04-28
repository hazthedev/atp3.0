@php
    /**
     * @var array{total?: int|string, segments: array<int, array{label: string, value: int|float, color: string, pct?: int|float}>} $donut
     */
    $segments = $donut['segments'] ?? [];
    $totalValue = $donut['total'] ?? array_sum(array_column($segments, 'value'));
    $centerLabel = $donut['center_label'] ?? null;
    $centerValue = $donut['center_value'] ?? $totalValue;

    // Build conic-gradient stops
    $sum = array_sum(array_column($segments, 'value')) ?: 1;
    $cursor = 0;
    $stops = [];
    foreach ($segments as $seg) {
        $share = ($seg['value'] / $sum) * 100;
        $stops[] = "{$seg['color']} {$cursor}% " . ($cursor + $share) . '%';
        $cursor += $share;
    }
    $gradient = 'conic-gradient(' . implode(', ', $stops) . ')';
@endphp

<div class="flex items-center gap-4">
    <div class="relative h-24 w-24 shrink-0 rounded-full" style="background: {{ $gradient }};">
        <div class="absolute inset-2 flex flex-col items-center justify-center rounded-full bg-white">
            <div class="text-lg font-bold text-gray-900">{{ $centerValue }}</div>
            @if ($centerLabel)
                <div class="text-[10px] uppercase text-gray-500">{{ $centerLabel }}</div>
            @endif
        </div>
    </div>
    <ul class="flex-1 space-y-1 text-xs">
        @foreach ($segments as $seg)
            <li class="flex items-center justify-between gap-2">
                <span class="flex items-center gap-1.5">
                    <span class="inline-block h-2.5 w-2.5 rounded-sm" style="background: {{ $seg['color'] }};"></span>
                    <span class="text-gray-700">{{ $seg['label'] }}</span>
                </span>
                <span class="font-medium text-gray-900">
                    {{ $seg['value'] }}@if (isset($seg['pct'])) ({{ $seg['pct'] }}%)@endif
                </span>
            </li>
        @endforeach
    </ul>
</div>
