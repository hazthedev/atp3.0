@php
    $m = $data['maintenance'];
@endphp

<div class="space-y-4">
    {{-- Top row --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_360px_320px_280px]">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Maintenance Summary</div>
            <div class="grid grid-cols-5 gap-2">
                @foreach ($m['summary'] as $tile)
                    @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Maintenance Status</div>
            @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($m['donut'], ['center_label' => 'Compliant', 'center_value' => $m['donut']['pct_compliant'] . '%'])])
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Maintenance Utilization (Since New)</div>
            <dl class="grid grid-cols-3 gap-3 text-center text-xs">
                <div><dt class="text-gray-500">FH</dt><dd class="text-lg font-bold text-gray-900">{{ $m['utilization']['fh'] }}</dd></div>
                <div><dt class="text-gray-500">FC</dt><dd class="text-lg font-bold text-gray-900">{{ $m['utilization']['fc'] }}</dd></div>
                <div><dt class="text-gray-500">Days</dt><dd class="text-lg font-bold text-gray-900">{{ $m['utilization']['cal_days'] }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Access Maintenance Planning</div>
            <p class="text-[11px] text-gray-500">View and manage the maintenance planning data used to determine due tasks and compliance.</p>
            <a href="#" class="mt-3 inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="calendar-days" class="h-3.5 w-3.5" /> Go to Maintenance Planning →
            </a>
        </section>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
        <input type="text" placeholder="Search by item reference, component, ATA chapter..." class="input-field w-72 text-xs" />
        <select class="input-field w-32 text-xs"><option>All Item Type</option></select>
        <select class="input-field w-32 text-xs"><option>All ATA Chapter</option></select>
        <select class="input-field w-40 text-xs"><option>All Maintenance Status</option></select>
        <input type="text" placeholder="From" class="input-field w-28 text-xs" />
        <input type="text" placeholder="To"   class="input-field w-28 text-xs" />
        <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
        <button type="button" class="ml-auto inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
            <x-icon name="cog-6-tooth" class="h-3.5 w-3.5" /> Manage Maintenance
        </button>
    </div>

    {{-- Items table --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-sm font-semibold text-gray-900">Maintenance Items ({{ $m['summary'][0]['value'] }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                        <th class="py-1.5 pl-2" rowspan="2">Item Type</th>
                        <th class="py-1.5" rowspan="2">Reference</th>
                        <th class="py-1.5" rowspan="2">Description</th>
                        <th class="py-1.5" rowspan="2">Component / System</th>
                        <th class="py-1.5 text-center" colspan="4">Last Done</th>
                        <th class="py-1.5" rowspan="2">Threshold / Interval</th>
                        <th class="py-1.5 text-center" colspan="4">Next Due</th>
                        <th class="py-1.5" rowspan="2">Maintenance Status</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left uppercase text-gray-500">
                        <th class="py-1.5">Date</th>
                        <th class="py-1.5">FH/FC</th>
                        <th class="py-1.5">Work Order</th>
                        <th class="py-1.5">Work Package</th>
                        <th class="py-1.5">Date</th>
                        <th class="py-1.5">FH/FC</th>
                        <th class="py-1.5">Remaining FH/FC</th>
                        <th class="py-1.5">Days</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($m['rows'] as $r)
                        <tr>
                            <td class="py-1.5 pl-2 font-medium text-gray-900">{{ $r['type'] }}</td>
                            <td class="py-1.5">{{ $r['reference'] }}</td>
                            <td class="py-1.5 text-gray-700">{{ $r['description'] }}</td>
                            <td class="py-1.5">{{ $r['component'] }}</td>
                            <td class="py-1.5">{{ $r['last_date'] }}</td>
                            <td class="py-1.5">{{ $r['last_fh_fc'] }}</td>
                            <td class="py-1.5">{{ $r['work_order'] }}</td>
                            <td class="py-1.5">{{ $r['work_package'] }}</td>
                            <td class="py-1.5">{{ $r['threshold'] }} / {{ $r['interval'] }}</td>
                            <td class="py-1.5">{{ $r['next_date'] }}</td>
                            <td class="py-1.5">{{ $r['next_fh_fc'] }}</td>
                            <td class="py-1.5">{{ $r['remaining_fh_fc'] }}</td>
                            <td class="py-1.5">{{ $r['remaining_days'] }}</td>
                            <td class="py-1.5">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
            <span>Showing 1 to {{ count($m['rows']) }} of 156 items</span>
            <span>Rows per page: 20</span>
        </div>
    </section>

    {{-- Legends --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Item Type Legend</h4>
            <ul class="space-y-1 text-[11px] text-gray-700">
                <li><span class="font-semibold">Visit</span> — Scheduled maintenance visit (A, C, etc.)</li>
                <li><span class="font-semibold">Task</span> — Maintenance task / inspection / check</li>
                <li><span class="font-semibold">Technical Publication</span> — Airworthiness directive / service bulletin</li>
                <li><span class="font-semibold">Defect (MEL)</span> — Minimum Equipment List deferred item</li>
            </ul>
        </section>
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Threshold / Interval Examples</h4>
            <ul class="space-y-1 text-[11px] text-gray-700">
                <li><span class="font-semibold">FH</span> — Flight Hours</li>
                <li><span class="font-semibold">FC</span> — Flight Cycles</li>
                <li><span class="font-semibold">MTH</span> — Months</li>
                <li><span class="font-semibold">DAYS</span> — Calendar Days</li>
                <li><span class="font-semibold">C Check (24 Months)</span> — Calendar-based check</li>
                <li><span class="font-semibold">600:00HRS / 12M</span> — Combined interval (whichever first)</li>
            </ul>
        </section>
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Notes</h4>
            <ul class="space-y-1 text-[11px] text-gray-700">
                <li>Maintenance Status is calculated based on the earliest next due.</li>
                <li>Remaining shows the minimum of FH, FC or Days (where applicable).</li>
                <li>All dates and times are in UTC.</li>
            </ul>
        </section>
    </div>
</div>
