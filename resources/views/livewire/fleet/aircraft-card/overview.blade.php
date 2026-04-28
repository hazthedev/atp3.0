@php
    $overview = $data['overview'];
    // Group status_summary tiles by group label
    $groups = [];
    foreach ($overview['status_summary'] as $tile) {
        $groups[$tile['group']][] = $tile;
    }
@endphp

<div class="space-y-4">
    {{-- Status Summary --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-sm font-semibold text-gray-900">Status Summary</h3>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
            @foreach ($groups as $groupLabel => $tiles)
                <div>
                    <div class="mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-500">{{ $groupLabel }}</div>
                    <div class="space-y-2">
                        @foreach ($tiles as $tile)
                            @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3 text-right">
            <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All →</a>
        </div>
    </section>

    {{-- Top-5 widgets row 1: Counters + Critical Maintenance Due --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Counters (Top 5)</h3>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All Counters →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">Counter Code</th>
                            <th class="py-1.5">Current Value</th>
                            <th class="py-1.5">UoM</th>
                            <th class="py-1.5">Reading Date</th>
                            <th class="py-1.5">Source</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($overview['top_counters'] as $row)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $row['code'] }}</td>
                                <td class="py-2">{{ $row['value'] }}</td>
                                <td class="py-2">{{ $row['unit'] }}</td>
                                <td class="py-2">{{ $row['reading_date'] }}</td>
                                <td class="py-2">{{ $row['source'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Critical Maintenance Due</h3>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All Criticals →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">Item</th>
                            <th class="py-1.5">Reference</th>
                            <th class="py-1.5">Description</th>
                            <th class="py-1.5">Next Due</th>
                            <th class="py-1.5">Remaining</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($overview['critical_due'] as $row)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $row['type'] }}</td>
                                <td class="py-2">{{ $row['reference'] }}</td>
                                <td class="py-2 text-gray-700">{{ $row['description'] }}</td>
                                <td class="py-2">{{ $row['next_due'] }}</td>
                                <td class="py-2">
                                    <span class="rounded px-1.5 py-0.5 text-[11px] font-semibold {{ ($row['tone'] ?? '') === 'red' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ $row['remaining'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- Row 2: Work Packages + Work Orders --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Work Packages (Last 5)</h3>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All Planned/Open →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">No.</th>
                            <th class="py-1.5">Description</th>
                            <th class="py-1.5">Status</th>
                            <th class="py-1.5">Prepared By</th>
                            <th class="py-1.5">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($overview['work_packages'] as $row)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $row['no'] }}</td>
                                <td class="py-2 text-gray-700">{{ $row['description'] }}</td>
                                <td class="py-2">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $row['status']])</td>
                                <td class="py-2">{{ $row['prepared_by'] }}</td>
                                <td class="py-2">{{ $row['date'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Work Orders (Last 5)</h3>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All Planned/Open →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">No.</th>
                            <th class="py-1.5">Type</th>
                            <th class="py-1.5">Description</th>
                            <th class="py-1.5">Status</th>
                            <th class="py-1.5">Next Due</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($overview['work_orders'] as $row)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $row['no'] }}</td>
                                <td class="py-2">{{ $row['type'] }}</td>
                                <td class="py-2 text-gray-700">{{ $row['description'] }}</td>
                                <td class="py-2">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $row['status']])</td>
                                <td class="py-2">{{ $row['next_due'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- Row 3: Journey Logs + Events --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Journey Log (Last 5)</h3>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All Aircraft Journey Logs →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">Log No.</th>
                            <th class="py-1.5">Status</th>
                            <th class="py-1.5">Date</th>
                            <th class="py-1.5">Total FH</th>
                            <th class="py-1.5">Total FC</th>
                            <th class="py-1.5">Sectors</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($overview['journey_logs'] as $row)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $row['no'] }}</td>
                                <td class="py-2">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $row['status']])</td>
                                <td class="py-2">{{ $row['date'] }}</td>
                                <td class="py-2">{{ $row['total_fh'] }}</td>
                                <td class="py-2">{{ $row['total_fc'] }}</td>
                                <td class="py-2">{{ $row['sectors'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Events (Last 5)</h3>
                <a href="#" class="text-xs font-medium text-blue-600 hover:underline">View All Aircraft Events →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">Event ID</th>
                            <th class="py-1.5">Type</th>
                            <th class="py-1.5">Category</th>
                            <th class="py-1.5">Date</th>
                            <th class="py-1.5">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($overview['events'] as $row)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $row['id'] }}</td>
                                <td class="py-2"><span class="rounded bg-blue-50 px-1.5 py-0.5 text-[11px] text-blue-700">{{ $row['type'] }}</span></td>
                                <td class="py-2">{{ $row['category'] }}</td>
                                <td class="py-2">{{ $row['date'] }}</td>
                                <td class="py-2 text-gray-700">{{ $row['description'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
