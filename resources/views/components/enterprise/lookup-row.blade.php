@props([
    'label',
    'for' => null,
    'labelClass' => 'text-xs font-semibold uppercase tracking-[0.16em] text-gray-500',
])

<x-enterprise.field-row :label="$label" :for="$for" :label-class="$labelClass" {{ $attributes }}>
    <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
        {{ $slot }}
        @isset($action)
            {{ $action }}
        @endisset
    </div>
</x-enterprise.field-row>
