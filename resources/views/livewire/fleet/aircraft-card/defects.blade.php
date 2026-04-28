@php
    $d = $data['defects'];
@endphp

<div class="space-y-3">
    {{-- Filters --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
        <div class="flex min-w-[1100px] items-center gap-1.5">
            <input type="text" placeholder="Search description, A.A. No, employee, part number..." class="input-field w-72 text-[11px]" />
            <select class="input-field w-24 text-[11px]"><option>All Type</option></select>
            <select class="input-field w-28 text-[11px]"><option>All MEL</option></select>
            <select class="input-field w-32 text-[11px]"><option>All Category</option></select>
            <input type="text" placeholder="From" class="input-field w-24 text-[11px]" />
            <input type="text" placeholder="To" class="input-field w-24 text-[11px]" />
            <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
            <button type="button" class="ml-auto inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="cog-6-tooth" class="h-3 w-3" /> Manage Defects
            </button>
        </div>
    </div>

    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <h3 class="mb-2 text-xs font-semibold text-gray-900">Defects ({{ count($d['rows']) }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1800px] text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                        <th class="py-1 pl-1.5" rowspan="2">Type</th>
                        <th class="py-1" rowspan="2">Date</th>
                        <th class="py-1" rowspan="2">Time</th>
                        <th class="py-1" rowspan="2">A/C Hours</th>
                        <th class="py-1" rowspan="2">A/C Cycles</th>
                        <th class="py-1" rowspan="2">A.A. No</th>
                        <th class="py-1" rowspan="2">Description</th>
                        <th class="py-1 text-center" colspan="2">Reported By</th>
                        <th class="py-1" rowspan="2">Action Taken</th>
                        <th class="py-1 text-center" colspan="2">Performed By</th>
                        <th class="py-1" rowspan="2">Defer</th>
                        <th class="py-1" rowspan="2">MEL Ref</th>
                        <th class="py-1" rowspan="2">MEL Cat</th>
                        <th class="py-1" rowspan="2">MEL Expiry</th>
                        <th class="py-1" rowspan="2">Reason</th>
                        <th class="py-1 text-center" colspan="4">Part Number / Qty / Description / Remarks</th>
                        <th class="py-1" rowspan="2">Defect Category</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left text-[10px] uppercase text-gray-500">
                        <th class="py-1">Name</th>
                        <th class="py-1">Auth.</th>
                        <th class="py-1">Name</th>
                        <th class="py-1">Auth.</th>
                        <th class="py-1">Part No.</th>
                        <th class="py-1">Qty</th>
                        <th class="py-1">Desc</th>
                        <th class="py-1">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($d['rows'] as $r)
                        <tr>
                            <td class="py-1 pl-1.5">
                                <span class="inline-flex items-center gap-1 rounded px-1 py-0.5 text-[10px] font-semibold {{ $r['tone'] === 'red' ? 'bg-red-100 text-red-800' : ($r['tone'] === 'amber' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }}">
                                    @if ($r['tone'] === 'red') <x-icon name="exclamation-triangle" class="h-3 w-3" />
                                    @elseif ($r['tone'] === 'amber') <x-icon name="bell" class="h-3 w-3" />
                                    @else <x-icon name="information-circle" class="h-3 w-3" />
                                    @endif
                                    {{ $r['type'] }}
                                </span>
                            </td>
                            <td class="py-1">{{ $r['date'] }}</td>
                            <td class="py-1">{{ $r['time'] }}</td>
                            <td class="py-1">{{ $r['aircraft_hours'] }}</td>
                            <td class="py-1">{{ $r['aircraft_cycles'] }}</td>
                            <td class="py-1">{{ $r['aa_no'] }}</td>
                            <td class="py-1 text-gray-700">{{ $r['description'] }}</td>
                            <td class="py-1">{{ $r['reported_by_name'] }}</td>
                            <td class="py-1">{{ $r['reported_by_auth'] }}</td>
                            <td class="py-1 text-gray-700">{{ $r['action_taken'] }}</td>
                            <td class="py-1">{{ $r['performed_by_name'] }}</td>
                            <td class="py-1">{{ $r['performed_by_auth'] }}</td>
                            <td class="py-1">{{ $r['deferral'] }}</td>
                            <td class="py-1">{{ $r['mel_ref'] }}</td>
                            <td class="py-1">
                                <span class="rounded px-1.5 py-0.5 text-[10px] font-semibold {{ $r['mel_repair_category'] === 'C' ? 'bg-blue-100 text-blue-800' : ($r['mel_repair_category'] === 'B' ? 'bg-amber-100 text-amber-800' : ($r['mel_repair_category'] === 'A' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700')) }}">{{ $r['mel_repair_category'] }}</span>
                            </td>
                            <td class="py-1">{{ $r['mel_expiry_date'] }}</td>
                            <td class="py-1">{{ $r['reason_for_deferral'] }}</td>
                            <td class="py-1">{{ $r['part_number'] }}</td>
                            <td class="py-1">{{ $r['qty'] }}</td>
                            <td class="py-1">{{ $r['description_short'] }}</td>
                            <td class="py-1">{{ $r['remarks'] }}</td>
                            <td class="py-1 text-gray-700">{{ $r['defect_category'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($d['rows']) }} of {{ count($d['rows']) }} items</span>
            <span>Rows per page: 20</span>
        </div>
    </section>

    {{-- Legends --}}
    <div class="overflow-x-auto">
        <div class="grid min-w-[900px] grid-cols-3 gap-3">
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Type Legend</h4>
                <ul class="space-y-1 text-[11px] text-gray-700">
                    <li class="flex items-center gap-2"><span class="inline-flex items-center gap-1 rounded bg-red-100 px-1 py-0.5 text-[10px] font-semibold text-red-800"><x-icon name="exclamation-triangle" class="h-3 w-3" /> MAREP</span> Maintenance Report</li>
                    <li class="flex items-center gap-2"><span class="inline-flex items-center gap-1 rounded bg-amber-100 px-1 py-0.5 text-[10px] font-semibold text-amber-800"><x-icon name="bell" class="h-3 w-3" /> PIREP</span> Pilot Report</li>
                    <li class="flex items-center gap-2"><span class="inline-flex items-center gap-1 rounded bg-gray-100 px-1 py-0.5 text-[10px] font-semibold text-gray-700"><x-icon name="information-circle" class="h-3 w-3" /> INFO</span> Informational Report</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">MEL Repair Category</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="rounded bg-red-100 px-1.5 py-0.5 text-[10px] font-semibold text-red-800">A</span> Major Defect</li>
                    <li><span class="rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-semibold text-amber-800">B</span> Significant Defect</li>
                    <li><span class="rounded bg-blue-100 px-1.5 py-0.5 text-[10px] font-semibold text-blue-800">C</span> Minor Defect</li>
                    <li><span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold text-gray-700">D</span> No Safety Effect</li>
                    <li><span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold text-gray-700">CFD</span> Configuration Deviation</li>
                </ul>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <h4 class="mb-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Defect Category Legend</h4>
                <ul class="space-y-0.5 text-[11px] text-gray-700">
                    <li><span class="rounded bg-red-50 px-1.5 py-0.5 text-red-700">MEL Item — mech action required</span></li>
                    <li><span class="rounded bg-amber-50 px-1.5 py-0.5 text-amber-700">MEL Item — planning required</span></li>
                    <li><span class="rounded bg-purple-50 px-1.5 py-0.5 text-purple-700">MEL Item — non-flight crew/maint action</span></li>
                    <li><span class="rounded bg-emerald-50 px-1.5 py-0.5 text-emerald-700">Non-Safety related item</span></li>
                    <li><span class="rounded bg-purple-50 px-1.5 py-0.5 text-purple-700">Transferred to/from Logbook</span></li>
                </ul>
            </section>
        </div>
    </div>
</div>
