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

    $routeParams = request()->route()?->parameters() ?? [];

    // Dynamic last-segment label for known detail routes:
    // <type>/<serial>/<registration> for FL, <variant>/<serial>/<equipment_no> for equipment.
    $detailLabel = null;
    if (in_array($routeName, ['fleet.functional-location.show', 'fleet.functional-location.edit'], true)) {
        $id = $routeParams['id'] ?? null;
        if ($id !== null) {
            $fl = \App\Models\FunctionalLocation::find($id);
            if ($fl !== null) {
                $detailLabel = implode('/', array_filter([
                    $fl->type,
                    $fl->serial_no,
                    $fl->registration,
                ])) ?: null;
            }
        }
    } elseif (in_array($routeName, ['fleet.equipment.show'], true)) {
        $id = $routeParams['id'] ?? null;
        if ($id !== null) {
            $eq = \App\Models\Equipment::find($id);
            if ($eq !== null) {
                $detailLabel = implode('/', array_filter([
                    $eq->variant,
                    $eq->serial_number,
                    $eq->equipment_no,
                ])) ?: null;
            }
        }
    }

    if ($detailLabel !== null && $trail !== []) {
        $last = array_key_last($trail);
        $lastEntry = $trail[$last];
        if (is_array($lastEntry)) {
            $lastEntry[0] = $detailLabel;
            $trail[$last] = $lastEntry;
        } else {
            $trail[$last] = $detailLabel;
        }
    }

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
    <nav aria-label="Breadcrumb" class="mt-0.5">
        <ol class="flex flex-wrap items-center gap-1.5 text-xs text-gray-500">
            @foreach ($items as $item)
                <li class="flex items-center gap-1.5">
                    @if (! $loop->first)
                        <span class="text-gray-300">/</span>
                    @endif

                    @if ($loop->last)
                        <span class="font-medium text-gray-700">{{ $item['label'] }}</span>
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
