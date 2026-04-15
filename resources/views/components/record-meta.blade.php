@props([
    'items' => [],
])

<div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-500">
    @foreach ($items as $item)
        <div class="flex items-center gap-2">
            <span class="field-label !tracking-[0.12em]">{{ $item['label'] }}</span>
            <span class="font-medium text-gray-700">{{ $item['value'] }}</span>
        </div>
    @endforeach
</div>
