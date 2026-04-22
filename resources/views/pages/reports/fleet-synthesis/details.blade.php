@extends('layouts.app')

@section('title', 'Fleet Synthesis — Details')

@php
    $rows = [
        [
            'alarm' => 'red', 'reg' => '9M-WAD', 'type' => 'OOP',
            'reference' => 'AW139 CPI – ADDITIONAL 1', 'description' => 'Corrosion Prevention Inspection — Additional 1',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '12 M',
            'last_date' => '13.08.2020', 'last_hours' => '12695:51 Hours', 'last_cycles' => '19480 Cycles', 'wo_number' => 'WO-23121',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => '-1.33 Months', 'deadline_ac' => '13.09.2020',
            'due_date' => '13.09.2020', 'work_package' => '000008L2', 'wo' => 'WO-24247', 'date_in' => '18.09.2020',
            'notes' => '1 MONTH',
        ],
        [
            'alarm' => 'red', 'reg' => '9M-WAD', 'type' => 'OOP',
            'reference' => 'AW139 CPI- ADDITIONAL 2', 'description' => 'Corrosion Prevention Inspection — Additional 2',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '12 M',
            'last_date' => '13.08.2020', 'last_hours' => '12695:51 Hours', 'last_cycles' => '19480 Cycles', 'wo_number' => 'WO-23120',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => '-1.33 Months', 'deadline_ac' => '13.09.2020',
            'due_date' => '13.09.2020', 'work_package' => '000008L2', 'wo' => 'WO-24246', 'date_in' => '18.09.2020',
            'notes' => '1 MONTH',
        ],
        [
            'alarm' => 'red', 'reg' => '9M-WBB', 'type' => 'AD/SB',
            'reference' => 'AW139 SB 139-594 PART II', 'description' => 'INSPECTION OF MAIN LANDING GEAR ACTUATOR BOLTS PART II',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '200:00 Hours / 400 Cycles',
            'last_date' => '', 'last_hours' => '', 'last_cycles' => '', 'wo_number' => '',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => "-27:21 Minutes\n223 Cycles", 'deadline_ac' => "1562:50 Hours\n3704 Cycles",
            'due_date' => '15.09.2020', 'work_package' => '000008SX', 'wo' => '', 'date_in' => '',
            'notes' => '',
        ],
        [
            'alarm' => 'red', 'reg' => '9M-WAD', 'type' => 'Others',
            'reference' => 'EOAS AW139/EOAS/369', 'description' => 'AW139 Automatic Flight Control System Wiring Check',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '1 Year',
            'last_date' => '', 'last_hours' => '', 'last_cycles' => '', 'wo_number' => '',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => '-0.1 Year', 'deadline_ac' => '18.09.2020',
            'due_date' => '18.09.2020', 'work_package' => '0000072M', 'wo' => 'WO-23292', 'date_in' => '30.07.2020',
            'notes' => '',
        ],
        [
            'alarm' => 'red', 'reg' => '9M-WAD', 'type' => 'AD/SB',
            'reference' => 'AW139 SB SB139-642 Part I', 'description' => 'SB139-642 Part I - ATA 64 – TAIL ROTOR HEAD INSPECTION AND MODIFICATION',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '50:00 Hours / 3 Months',
            'last_date' => '', 'last_hours' => '', 'last_cycles' => '', 'wo_number' => '',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => "16:16 Hours\n-0.27 Months", 'deadline_ac' => "12720:12 Hours\n15.10.20",
            'due_date' => '15.10.2020', 'work_package' => '000007XI', 'wo' => 'WO-23210', 'date_in' => '23.07.2020',
            'notes' => '',
        ],
        [
            'alarm' => 'orange', 'reg' => '9M-WSV', 'type' => 'Checks',
            'reference' => 'AW189 200FH', 'description' => 'AW189 200FH',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '200:00 Hours',
            'last_date' => '06.05.2020', 'last_hours' => '1963:13 Hours', 'last_cycles' => '', 'wo_number' => 'WO-20861',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => '45:10 Hours', 'deadline_ac' => '2163:13 Hours',
            'due_date' => '04.11.2020', 'work_package' => '', 'wo' => '', 'date_in' => '',
            'notes' => '200:00 HRS',
        ],
        [
            'alarm' => 'orange', 'reg' => '9M-WSV', 'type' => 'EOAS',
            'reference' => 'AW189 ENG 200HRS', 'description' => 'AW189 Engine 200-Hour Inspection',
            'pn' => '', 'sn' => '', 'category' => '',
            'threshold' => '', 'interval' => '200:00 Hours',
            'last_date' => '06.05.2020', 'last_hours' => '1963:13 Hours', 'last_cycles' => '', 'wo_number' => 'WO-20862',
            'remaining' => '', 'deadline' => '',
            'remaining_ac' => '45:10 Hours', 'deadline_ac' => '2163:13 Hours',
            'due_date' => '04.11.2020', 'work_package' => '', 'wo' => '', 'date_in' => '',
            'notes' => "200:00 HRS\nENG",
        ],
        [
            'alarm' => 'green', 'reg' => '9M-WAD', 'type' => 'Kardex',
            'reference' => 'AW139 DUKANE T.M.', 'description' => 'underwater acoustic beacon',
            'pn' => 'DK120', 'sn' => 'SD59337', 'category' => 'H/T LLP',
            'threshold' => '', 'interval' => '6 Years',
            'last_date' => '20.06.2020', 'last_hours' => '12613:41 Hours', 'last_cycles' => '19383 Cycles', 'wo_number' => 'WO-21814',
            'remaining' => '1.93 Months', 'deadline' => '20.12.2020',
            'remaining_ac' => '1.93 Months', 'deadline_ac' => '20.12.2020',
            'due_date' => '20.12.2020', 'work_package' => '000008LD', 'wo' => '', 'date_in' => '',
            'notes' => '',
        ],
    ];

    $alarmClasses = [
        'red'    => 'bg-red-600',
        'orange' => 'bg-amber-500',
        'green'  => 'bg-emerald-500',
    ];

    $total = count($rows);
@endphp

@section('content')
    <div
        class="space-y-5"
        x-data="fleetSynthesisDetails({ total: {{ $total }} })"
    >
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-600">Fleet Synthesis</p>
                <h2 class="text-2xl font-bold text-gray-900">Details <span class="text-gray-400 font-normal">(<span x-text="total"></span>)</span></h2>
                <p class="max-w-3xl text-sm text-gray-500">Flat list of every Visit, Task List and Technical Log matching the current filter.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.fleet-synthesis') }}" class="btn-ghost">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                    Back
                </a>
                <button type="button" class="btn-secondary" @click="refresh()" :disabled="refreshing">
                    <svg x-show="refreshing" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity=".25"/><path d="M4 12a8 8 0 018-8"/></svg>
                    <x-icon name="arrow-path" x-show="!refreshing" class="h-4 w-4" /> Refresh
                </button>
                <div class="relative" @click.outside="openReport = false">
                    <button type="button" class="btn-primary" @click="openReport = !openReport">
                        <x-icon name="document-arrow-down" class="h-4 w-4" /> Report
                    </button>
                    <div x-cloak x-show="openReport" x-transition
                         class="absolute right-0 z-30 mt-2 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500">
                            <span>File Name</span>
                            <span>Format</span>
                        </div>
                        <div class="flex items-center justify-between gap-3 px-4 py-2.5 text-sm">
                            <span class="text-gray-700">Fleet Synthesis – Details</span>
                            <span class="text-xs text-gray-400">XLS</span>
                            <button class="btn-secondary !py-1 !text-xs" @click="alert('Generate XLS — mockup')">Generate</button>
                        </div>
                        <div class="flex items-center justify-between gap-3 border-t border-gray-100 px-4 py-2.5 text-sm">
                            <span class="text-gray-700">Maintenance Forecast</span>
                            <span class="text-xs text-gray-400">PDF</span>
                            <button class="btn-secondary !py-1 !text-xs" @click="alert('Generate PDF — mockup')">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm md:flex-row md:items-center md:justify-between">
            <div class="relative max-w-md flex-1">
                <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input type="text" class="input-field pl-9" placeholder="Type to filter the table below" x-model="search" />
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <template x-if="selectedCount > 0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700" x-text="selectedCount + ' selected'"></span>
                        <button class="btn-ghost !text-xs" @click="alert('Maintenance Plan — mockup')" x-show="selectedCount === 1">Maintenance Plan</button>
                        <button class="btn-ghost !text-xs" @click="alert('Update Task — mockup')" x-show="selectedCount === 1">Update Task</button>
                        <button class="btn-ghost !text-xs" @click="alert('Application History — mockup')" x-show="selectedCount === 1">Application History</button>
                        <button class="btn-secondary !text-xs" @click="alert('Create WP — mockup')">Create WP</button>
                        <button class="btn-secondary !text-xs" @click="alert('Include into WP — mockup')">Include into WP</button>
                    </div>
                </template>

                <button class="btn-ghost" @click="openFilter = !openFilter" :class="openFilter && '!bg-gray-100'">
                    <x-icon name="sliders-h" class="h-4 w-4" /> Filter
                </button>
            </div>
        </div>

        {{-- Filter dropdown --}}
        <div x-cloak x-show="openFilter" x-transition class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Selection</label>
                    <div class="flex gap-4 text-sm">
                        <label class="inline-flex items-center gap-1.5"><input type="checkbox" checked class="rounded text-blue-600 focus:ring-blue-500"> Selected</label>
                        <label class="inline-flex items-center gap-1.5"><input type="checkbox" checked class="rounded text-blue-600 focus:ring-blue-500"> Not selected</label>
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Work Package</label>
                    <div class="flex gap-4 text-sm">
                        <label class="inline-flex items-center gap-1.5"><input type="checkbox" checked class="rounded text-blue-600 focus:ring-blue-500"> In WP</label>
                        <label class="inline-flex items-center gap-1.5"><input type="checkbox" checked class="rounded text-blue-600 focus:ring-blue-500"> Not in WP</label>
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">A/C Registration</label>
                    <select class="input-field"><option>All</option><option>9M-WAD</option><option>9M-WBB</option><option>9M-WSV</option></select>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">PN</label>
                    <select class="input-field"><option>All</option><option>DK120</option></select>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">SN (free text)</label>
                    <input class="input-field" placeholder="e.g. SD59337" />
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Reference (free text)</label>
                    <input class="input-field" placeholder="e.g. AW139 CPI" />
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button class="btn-ghost" @click="openFilter = false">Reset</button>
                <button class="btn-primary" @click="openFilter = false">Filter</button>
            </div>
        </div>

        {{-- Table --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-max border-separate border-spacing-0 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500">
                            {{-- Frozen columns --}}
                            <th class="sticky left-0 z-20 w-10 bg-slate-50 px-3 py-3"></th>
                            <th class="sticky left-10 z-20 bg-slate-50 px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Alarm</th>
                            <th class="sticky left-[92px] z-20 bg-slate-50 px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">A/C Reg.</th>
                            <th class="sticky left-[180px] z-20 bg-slate-50 px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Type</th>
                            <th class="sticky left-[250px] z-20 border-r border-gray-200 bg-slate-50 px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Reference</th>

                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Description</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">PN</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">SN</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Category Part</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Threshold</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Interval</th>
                            <th class="px-3 py-3 text-center text-[11px] font-semibold uppercase tracking-wider" colspan="2">Last Action</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Remaining</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Deadline</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Remaining A/C</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Deadline A/C</th>
                            <th class="px-3 py-3 text-center text-[11px] font-semibold uppercase tracking-wider" colspan="4">Next Due</th>
                            <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider">Notes</th>
                        </tr>
                        <tr class="bg-slate-100 text-slate-500">
                            <th class="sticky left-0 z-20 bg-slate-100 px-3 py-2"></th>
                            <th class="sticky left-10 z-20 bg-slate-100 px-3 py-2"></th>
                            <th class="sticky left-[92px] z-20 bg-slate-100 px-3 py-2"></th>
                            <th class="sticky left-[180px] z-20 bg-slate-100 px-3 py-2"></th>
                            <th class="sticky left-[250px] z-20 border-r border-gray-200 bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="px-2 py-2 text-center text-[10px] font-medium uppercase">App. Date / Hours / Cycles</th>
                            <th class="px-2 py-2 text-center text-[10px] font-medium uppercase">WO Number</th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                            <th class="px-2 py-2 text-center text-[10px] font-medium uppercase">Due Date</th>
                            <th class="px-2 py-2 text-center text-[10px] font-medium uppercase">Work Package</th>
                            <th class="px-2 py-2 text-center text-[10px] font-medium uppercase">WO</th>
                            <th class="px-2 py-2 text-center text-[10px] font-medium uppercase">Date In</th>
                            <th class="bg-slate-100 px-3 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $i => $row)
                            <tr class="border-b border-gray-100 hover:bg-blue-50/40" :class="selected[{{ $i }}] && 'bg-blue-50'">
                                <td class="sticky left-0 z-10 bg-white px-3 py-3">
                                    <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500" x-model="selected[{{ $i }}]" @change="recount()" />
                                </td>
                                <td class="sticky left-10 z-10 bg-white px-3 py-3">
                                    <span class="inline-block h-6 w-8 rounded {{ $alarmClasses[$row['alarm']] }} shadow-sm"></span>
                                </td>
                                <td class="sticky left-[92px] z-10 bg-white px-3 py-3">
                                    <a href="#" class="font-medium text-blue-600 hover:underline">{{ $row['reg'] }}</a>
                                </td>
                                <td class="sticky left-[180px] z-10 bg-white px-3 py-3 text-gray-700">{{ $row['type'] }}</td>
                                <td class="sticky left-[250px] z-10 border-r border-gray-200 bg-white px-3 py-3 font-medium text-gray-800">{{ $row['reference'] }}</td>

                                <td class="px-3 py-3 text-gray-700">{{ $row['description'] }}</td>
                                <td class="px-3 py-3">
                                    @if ($row['pn']) <a href="#" class="text-blue-600 hover:underline">{{ $row['pn'] }}</a> @endif
                                </td>
                                <td class="px-3 py-3">
                                    @if ($row['sn']) <a href="#" class="text-blue-600 hover:underline">{{ $row['sn'] }}</a> @endif
                                </td>
                                <td class="px-3 py-3 text-gray-700">{{ $row['category'] }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $row['threshold'] }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $row['interval'] }}</td>
                                <td class="px-3 py-3 text-gray-700 whitespace-pre-line text-xs leading-tight">{{ trim($row['last_date']."\n".$row['last_hours']."\n".$row['last_cycles']) }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $row['wo_number'] }}</td>
                                <td class="px-3 py-3 text-gray-700 whitespace-pre-line">{{ $row['remaining'] }}</td>
                                <td class="px-3 py-3 text-gray-700 whitespace-pre-line">{{ $row['deadline'] }}</td>
                                <td class="px-3 py-3 whitespace-pre-line {{ str_starts_with($row['remaining_ac'], '-') ? 'text-red-600 font-medium' : 'text-gray-700' }}">{{ $row['remaining_ac'] }}</td>
                                <td class="px-3 py-3 text-gray-700 whitespace-pre-line">{{ $row['deadline_ac'] }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $row['due_date'] }}</td>
                                <td class="px-3 py-3">
                                    @if ($row['work_package']) <a href="#" class="text-blue-600 hover:underline">{{ $row['work_package'] }}</a> @endif
                                </td>
                                <td class="px-3 py-3">
                                    @if ($row['wo']) <a href="#" class="text-blue-600 hover:underline">{{ $row['wo'] }}</a> @endif
                                </td>
                                <td class="px-3 py-3 text-gray-700">{{ $row['date_in'] }}</td>
                                <td class="px-3 py-3 text-gray-700 whitespace-pre-line text-xs">{{ $row['notes'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <footer class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 px-6 py-3 text-xs text-gray-500">
                <span>First 5 columns are frozen (checkbox · alarm · A/C Reg · Type · Reference). Horizontal scroll for the rest.</span>
                <span class="text-gray-400">Dummy data · CAM-FS-0140</span>
            </footer>
        </section>
    </div>

    <script>
        function fleetSynthesisDetails(config) {
            return {
                total: config.total,
                selected: {},
                selectedCount: 0,
                search: '',
                openFilter: false,
                openReport: false,
                refreshing: false,
                recount() {
                    this.selectedCount = Object.values(this.selected).filter(Boolean).length;
                },
                refresh() {
                    this.refreshing = true;
                    setTimeout(() => this.refreshing = false, 900);
                },
            };
        }
    </script>
@endsection
