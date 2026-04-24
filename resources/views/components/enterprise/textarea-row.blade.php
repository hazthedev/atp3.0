@props([
    'label',
    'rows' => 3,
    'columns' => 'grid-cols-[112px_minmax(0,1fr)]',
])

<div class="grid items-start gap-3 {{ $columns }}">
    <x-enterprise.label labelClass="pt-2 text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">{{ $label }}</x-enterprise.label>
    <x-enterprise.textarea :rows="$rows" {{ $attributes }} />
</div>
