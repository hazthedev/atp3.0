@php
    use Illuminate\Support\Str;

    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
    $trail = config('breadcrumbs.' . $routeName, []);

    if ($trail === [] && $routeName) {
        $trail = collect(explode('.', $routeName))
            ->map(fn (string $segment) => Str::title(str_replace('-', ' ', $segment)))
            ->all();
    }
@endphp

@if ($trail !== [])
    <nav aria-label="Breadcrumb" class="rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
            @foreach ($trail as $segment)
                <li class="flex items-center gap-2">
                    @if (! $loop->first)
                        <span class="text-gray-300">/</span>
                    @endif
                    <span class="{{ $loop->last ? 'font-medium text-gray-900' : '' }}">{{ $segment }}</span>
                </li>
            @endforeach
        </ol>
    </nav>
@endif
