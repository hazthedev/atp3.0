@php
    $tp = $data['technical_publications'];
@endphp

<div class="space-y-4">
    {{-- Top row --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_320px_320px_280px]">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Publications Summary</div>
            <div class="grid grid-cols-4 gap-2">
                @foreach ($tp['summary'] as $tile)
                    @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Compliance Status</div>
            @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($tp['donut'], ['center_label' => 'Compliant', 'center_value' => $tp['donut']['pct_compliant'] . '%'])])
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Publication Coverage</div>
            <ul class="space-y-2 text-xs">
                @foreach ($tp['coverage'] as $row)
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">{{ $row['label'] }}</span>
                        <span class="font-semibold text-gray-900">{{ $row['value'] }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Access Maintenance Planning</div>
            <p class="text-[11px] text-gray-500">View and manage the maintenance planning data used to determine publication thresholds and compliance.</p>
            <a href="#" class="mt-3 inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="calendar-days" class="h-3.5 w-3.5" /> Go to Maintenance Planning →
            </a>
        </section>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
        <input type="text" placeholder="Search by reference, title or subtitle..." class="input-field w-72 text-xs" />
        <select class="input-field w-32 text-xs"><option>All Publication Type</option></select>
        <select class="input-field w-36 text-xs"><option>All Compliance Status</option></select>
        <select class="input-field w-32 text-xs"><option>All ATA Chapter</option></select>
        <select class="input-field w-32 text-xs"><option>All Task Card</option></select>
        <select class="input-field w-32 text-xs"><option>All Source</option></select>
        <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
        <div class="ml-auto flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="cog-6-tooth" class="h-3.5 w-3.5" /> Manage Publications
            </button>
            <button type="button" class="inline-flex items-center gap-1.5 rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">
                View / Record Compliance
            </button>
        </div>
    </div>

    {{-- Publications table --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-sm font-semibold text-gray-900">Technical Publications ({{ $tp['summary'][0]['value'] }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                        <th class="py-1.5 pl-2" rowspan="2">Reference</th>
                        <th class="py-1.5" rowspan="2">Type</th>
                        <th class="py-1.5" rowspan="2">Title</th>
                        <th class="py-1.5" rowspan="2">Subtitle</th>
                        <th class="py-1.5" rowspan="2">ATA Chapter</th>
                        <th class="py-1.5" rowspan="2">Threshold / Interval</th>
                        <th class="py-1.5 text-center" colspan="3">Last Compliance</th>
                        <th class="py-1.5 text-center" colspan="2">Next Compliance</th>
                        <th class="py-1.5" rowspan="2">Method of Compliance</th>
                        <th class="py-1.5" rowspan="2">Compliance Status</th>
                        <th class="py-1.5" rowspan="2">Source</th>
                        <th class="py-1.5" rowspan="2">Revision</th>
                        <th class="py-1.5" rowspan="2">ER Date</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left uppercase text-gray-500">
                        <th class="py-1.5">Date</th>
                        <th class="py-1.5">Aircraft Hours / Cycles</th>
                        <th class="py-1.5">WO / Package</th>
                        <th class="py-1.5">Date</th>
                        <th class="py-1.5">Aircraft Hours / Cycles</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tp['rows'] as $r)
                        <tr>
                            <td class="py-1.5 pl-2 font-medium text-gray-900">{{ $r['reference'] }}</td>
                            <td class="py-1.5"><span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold">{{ $r['type'] }}</span></td>
                            <td class="py-1.5 text-gray-700">{{ $r['title'] }}</td>
                            <td class="py-1.5 text-gray-600">{{ $r['subtitle'] }}</td>
                            <td class="py-1.5">{{ $r['ata_chapter'] }}</td>
                            <td class="py-1.5">{{ $r['threshold'] }}</td>
                            <td class="py-1.5">{{ $r['last_date'] }}</td>
                            <td class="py-1.5">{{ $r['last_fh_fc'] }}</td>
                            <td class="py-1.5">{{ $r['wp_no'] }}</td>
                            <td class="py-1.5">{{ $r['next_date'] }}</td>
                            <td class="py-1.5">{{ $r['next_fh_fc'] }}</td>
                            <td class="py-1.5">{{ $r['method'] }}</td>
                            <td class="py-1.5">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                            <td class="py-1.5">{{ $r['source'] }}</td>
                            <td class="py-1.5">{{ $r['revision'] }}</td>
                            <td class="py-1.5">{{ $r['er_date'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
            <span>Showing 1 to {{ count($tp['rows']) }} of 142 publications</span>
            <span>Rows per page: 20</span>
        </div>
    </section>

    {{-- Legends --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Publication Types</h4>
            <ul class="space-y-1 text-[11px] text-gray-700">
                <li><span class="font-semibold">AMM</span> — Aircraft Maintenance Manual</li>
                <li><span class="font-semibold">SL</span> — Service Information Letter</li>
                <li><span class="font-semibold">SB</span> — Service Bulletin</li>
                <li><span class="font-semibold">AD</span> — Airworthiness Directive</li>
                <li><span class="font-semibold">WDM</span> — Wiring Diagram Manual</li>
            </ul>
        </section>
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Method of Compliance</h4>
            <ul class="space-y-1 text-[11px] text-gray-700">
                <li><span class="font-semibold">Inspection</span> — Physical inspection required</li>
                <li><span class="font-semibold">Modification</span> — Incorporate modification</li>
                <li><span class="font-semibold">Replacement</span> — Replace component / part</li>
                <li><span class="font-semibold">Test</span> — Functional test / operational check</li>
                <li><span class="font-semibold">Reference</span> — No action required</li>
            </ul>
        </section>
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Compliance Status (Legend)</h4>
            <ul class="space-y-1 text-[11px] text-gray-700">
                <li><span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span> Compliant — Task is compliant</li>
                <li><span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span> Due Within 30 Days — Compliance due within 30 days</li>
                <li><span class="inline-block h-2 w-2 rounded-full bg-red-500"></span> Overdue — Compliance is overdue</li>
                <li><span class="inline-block h-2 w-2 rounded-full bg-gray-400"></span> Not Applicable — Task not applicable</li>
            </ul>
        </section>
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h4 class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Quick Links</h4>
            <ul class="space-y-1.5 text-xs">
                <li><a href="#" class="text-blue-600 hover:underline">View Maintenance Plan (MPD)</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">View Effectivity</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">Publication Compliance Report</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">Export Publication List</a></li>
            </ul>
        </section>
    </div>
</div>
