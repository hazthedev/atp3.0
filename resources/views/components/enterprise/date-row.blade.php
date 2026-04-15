@props([
    'label',
    'compact' => false,
])

<div class="grid items-center gap-3 {{ $compact ? 'grid-cols-[112px_120px_32px_88px]' : 'grid-cols-[112px_120px_32px_88px_minmax(0,1fr)]' }}">
    <span class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">{{ $label }}</span>
    {{ $slot }}
</div>
