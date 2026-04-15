@php
    use Illuminate\Support\Str;

    $columns = $columns ?? ['Code', 'Name', 'Category', 'Status', 'Updated'];
    $showActions = $showActions ?? true;
    $slug = strtoupper(Str::substr(Str::replace('-', '', Str::slug($title)), 0, 3));
    $rows = $rows ?? [
        [$slug . '-1001', $title . ' Alpha', 'Primary', '<span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>', '2 hours ago'],
        [$slug . '-1002', $title . ' Bravo', 'Operational', '<span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">Planned</span>', 'Yesterday'],
        [$slug . '-1003', $title . ' Charlie', 'Reference', '<span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pending</span>', 'Last week'],
    ];
    $createLabel = $createLabel ?? ('New ' . Str::headline($title));
@endphp

<div class="space-y-6">
    <x-page-header :title="$title" :description="$description">
        @isset($createRoute)
            <x-slot name="actions">
                <a href="{{ route($createRoute) }}" class="btn-primary">
                    <x-icon name="plus" class="h-4 w-4" />
                    {{ $createLabel }}
                </a>
            </x-slot>
        @endisset
    </x-page-header>

    <div class="space-y-6">
        <x-data-table datatable>
            <x-slot name="search">
                <input type="text" class="input-field w-full md:w-72" placeholder="Search {{ strtolower($title) }}..." />
            </x-slot>

            <x-slot name="thead">
                <tr>
                    @foreach ($columns as $column)
                        <th class="table-th">{{ $column }}</th>
                    @endforeach
                    @if ($showActions)
                        <th class="table-th" data-sortable="false">Actions</th>
                    @endif
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($rows as $row)
                    <tr class="table-row group">
                        @foreach ($row as $cell)
                            <td class="table-td">
                                @if (is_array($cell) && ($cell['type'] ?? null) === 'drilldown')
                                    <a href="{{ $cell['href'] }}" class="group/drill inline-flex items-center gap-3 font-semibold text-gray-900 transition hover:text-blue-700">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                        </span>
                                        <span>{{ $cell['label'] }}</span>
                                    </a>
                                @else
                                    {!! $cell !!}
                                @endif
                            </td>
                        @endforeach
                        @if ($showActions)
                            <td class="table-td">
                                <div class="flex gap-2">
                                    <button type="button" class="btn-ghost px-3">View</button>
                                    <button type="button" class="btn-secondary px-3">Edit</button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </x-slot>

            <x-slot name="pagination">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-gray-500">Showing 1 to {{ count($rows) }} of {{ count($rows) }} entries.</p>
                    <nav class="inline-flex overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                        <a href="#" class="border-r border-gray-200 bg-white px-3 py-2 text-sm text-gray-500">Previous</a>
                        <a href="#" class="bg-blue-600 px-3 py-2 text-sm font-medium text-white">1</a>
                        <a href="#" class="border-l border-gray-200 bg-white px-3 py-2 text-sm text-gray-500">Next</a>
                    </nav>
                </div>
            </x-slot>
        </x-data-table>

        <x-skeleton type="table" :rows="4" />
    </div>
</div>
