@props([
    'id',
    'title',
    'maxWidth' => 'max-w-3xl',
])

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail.id === '{{ $id }}') open = true"
    x-on:close-modal.window="if ($event.detail.id === '{{ $id }}') open = false"
    x-on:keydown.escape.window="open = false"
    x-cloak
    x-show="open"
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div
            class="fixed inset-0 bg-gray-900/50"
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="open = false"
        ></div>

        <div
            class="relative w-full {{ $maxWidth }} rounded-2xl border border-gray-200 bg-white shadow-lg"
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-6 py-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Flowbite-ready modal shell for frontend-only interactions.</p>
                </div>

                <button type="button" class="btn-ghost px-3" @click="open = false" aria-label="Close modal">
                    <x-icon name="x-circle" />
                </button>
            </div>

            <div class="space-y-4 px-6 py-5">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-6 py-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
