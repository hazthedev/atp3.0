@props([
    'icon' => 'document',
    'label' => 'No records found',
    'description' => 'Add or import data to populate this view.',
])

<div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-gray-300 shadow-sm">
        <x-icon :name="$icon" class="h-7 w-7" />
    </div>
    <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ $label }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">{{ $description }}</p>
    @if (trim((string) $slot) !== '')
        <div class="mt-5 flex justify-center">
            {{ $slot }}
        </div>
    @endif
</div>
