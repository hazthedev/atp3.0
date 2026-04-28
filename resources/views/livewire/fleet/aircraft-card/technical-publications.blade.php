@php
    $tp = $data['technical_publications'];
@endphp

<div class="space-y-3">
    {{-- Top row --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[1200px] grid-cols-[1fr_300px_280px_240px] gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Publications Summary</div>
                <div class="grid grid-cols-4 gap-1.5">
                    @foreach ($tp['summary'] as $tile)
                        @include('livewire.fleet.aircraft-card._summary-tile', $tile)
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Compliance Status</div>
                @include('livewire.fleet.aircraft-card._donut', ['donut' => array_merge($tp['donut'], ['center_label' => 'Compliant', 'center_value' => $tp['donut']['pct_compliant'] . '%'])])
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Publication Coverage</div>
                <ul class="space-y-1 text-[11px]">
                    @foreach ($tp['coverage'] as $row)
                        <li class="flex items-center justify-between">
                            <span class="text-gray-700">{{ $row['label'] }}</span>
                            <span class="font-semibold text-gray-900">{{ $row['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <div class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Access Maintenance Planning</div>
                <p class="text-[10px] text-gray-500">View and manage planning data used to determine publication thresholds.</p>
                <a href="#" class="mt-2 inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="calendar-days" class="h-3 w-3" /> Go to Maintenance Planning →
                </a>
            </section>
        </div>
    </div>

    {{-- Filters --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
        <div class="flex min-w-[1100px] items-center gap-1.5">
            <input type="text" placeholder="Search by reference, title or subtitle..." class="input-field w-64 text-[11px]" />
            <select class="input-field w-28 text-[11px]"><option>All Type</option></select>
            <select class="input-field w-32 text-[11px]"><option>All Compliance</option></select>
            <select class="input-field w-28 text-[11px]"><option>All ATA</option></select>
            <select class="input-field w-28 text-[11px]"><option>All Task Card</option></select>
            <select class="input-field w-28 text-[11px]"><option>All Source</option></select>
            <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
            <div class="ml-auto flex items-center gap-1.5">
                <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="cog-6-tooth" class="h-3 w-3" /> Manage Publications
                </button>
                <button type="button" class="inline-flex items-center gap-1 rounded bg-blue-600 px-2 py-1 text-[11px] font-semibold text-white hover:bg-blue-700">View / Record Compliance</button>
            </div>
        </div>
    </div>

    {{-- Publications table --}}
    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <h3 class="mb-2 text-xs font-semibold text-gray-900">Technical Publications ({{ $tp['summary'][0]['value'] }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1500px] text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                        <th class="py-1 pl-1.5" rowspan="2">Reference</th>
                        <th class="py-1" rowspan="2">Type</th>
                        <th class="py-1" rowspan="2">Title</th>
                        <th class="py-1" rowspan="2">Subtitle</th>
                        <th class="py-1" rowspan="2">ATA</th>
                        <th class="py-1" rowspan="2">Threshold / Interval</th>
                        <th class="py-1 text-center" colspan="3">Last Compliance</th>
                        <th class="py-1 text-center" colspan="2">Next Compliance</th>
                        <th class="py-1" rowspan="2">Method</th>
                        <th class="py-1" rowspan="2">Status</th>
                        <th class="py-1" rowspan="2">Source</th>
                        <th class="py-1" rowspan="2">Revision</th>
                        <th class="py-1" rowspan="2">ER Date</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left text-[10px] uppercase text-gray-500">
                        <th class="py-1">Date</th>
                        <th class="py-1">FH/FC</th>
                        <th class="py-1">WO / Pkg</th>
                        <th class="py-1">Date</th>
                        <th class="py-1">FH/FC</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tp['rows'] as $r)
                        <tr>
                            <td class="py-1 pl-1.5 font-medium text-gray-900">{{ $r['reference'] }}</td>
                            <td class="py-1"><span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold">{{ $r['type'] }}</span></td>
                            <td class="py-1 text-gray-700">{{ $r['title'] }}</td>
                            <td class="py-1 text-gray-600">{{ $r['subtitle'] }}</td>
                            <td class="py-1">{{ $r['ata_chapter'] }}</td>
                            <td class="py-1">{{ $r['threshold'] }}</td>
                            <td class="py-1">{{ $r['last_date'] }}</td>
                            <td class="py-1">{{ $r['last_fh_fc'] }}</td>
                            <td class="py-1">{{ $r['wp_no'] }}</td>
                            <td class="py-1">{{ $r['next_date'] }}</td>
                            <td class="py-1">{{ $r['next_fh_fc'] }}</td>
                            <td class="py-1">{{ $r['method'] }}</td>
                            <td class="py-1">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                            <td class="py-1">{{ $r['source'] }}</td>
                            <td class="py-1">{{ $r['revision'] }}</td>
                            <td class="py-1">{{ $r['er_date'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($tp['rows']) }} of 142 publications</span>
            <span>Rows per page: 20</span>
        </div>
    </section>

    {{-- Legends --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[1100px] grid-cols-4 gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Publication Types</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="font-semibold">AMM</span> — Aircraft Maintenance Manual</li>
                    <li><span class="font-semibold">SL</span> — Service Information Letter</li>
                    <li><span class="font-semibold">SB</span> — Service Bulletin</li>
                    <li><span class="font-semibold">AD</span> — Airworthiness Directive</li>
                    <li><span class="font-semibold">WDM</span> — Wiring Diagram Manual</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Method of Compliance</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="font-semibold">Inspection</span> — Physical inspection required</li>
                    <li><span class="font-semibold">Modification</span> — Incorporate modification</li>
                    <li><span class="font-semibold">Replacement</span> — Replace component / part</li>
                    <li><span class="font-semibold">Test</span> — Functional / operational check</li>
                    <li><span class="font-semibold">Reference</span> — No action required</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Compliance Status (Legend)</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span> Compliant</li>
                    <li><span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span> Due Within 30 Days</li>
                    <li><span class="inline-block h-2 w-2 rounded-full bg-red-500"></span> Overdue</li>
                    <li><span class="inline-block h-2 w-2 rounded-full bg-gray-400"></span> Not Applicable</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Quick Links</h4>
                <ul class="space-y-1 text-[11px]">
                    <li><a href="#" class="text-blue-600 hover:underline">View Maintenance Plan (MPD)</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">View Effectivity</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Publication Compliance Report</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Export Publication List</a></li>
                </ul>
            </section>
        </div>
    </div>
</div>
