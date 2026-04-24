@props([
    'label',
    'rows' => 3,
])

<div class="grid grid-cols-[112px_minmax(0,1fr)] items-start gap-3">
    <span class="pt-2 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">{{ $label }}</span>
    <x-enterprise.textarea :rows="$rows" {{ $attributes }} />
</div>
