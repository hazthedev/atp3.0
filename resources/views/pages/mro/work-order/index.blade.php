@extends('layouts.app')

@section('title', 'List of Open Work Orders')

@section('content')
    @php
        // Open = Planned / Released / Postponed. Closed and Cancelled hidden here.
        $openStatuses = ['-0000001', '-0000002', '-0000005', '-0000015', '-0000016', '-0000017', '-0000018', '-0000019', '00000001', '00000002'];
        $orders = App\Models\WorkOrder::with(['status', 'variant'])
            ->whereIn('status_code', $openStatuses)
            ->orderByDesc('planned_date')
            ->get();

        $plannedCount = $orders->where('status_code', '-0000001')->count();
        $releasedCount = $orders->where('status_code', '-0000002')->count();
        $postponedCount = $orders->where('status_code', '-0000019')->count();
    @endphp

    <div class="space-y-6">
        <x-page-header
            title="List of Open Work Orders"
            description="Work orders not yet closed or cancelled. Drawn from SAP @MRO_MOR2 → MORC + archived in @MRO_AMR4/AMR8 upon closure."
        >
            <x-slot name="actions">
                <span class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">{{ $plannedCount }} planned</span>
                <span class="inline-flex items-center gap-2 rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">{{ $releasedCount }} released</span>
                @if ($postponedCount > 0)
                    <span class="inline-flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">{{ $postponedCount }} postponed</span>
                @endif
                <span class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                    <x-icon name="document" class="h-3.5 w-3.5" />
                    @MRO_MOR*
                </span>
            </x-slot>
        </x-page-header>

        <x-data-table datatable>
            <x-slot name="search">
                <input type="text" class="input-field w-full md:w-72" placeholder="Search code / aircraft / title…" />
            </x-slot>

            <x-slot name="thead">
                <tr>
                    <th class="table-th">Code</th>
                    <th class="table-th">A/C Reg.</th>
                    <th class="table-th">Variant</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Work Package</th>
                    <th class="table-th">Planned</th>
                    <th class="table-th">Released</th>
                    <th class="table-th">Title</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($orders as $wo)
                    <tr class="table-row">
                        <td class="table-td">
                            <span class="font-mono text-xs text-blue-700">{{ $wo->code }}</span>
                        </td>
                        <td class="table-td font-medium text-gray-900">{{ $wo->aircraft_registration ?? '—' }}</td>
                        <td class="table-td text-xs text-gray-600">{{ optional($wo->variant)->name ?? '—' }}</td>
                        <td class="table-td">
                            @php
                                $name = optional($wo->status)->name ?? 'Unknown';
                                $class = match ($wo->status_code) {
                                    '-0000001' => 'bg-blue-100 text-blue-700',
                                    '-0000002' => 'bg-emerald-100 text-emerald-700',
                                    '-0000019' => 'bg-amber-100 text-amber-700',
                                    '00000003' => 'bg-gray-100 text-gray-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $class }}">{{ $name }}</span>
                        </td>
                        <td class="table-td">
                            @if ($wo->work_package_code)
                                <span class="font-mono text-xs text-gray-600">{{ $wo->work_package_code }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="table-td text-xs text-gray-600">{{ optional($wo->planned_date)->format('d.m.Y') ?? '—' }}</td>
                        <td class="table-td text-xs text-gray-600">{{ optional($wo->released_date)->format('d.m.Y') ?? '—' }}</td>
                        <td class="table-td max-w-md truncate text-sm text-gray-700" title="{{ $wo->title }}">{{ $wo->title ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="table-td text-center text-sm text-gray-400">No open work orders. Run <code>php artisan migrate --seed</code>.</td></tr>
                @endforelse
            </x-slot>
        </x-data-table>
    </div>
@endsection
