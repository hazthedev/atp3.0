@php
    $m = $data['maintenance'];
@endphp

<div class="space-y-3">
    {{-- Top row --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[1200px] grid-cols-[1fr_320px_280px_240px] gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Maintenance Summary</div>
                <div class="grid grid-cols-5 gap-1.5">
                    @foreach ($m['summary'] as $tile)
                        @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Maintenance Status</div>
                @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($m['donut'], ['center_label' => 'Compliant', 'center_value' => $m['donut']['pct_compliant'] . '%'])])
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Maintenance Utilization (Since New)</div>
                <dl class="grid grid-cols-3 gap-2 text-center text-[11px]">
                    <div><dt class="text-[10px] text-gray-500">FH</dt><dd class="text-base font-bold text-gray-900">{{ $m['utilization']['fh'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">FC</dt><dd class="text-base font-bold text-gray-900">{{ $m['utilization']['fc'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Days</dt><dd class="text-base font-bold text-gray-900">{{ $m['utilization']['cal_days'] }}</dd></div>
                </dl>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Access Maintenance Planning</div>
                <p class="text-[10px] text-gray-500">View and manage planning data used to determine due tasks and compliance.</p>
                <a href="#" class="mt-2 inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="calendar-days" class="h-3 w-3" /> Go to Maintenance Planning →
                </a>
            </section>
        </div>
    </div>

    {{-- Filters --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
        <div class="flex min-w-[1100px] items-center gap-1.5">
            <input type="text" placeholder="Search by item reference, component, ATA chapter..." class="input-field w-64 text-[11px]" />
            <select class="input-field w-28 text-[11px]"><option>All Item Type</option></select>
            <select class="input-field w-28 text-[11px]"><option>All ATA Chapter</option></select>
            <select class="input-field w-36 text-[11px]"><option>All Maintenance Status</option></select>
            <input type="text" placeholder="From" class="input-field w-24 text-[11px]" />
            <input type="text" placeholder="To" class="input-field w-24 text-[11px]" />
            <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
            <button type="button" class="ml-auto inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="cog-6-tooth" class="h-3 w-3" /> Manage Maintenance
            </button>
        </div>
    </div>

    {{-- Items table --}}
    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <h3 class="mb-2 text-xs font-semibold text-gray-900">Maintenance Items ({{ $m['summary'][0]['value'] }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1500px] text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                        <th class="py-1 pl-1.5" rowspan="2">Item Type</th>
                        <th class="py-1" rowspan="2">Reference</th>
                        <th class="py-1" rowspan="2">Description</th>
                        <th class="py-1" rowspan="2">Component / System</th>
                        <th class="py-1 text-center" colspan="4">Last Done</th>
                        <th class="py-1" rowspan="2">Threshold / Interval</th>
                        <th class="py-1 text-center" colspan="4">Next Due</th>
                        <th class="py-1" rowspan="2">Maintenance Status</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left text-[10px] uppercase text-gray-500">
                        <th class="py-1">Date</th>
                        <th class="py-1">FH/FC</th>
                        <th class="py-1">Work Order</th>
                        <th class="py-1">Work Package</th>
                        <th class="py-1">Date</th>
                        <th class="py-1">FH/FC</th>
                        <th class="py-1">Remaining FH/FC</th>
                        <th class="py-1">Days</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($m['rows'] as $r)
                        <tr>
                            <td class="py-1 pl-1.5 font-medium text-gray-900">{{ $r['type'] }}</td>
                            <td class="py-1">{{ $r['reference'] }}</td>
                            <td class="py-1 text-gray-700">{{ $r['description'] }}</td>
                            <td class="py-1">{{ $r['component'] }}</td>
                            <td class="py-1">{{ $r['last_date'] }}</td>
                            <td class="py-1">{{ $r['last_fh_fc'] }}</td>
                            <td class="py-1">{{ $r['work_order'] }}</td>
                            <td class="py-1">{{ $r['work_package'] }}</td>
                            <td class="py-1">{{ $r['threshold'] }} / {{ $r['interval'] }}</td>
                            <td class="py-1">{{ $r['next_date'] }}</td>
                            <td class="py-1">{{ $r['next_fh_fc'] }}</td>
                            <td class="py-1">{{ $r['remaining_fh_fc'] }}</td>
                            <td class="py-1">{{ $r['remaining_days'] }}</td>
                            <td class="py-1">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($m['rows']) }} of 156 items</span>
            <span>Rows per page: 20</span>
        </div>
    </section>

    {{-- Legends --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[900px] grid-cols-3 gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Item Type Legend</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="font-semibold">Visit</span> — Scheduled maintenance visit (A, C, etc.)</li>
                    <li><span class="font-semibold">Task</span> — Maintenance task / inspection / check</li>
                    <li><span class="font-semibold">Tech Pub</span> — Airworthiness directive / service bulletin</li>
                    <li><span class="font-semibold">Defect (MEL)</span> — Minimum Equipment List deferred item</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Threshold / Interval Examples</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="font-semibold">FH</span> — Flight Hours · <span class="font-semibold">FC</span> — Flight Cycles</li>
                    <li><span class="font-semibold">MTH / DAYS</span> — Calendar interval</li>
                    <li><span class="font-semibold">C Check (24M)</span> — Calendar-based check</li>
                    <li><span class="font-semibold">600:00HRS / 12M</span> — Combined (whichever first)</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Notes</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li>Maintenance Status is calculated based on the earliest next due.</li>
                    <li>Remaining shows the minimum of FH, FC or Days.</li>
                    <li>All dates and times are in UTC.</li>
                </ul>
            </section>
        </div>
    </div>
</div>
