@props([
    'variant' => null,  {{-- null | 'arrow' --}}
    'href'    => '#',
])

@if ($variant === 'arrow')
    <a href="{{ $href }}" class="inline-flex items-center gap-3 font-medium text-gray-900 transition hover:text-blue-700">
        <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
        </span>
        {{ $slot }}
    </a>
@else
    {{ $slot }}
@endif
