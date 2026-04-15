@props([
    'title' => null,
    'description' => null,
    'padding' => 'p-5',
    'hoverable' => false,
])

<section {{ $attributes->class([$hoverable ? 'card-hover' : 'card', $padding]) }}>
    @if ($title || $description)
        <div class="mb-4 flex flex-col gap-1">
            @if ($title)
                <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="text-sm text-gray-500">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
