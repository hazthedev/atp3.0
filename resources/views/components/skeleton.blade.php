@props([
    'type',
    'rows' => 5,
])

@switch($type)
    @case('table')
        <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            @for ($i = 0; $i < $rows; $i++)
                <div class="flex gap-4">
                    <div class="h-4 w-1/4 animate-pulse rounded bg-gray-200"></div>
                    <div class="h-4 w-1/3 animate-pulse rounded bg-gray-200"></div>
                    <div class="h-4 w-1/2 animate-pulse rounded bg-gray-200"></div>
                    <div class="h-4 w-1/5 animate-pulse rounded bg-gray-200"></div>
                </div>
            @endfor
        </div>
        @break
    @case('card')
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="mb-4 h-6 w-1/3 animate-pulse rounded bg-gray-200"></div>
            <div class="mb-2 h-4 w-full animate-pulse rounded bg-gray-200"></div>
            <div class="mb-2 h-4 w-5/6 animate-pulse rounded bg-gray-200"></div>
            <div class="h-4 w-2/3 animate-pulse rounded bg-gray-200"></div>
        </div>
        @break
    @case('stat')
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 animate-pulse rounded-full bg-gray-200"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-6 w-1/4 animate-pulse rounded bg-gray-200"></div>
                    <div class="h-4 w-1/3 animate-pulse rounded bg-gray-200"></div>
                </div>
            </div>
        </div>
        @break
    @default
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            @for ($i = 0; $i < 4; $i++)
                <div class="mb-4">
                    <div class="mb-1.5 h-3 w-1/4 animate-pulse rounded bg-gray-200"></div>
                    <div class="h-10 animate-pulse rounded-lg bg-gray-200"></div>
                </div>
            @endfor
        </div>
@endswitch
