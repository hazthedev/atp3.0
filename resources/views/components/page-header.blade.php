@props([
    'title',
    'description' => null,
])

<div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
    <div class="space-y-2">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-600">ATP 3.0 Module</p>
        <div class="space-y-1">
            <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>
            @if ($description)
                <p class="max-w-3xl text-sm text-gray-500">{{ $description }}</p>
            @endif
        </div>
    </div>

    @isset($actions)
        <div class="flex flex-wrap items-center gap-3">
            {{ $actions }}
        </div>
    @endisset
</div>
