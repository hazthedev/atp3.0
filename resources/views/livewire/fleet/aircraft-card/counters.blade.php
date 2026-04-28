@php
    $c = $data['counters'];
@endphp

<div class="space-y-4">
    {{-- Top row: summary, reading checks, last update --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Counters Summary</div>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($c['summary'] as $tile)
                    @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Counter Reading Checks</div>
            <ul class="space-y-2 text-xs">
                @foreach ($c['reading_checks'] as $check)
                    <li class="flex items-start gap-2">
                        <x-icon name="check-circle" class="h-4 w-4 shrink-0 text-emerald-500" />
                        <div>
                            <div class="font-medium text-gray-900">{{ $check['label'] }}</div>
                            <div class="text-gray-500">{{ $check['description'] }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <button type="button" class="mt-3 inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="arrow-path" class="h-3.5 w-3.5" /> Run Checks
            </button>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Last Counter Update</div>
            <div class="flex items-center gap-3">
                <x-icon name="calendar-days" class="h-6 w-6 text-blue-600" />
                <div>
                    <div class="text-sm font-bold text-gray-900">{{ $c['last_update']['date'] }}</div>
                    <div class="text-[11px] text-gray-500">{{ $c['last_update']['time'] }}</div>
                </div>
                <div class="ml-auto text-right">
                    <div class="text-[11px] uppercase text-gray-500">By</div>
                    <div class="text-sm font-semibold text-gray-900">{{ $c['last_update']['by'] }}</div>
                </div>
            </div>
            <a href="#" class="mt-3 inline-block text-xs text-blue-600 hover:underline">View Update History →</a>
        </section>
    </div>

    {{-- Filters bar + manage button --}}
    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
        <input type="text" placeholder="Search counter code or name..." class="input-field w-64 text-xs" />
        <select class="input-field w-32 text-xs"><option>All Counter Type</option></select>
        <select class="input-field w-32 text-xs"><option>All Source</option></select>
        <select class="input-field w-32 text-xs"><option>All Status</option></select>
        <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
        <div class="ml-auto flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="cog-6-tooth" class="h-3.5 w-3.5" /> Manage Counters
            </button>
            <button type="button" class="inline-flex items-center gap-1.5 rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">
                Record / Update Counter Reading
            </button>
        </div>
    </div>

    {{-- Table + side donuts --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_300px]">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="mb-3 text-sm font-semibold text-gray-900">Aircraft Counters</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">Counter Code</th>
                            <th class="py-1.5">Counter Name</th>
                            <th class="py-1.5 text-right">Counter Value</th>
                            <th class="py-1.5">Reading Date</th>
                            <th class="py-1.5">Source</th>
                            <th class="py-1.5">Status</th>
                            <th class="py-1.5">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($c['rows'] as $r)
                            <tr>
                                <td class="py-2 font-medium text-gray-900">{{ $r['code'] }}</td>
                                <td class="py-2">{{ $r['name'] }}</td>
                                <td class="py-2 text-right font-medium">{{ $r['value'] }}</td>
                                <td class="py-2">{{ $r['reading_date'] }}</td>
                                <td class="py-2">{{ $r['source'] }}</td>
                                <td class="py-2">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                                <td class="py-2 text-gray-400">···</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
                <span>Showing 1 to {{ count($c['rows']) }} of {{ count($c['rows']) }} counters</span>
                <span>Rows per page: 20</span>
            </div>
        </section>

        <div class="space-y-3">
            <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Counters by Type</div>
                @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($c['by_type_donut'], ['center_label' => 'Total'])])
            </section>
            <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Counters by Source</div>
                @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($c['by_source_donut'], ['center_label' => 'Total'])])
            </section>
            <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Quick Links</div>
                <ul class="space-y-1.5 text-xs">
                    <li><a href="#" class="text-blue-600 hover:underline">View Counter Reading History</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Run Counter Reading Checks</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">View Uninitialized Counters</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Export Counter Readings</a></li>
                </ul>
            </section>
        </div>
    </div>
</div>
