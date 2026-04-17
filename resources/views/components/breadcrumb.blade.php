@php
    use Illuminate\Support\Str;

    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
    $trail = config('breadcrumbs.' . $routeName, []);
    $parentRoutes = config('breadcrumbs._parent_routes', []);

    if ($trail === [] && $routeName) {
        $trail = collect(explode('.', $routeName))
            ->map(fn (string $segment) => Str::title(str_replace('-', ' ', $segment)))
            ->all();
    }

    // Reuse the current URL's route parameters (e.g. {id}) when resolving
    // parameterised parent routes so e.g. "Details" on the edit page links back
    // to the correct show URL.
    $routeParams = request()->route()?->parameters() ?? [];

    $items = array_map(static function (mixed $segment) use ($routeParams, $parentRoutes): array {
        if (is_array($segment)) {
            [$label, $targetRoute] = [$segment[0], $segment[1] ?? null];
        } else {
            $label = $segment;
            $targetRoute = $parentRoutes[$segment] ?? null;
        }

        $url = null;
        if ($targetRoute) {
            try {
                $url = route($targetRoute, $routeParams);
            } catch (\Exception) {
                // Route requires params we don't have — skip the link.
            }
        }

        return ['label' => $label, 'url' => $url];
    }, $trail);
@endphp

@if ($items !== [])
    <nav aria-label="Breadcrumb" class="rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
            @foreach ($items as $item)
                <li class="flex items-center gap-2">
                    @if (! $loop->first)
                        <span class="text-gray-300">/</span>
                    @endif

                    @if ($loop->last)
                        <span class="font-medium text-gray-900">{{ $item['label'] }}</span>
                    @elseif ($item['url'])
                        <a href="{{ $item['url'] }}" class="transition hover:text-gray-900 hover:underline">{{ $item['label'] }}</a>
                    @else
                        <span>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
