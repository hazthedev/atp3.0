@php
    $c = $data['counters'];
@endphp

<div class="space-y-3">
    {{-- Top row --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[1100px] grid-cols-3 gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Counters Summary</div>
                <div class="grid grid-cols-2 gap-1.5">
                    @foreach ($c['summary'] as $tile)
                        @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Counter Reading Checks</div>
                <ul class="space-y-1.5 text-[11px]">
                    @foreach ($c['reading_checks'] as $check)
                        <li class="flex items-start gap-1.5">
                            <x-icon name="check-circle" class="h-3.5 w-3.5 shrink-0 text-emerald-500" />
                            <div class="min-w-0">
                                <div class="font-medium text-gray-900">{{ $check['label'] }}</div>
                                <div class="text-[10px] text-gray-500">{{ $check['description'] }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="mt-2 inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="arrow-path" class="h-3 w-3" /> Run Checks
                </button>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Last Counter Update</div>
                <div class="flex items-center gap-2">
                    <x-icon name="calendar-days" class="h-5 w-5 text-blue-600" />
                    <div>
                        <div class="text-xs font-bold text-gray-900">{{ $c['last_update']['date'] }}</div>
                        <div class="text-[10px] text-gray-500">{{ $c['last_update']['time'] }}</div>
                    </div>
                    <div class="ml-auto text-right">
                        <div class="text-[10px] uppercase text-gray-500">By</div>
                        <div class="text-xs font-semibold text-gray-900">{{ $c['last_update']['by'] }}</div>
                    </div>
                </div>
                <a href="#" class="mt-2 inline-block text-[11px] text-blue-600 hover:underline">View Update History →</a>
            </section>
        </div>
    </div>

    {{-- Filters --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
        <div class="flex min-w-[1000px] items-center gap-1.5">
            <input type="text" placeholder="Search counter code or name..." class="input-field w-56 text-[11px]" />
            <select class="input-field w-28 text-[11px]"><option>All Counter Type</option></select>
            <select class="input-field w-28 text-[11px]"><option>All Source</option></select>
            <select class="input-field w-28 text-[11px]"><option>All Status</option></select>
            <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
            <div class="ml-auto flex items-center gap-1.5">
                <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="cog-6-tooth" class="h-3 w-3" /> Manage Counters
                </button>
                <button type="button" class="inline-flex items-center gap-1 rounded bg-blue-600 px-2 py-1 text-[11px] font-semibold text-white hover:bg-blue-700">Record / Update Counter Reading</button>
            </div>
        </div>
    </div>

    {{-- Table + side donuts --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[1100px] grid-cols-[1fr_280px] gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h3 class="mb-2 text-xs font-semibold text-gray-900">Aircraft Counters</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-[11px]">
                        <thead class="border-b border-gray-200 text-left text-[10px] uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="py-1">Counter Code</th>
                                <th class="py-1">Counter Name</th>
                                <th class="py-1 text-right">Counter Value</th>
                                <th class="py-1">Reading Date</th>
                                <th class="py-1">Source</th>
                                <th class="py-1">Status</th>
                                <th class="py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($c['rows'] as $r)
                                <tr>
                                    <td class="py-1 font-medium text-gray-900">{{ $r['code'] }}</td>
                                    <td class="py-1">{{ $r['name'] }}</td>
                                    <td class="py-1 text-right font-medium">{{ $r['value'] }}</td>
                                    <td class="py-1">{{ $r['reading_date'] }}</td>
                                    <td class="py-1">{{ $r['source'] }}</td>
                                    <td class="py-1">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                                    <td class="py-1 text-gray-400">···</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
                    <span>Showing 1 to {{ count($c['rows']) }} of {{ count($c['rows']) }} counters</span>
                    <span>Rows per page: 20</span>
                </div>
            </section>

            <div class="space-y-3">
                <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                    <div class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Counters by Type</div>
                    @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($c['by_type_donut'], ['center_label' => 'Total'])])
                </section>
                <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                    <div class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Counters by Source</div>
                    @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($c['by_source_donut'], ['center_label' => 'Total'])])
                </section>
                <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                    <div class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Quick Links</div>
                    <ul class="space-y-1 text-[11px]">
                        <li><a href="#" class="text-blue-600 hover:underline">View Counter Reading History</a></li>
                        <li><a href="#" class="text-blue-600 hover:underline">Run Counter Reading Checks</a></li>
                        <li><a href="#" class="text-blue-600 hover:underline">View Uninitialized Counters</a></li>
                        <li><a href="#" class="text-blue-600 hover:underline">Export Counter Readings</a></li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</div>
