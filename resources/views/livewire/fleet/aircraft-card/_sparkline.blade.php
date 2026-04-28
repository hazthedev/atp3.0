@php
    /**
     * @var array<int, float|int> $series
     * @var string $color
     */
    $series = $series ?? [];
    $color = $color ?? '#2563eb';

    $width = 110;
    $height = 36;
    $count = count($series);
    if ($count < 2) {
        $points = '';
    } else {
        $min = min($series);
        $max = max($series);
        $range = max($max - $min, 0.0001);
        $stepX = $width / ($count - 1);
        $coords = [];
        foreach ($series as $i => $v) {
            $x = round($i * $stepX, 2);
            $y = round($height - (($v - $min) / $range) * $height, 2);
            $coords[] = "$x,$y";
        }
        $points = implode(' ', $coords);
    }
@endphp

<svg viewBox="0 0 {{ $width }} {{ $height }}" preserveAspectRatio="none" class="mt-1 h-9 w-full">
    @if ($points !== '')
        <polyline
            fill="none"
            stroke="{{ $color }}"
            stroke-width="1.6"
            stroke-linecap="round"
            stroke-linejoin="round"
            points="{{ $points }}"
        />
    @endif
</svg>
