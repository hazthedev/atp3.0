@php
    $jl = $data['journey_logs'];
    $log = $jl['selected_log'];
@endphp

<div class="space-y-3">
    {{-- Logs table --}}
    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <div class="mb-2 flex items-center justify-between">
            <h3 class="text-xs font-semibold text-gray-900">Journey Logs ({{ count($jl['rows']) }})</h3>
            <div class="flex items-center gap-1.5">
                <input type="text" placeholder="Search by Log No..." class="input-field w-48 text-[11px]" />
                <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
                <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="document-arrow-down" class="h-3 w-3" /> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px] text-[11px]">
                <thead class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="py-1 pl-1.5 w-7"></th>
                        <th class="py-1">Log No.</th>
                        <th class="py-1">Date</th>
                        <th class="py-1">Time</th>
                        <th class="py-1">Sec.</th>
                        <th class="py-1">FH (Bef.)</th>
                        <th class="py-1">FC (Bef.)</th>
                        <th class="py-1">Total FH</th>
                        <th class="py-1">Total FC</th>
                        <th class="py-1">Eng Start</th>
                        <th class="py-1">APU Hrs</th>
                        <th class="py-1">FH (Aft.)</th>
                        <th class="py-1">FC (Aft.)</th>
                        <th class="py-1">Status</th>
                        <th class="py-1">Penalties</th>
                        <th class="py-1">Defects</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($jl['rows'] as $r)
                        <tr class="{{ ($r['selected'] ?? false) ? 'bg-blue-50' : '' }}">
                            <td class="py-1 pl-1.5 text-center"><input type="radio" name="selected_log" {{ ($r['selected'] ?? false) ? 'checked' : '' }} class="h-3 w-3"></td>
                            <td class="py-1 font-medium text-gray-900">{{ $r['no'] }}</td>
                            <td class="py-1">{{ $r['date'] }}</td>
                            <td class="py-1">{{ $r['time'] }}</td>
                            <td class="py-1">{{ $r['sectors'] }}</td>
                            <td class="py-1">{{ $r['total_fh_before'] }}</td>
                            <td class="py-1">{{ $r['total_fc_before'] }}</td>
                            <td class="py-1">{{ $r['total_fh'] }}</td>
                            <td class="py-1">{{ $r['total_fc'] }}</td>
                            <td class="py-1">{{ $r['total_engine_start'] }}</td>
                            <td class="py-1">{{ $r['total_apu_hours'] }}</td>
                            <td class="py-1">{{ $r['total_fh_after'] }}</td>
                            <td class="py-1">{{ $r['total_fc_after'] }}</td>
                            <td class="py-1">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                            <td class="py-1 text-amber-700">{{ $r['penalties'] }}</td>
                            <td class="py-1">{{ $r['defect_raised'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($jl['rows']) }} of 156 journey logs</span>
            <span>Rows per page: 10</span>
        </div>
    </section>

    {{-- Selected log details --}}
    <section class="space-y-2 rounded-lg border border-blue-200 bg-blue-50/30 p-2 shadow-sm">
        <h3 class="px-1 text-xs font-bold text-blue-900">Journey Log Details — {{ $jl['selected_log_no'] }}</h3>

        {{-- 1. Flight Details --}}
        <div class="rounded border border-gray-200 bg-white p-2.5">
            <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">1</span> Flight Details</h4>
            <div class="overflow-x-auto">
                <dl class="grid min-w-[1100px] grid-cols-12 gap-2 text-[11px]">
                    <div><dt class="text-[10px] text-gray-500">Flight No.</dt><dd class="font-medium">{{ $log['flight_details']['flight_no'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">From</dt><dd class="font-medium">{{ $log['flight_details']['from'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">To</dt><dd class="font-medium">{{ $log['flight_details']['to'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Rotor Start</dt><dd class="font-medium">{{ $log['flight_details']['rotor_start'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Duration</dt><dd class="font-medium">{{ $log['flight_details']['duration'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Sectors</dt><dd class="font-medium">{{ $log['flight_details']['sectors'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Landing</dt><dd class="font-medium">{{ $log['flight_details']['landing'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Rotor Stop</dt><dd class="font-medium">{{ $log['flight_details']['rotor_stop'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Eng. Start</dt><dd class="font-medium">{{ $log['flight_details']['engine_start'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Landings</dt><dd class="font-medium">{{ $log['flight_details']['landings'] }}</dd></div>
                    <div><dt class="text-[10px] text-gray-500">Arrival Fuel</dt><dd class="font-medium">{{ $log['flight_details']['arrival_fuel'] ? '✓' : '—' }}</dd></div>
                    <div>
                        <dt class="text-[10px] text-gray-500">Penalties (if applicable)</dt>
                        <dd class="flex flex-wrap gap-1 text-[10px]">
                            <label class="inline-flex items-center gap-0.5"><input type="checkbox" class="h-2.5 w-2.5"> 30&lt;V&lt;45</label>
                            <label class="inline-flex items-center gap-0.5"><input type="checkbox" class="h-2.5 w-2.5"> 47&lt;V&lt;60</label>
                            <label class="inline-flex items-center gap-0.5"><input type="checkbox" class="h-2.5 w-2.5"> CAT A TRG</label>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- 2/3/4: PIC + Fuel Log + Aircraft Rate --}}
        <div class="overflow-x-auto">
            <div class="grid min-w-[1100px] grid-cols-3 gap-2">
                <div class="rounded border border-gray-200 bg-white p-2.5">
                    <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">2</span> Pilot In-Command</h4>
                    <dl class="grid grid-cols-2 gap-2 text-[11px]">
                        <div><dt class="text-[10px] text-gray-500">Rank / Name</dt><dd class="font-medium">{{ $log['pic']['rank_name'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Service License No.</dt><dd class="font-medium">{{ $log['pic']['service_license_number'] }}</dd></div>
                    </dl>
                </div>
                <div class="rounded border border-gray-200 bg-white p-2.5">
                    <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">3</span> Fuel Log</h4>
                    <dl class="grid grid-cols-3 gap-2 text-[11px]">
                        <div><dt class="text-[10px] text-gray-500">Remaining</dt><dd class="font-medium">{{ $log['fuel_log']['remaining_fuel_unloaded'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Uplifted</dt><dd class="font-medium">{{ $log['fuel_log']['fuel_uplifted'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Total Fuel</dt><dd class="font-medium">{{ $log['fuel_log']['total_fuel'] }}</dd></div>
                        <div class="col-span-3 mt-0.5 flex flex-wrap gap-x-2 gap-y-0.5 text-[10px] text-gray-500">
                            <span>ENG 1: <strong class="text-gray-900">{{ $log['fuel_log']['eng1'] }}</strong></span>
                            <span>ENG 2: <strong class="text-gray-900">{{ $log['fuel_log']['eng2'] }}</strong></span>
                            <span>MGE: <strong class="text-gray-900">{{ $log['fuel_log']['mge'] }}</strong></span>
                            <span>TGE: <strong class="text-gray-900">{{ $log['fuel_log']['tge'] }}</strong></span>
                            <span>IDG: <strong class="text-gray-900">{{ $log['fuel_log']['idg'] }}</strong></span>
                            <span>RTU 1: <strong class="text-gray-900">{{ $log['fuel_log']['rtu1'] }}</strong></span>
                        </div>
                    </dl>
                </div>
                <div class="rounded border border-gray-200 bg-white p-2.5">
                    <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">4</span> Aircraft Rate</h4>
                    <div class="flex items-center gap-3 text-[11px]">
                        <label class="inline-flex items-center gap-1"><input type="checkbox" {{ $log['aircraft_rate']['sfb'] ? 'checked' : '' }} class="h-3 w-3"> SFB</label>
                        <label class="inline-flex items-center gap-1"><input type="checkbox" {{ $log['aircraft_rate']['cat1'] ? 'checked' : '' }} class="h-3 w-3"> CAT 1</label>
                        <label class="inline-flex items-center gap-1"><input type="checkbox" {{ $log['aircraft_rate']['cat2'] ? 'checked' : '' }} class="h-3 w-3"> CAT 2</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. CRS + Maint Supervisor --}}
        <div class="rounded border border-gray-200 bg-white p-2.5">
            <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">5</span> Certificate to Release to Service</h4>
            <div class="overflow-x-auto">
                <div class="grid min-w-[1000px] grid-cols-3 gap-2">
                    <dl class="grid grid-cols-2 gap-2 text-[11px]">
                        <div><dt class="text-[10px] text-gray-500">A/C Basic Wt (Kg)</dt><dd class="font-medium">{{ $log['crs']['aircraft_basic_weight'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">All Up Wt (Kg)</dt><dd class="font-medium">{{ $log['crs']['aircraft_up_weight'] }}</dd></div>
                    </dl>
                    <dl class="grid grid-cols-3 gap-2 text-[11px]">
                        <div class="col-span-3 text-[10px] font-semibold uppercase text-gray-500">Certifying Staff / Authorised Crew</div>
                        <div><dt class="text-[10px] text-gray-500">Rank / Name</dt><dd class="font-medium">{{ $log['crs']['rank_name'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Auth. No.</dt><dd class="font-medium">{{ $log['crs']['authority_no'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Time</dt><dd class="font-medium">{{ $log['crs']['time'] }}</dd></div>
                    </dl>
                    <dl class="grid grid-cols-3 gap-2 text-[11px]">
                        <div class="col-span-3 text-[10px] font-semibold uppercase text-gray-500">Maintenance Supervisor</div>
                        <div><dt class="text-[10px] text-gray-500">Rank / Name</dt><dd class="font-medium">{{ $log['maint_supervisor']['rank_name'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Auth. No.</dt><dd class="font-medium">{{ $log['maint_supervisor']['authority_no'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Time</dt><dd class="font-medium">{{ $log['maint_supervisor']['time'] }}</dd></div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- 6/7/8 --}}
        <div class="overflow-x-auto">
            <div class="grid min-w-[1100px] grid-cols-3 gap-2">
                <div class="rounded border border-gray-200 bg-white p-2.5">
                    <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">6</span> Pre-Flight / Turn Around</h4>
                    <table class="w-full text-[11px]">
                        <thead class="text-[10px] text-gray-500"><tr><th class="text-left">Description</th><th class="text-left">Name</th><th class="text-left">Auth.</th><th class="text-left">Date</th><th class="text-left">Time</th></tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($log['pre_flight'] as $row)
                                <tr><td class="py-1">{{ $row['description'] }}</td><td class="py-1">{{ $row['name'] }}</td><td class="py-1">{{ $row['authority_no'] }}</td><td class="py-1">{{ $row['date'] }}</td><td class="py-1">{{ $row['time'] }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="rounded border border-gray-200 bg-white p-2.5">
                    <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">7</span> Next Maintenance Due</h4>
                    <dl class="space-y-1 text-[11px]">
                        <div><dt class="text-[10px] text-gray-500">Type of Maintenance</dt><dd class="font-medium">{{ $log['next_due']['type_of_maintenance'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Due @ Flight Hours</dt><dd class="font-medium">{{ $log['next_due']['due_at_flight_hours'] }}</dd></div>
                        <div><dt class="text-[10px] text-gray-500">Due @ Date</dt><dd class="font-medium">{{ $log['next_due']['due_at_date'] }}</dd></div>
                    </dl>
                </div>
                <div class="rounded border border-gray-200 bg-white p-2.5">
                    <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">8</span> Daily Maintenance</h4>
                    <table class="w-full text-[11px]">
                        <thead class="text-[10px] text-gray-500"><tr><th class="text-left">Description</th><th class="text-left">Auth.</th><th class="text-left">Date</th><th class="text-left">Time</th></tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($log['daily_maint'] as $row)
                                <tr><td class="py-1">{{ $row['description'] }}</td><td class="py-1">{{ $row['authority_no'] }}</td><td class="py-1">{{ $row['date'] }}</td><td class="py-1">{{ $row['time'] }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 9. Defects --}}
        <div class="rounded border border-gray-200 bg-white p-2.5">
            <h4 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-500"><span class="mr-1.5 inline-flex h-4 w-4 items-center justify-center rounded bg-blue-100 text-blue-700">9</span> Defects</h4>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1700px] text-[11px]">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                            <th class="py-1 pl-1.5">No.</th>
                            <th class="py-1">Type</th>
                            <th class="py-1">Description</th>
                            <th class="py-1">Reported Name</th>
                            <th class="py-1">Auth.</th>
                            <th class="py-1">Action Taken</th>
                            <th class="py-1">Performed Name</th>
                            <th class="py-1">Auth.</th>
                            <th class="py-1">Defer</th>
                            <th class="py-1">MEL Ref</th>
                            <th class="py-1">MEL Cat</th>
                            <th class="py-1">MEL Expiry</th>
                            <th class="py-1">Reason</th>
                            <th class="py-1">Part No.</th>
                            <th class="py-1">Qty</th>
                            <th class="py-1">Desc</th>
                            <th class="py-1">Remarks</th>
                            <th class="py-1">Defect Category</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($log['defects'] as $r)
                            <tr>
                                <td class="py-1 pl-1.5">
                                    <span class="inline-flex h-4 w-4 items-center justify-center rounded-full {{ $r['tone'] === 'red' ? 'bg-red-100 text-red-800' : ($r['tone'] === 'amber' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }} text-[10px] font-bold">{{ $r['no'] }}</span>
                                </td>
                                <td class="py-1"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $r['tone'] === 'red' ? 'bg-red-100 text-red-800' : ($r['tone'] === 'amber' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }}">{{ $r['type'] }}</span></td>
                                <td class="py-1 text-gray-700">{{ $r['description'] }}</td>
                                <td class="py-1">{{ $r['reported_by_name'] }}</td>
                                <td class="py-1">{{ $r['reported_by_auth'] }}</td>
                                <td class="py-1 text-gray-700">{{ $r['action_taken'] }}</td>
                                <td class="py-1">{{ $r['performed_by_name'] }}</td>
                                <td class="py-1">{{ $r['performed_by_auth'] }}</td>
                                <td class="py-1">{{ $r['deferral'] }}</td>
                                <td class="py-1">{{ $r['mel_ref'] }}</td>
                                <td class="py-1">{{ $r['mel_repair_category'] }}</td>
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
        </div>
    </section>
</div>
