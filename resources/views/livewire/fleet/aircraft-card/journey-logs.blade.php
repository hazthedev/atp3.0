@php
    $jl = $data['journey_logs'];
    $log = $jl['selected_log'];
@endphp

<div class="space-y-4">
    {{-- Logs table --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Journey Logs ({{ count($jl['rows']) }})</h3>
            <div class="flex items-center gap-2">
                <input type="text" placeholder="Search by Log No..." class="input-field w-64 text-xs" />
                <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
                <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="document-arrow-down" class="h-3.5 w-3.5" /> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                        <th class="py-1.5 pl-2 w-8"></th>
                        <th class="py-1.5">Log No.</th>
                        <th class="py-1.5">Date</th>
                        <th class="py-1.5">Time</th>
                        <th class="py-1.5">Sectors</th>
                        <th class="py-1.5">Total FH (Before)</th>
                        <th class="py-1.5">Total FC (Before)</th>
                        <th class="py-1.5">Total FH</th>
                        <th class="py-1.5">Total FC</th>
                        <th class="py-1.5">Total Engine Start</th>
                        <th class="py-1.5">Total APU Hours</th>
                        <th class="py-1.5">Total FH (After)</th>
                        <th class="py-1.5">Total FC (After)</th>
                        <th class="py-1.5">Status</th>
                        <th class="py-1.5">Penalties</th>
                        <th class="py-1.5">Defect Raised</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($jl['rows'] as $r)
                        <tr class="{{ ($r['selected'] ?? false) ? 'bg-blue-50' : '' }}">
                            <td class="py-1.5 pl-2 text-center"><input type="radio" name="selected_log" {{ ($r['selected'] ?? false) ? 'checked' : '' }} class="h-3.5 w-3.5"></td>
                            <td class="py-1.5 font-medium text-gray-900">{{ $r['no'] }}</td>
                            <td class="py-1.5">{{ $r['date'] }}</td>
                            <td class="py-1.5">{{ $r['time'] }}</td>
                            <td class="py-1.5">{{ $r['sectors'] }}</td>
                            <td class="py-1.5">{{ $r['total_fh_before'] }}</td>
                            <td class="py-1.5">{{ $r['total_fc_before'] }}</td>
                            <td class="py-1.5">{{ $r['total_fh'] }}</td>
                            <td class="py-1.5">{{ $r['total_fc'] }}</td>
                            <td class="py-1.5">{{ $r['total_engine_start'] }}</td>
                            <td class="py-1.5">{{ $r['total_apu_hours'] }}</td>
                            <td class="py-1.5">{{ $r['total_fh_after'] }}</td>
                            <td class="py-1.5">{{ $r['total_fc_after'] }}</td>
                            <td class="py-1.5">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $r['status']])</td>
                            <td class="py-1.5 text-amber-700">{{ $r['penalties'] }}</td>
                            <td class="py-1.5">{{ $r['defect_raised'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
            <span>Showing 1 to {{ count($jl['rows']) }} of 156 journey logs</span>
            <span>Rows per page: 10</span>
        </div>
    </section>

    {{-- Selected log detail --}}
    <section class="space-y-4 rounded-xl border border-blue-200 bg-blue-50/30 p-4 shadow-sm">
        <h3 class="text-sm font-bold text-blue-900">Journey Log Details - {{ $jl['selected_log_no'] }}</h3>

        {{-- Flight Details --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">1</span> Flight Details</h4>
            <dl class="grid grid-cols-2 gap-3 text-xs md:grid-cols-6 lg:grid-cols-12">
                <div><dt class="text-gray-500">Flight No.</dt><dd class="font-medium">{{ $log['flight_details']['flight_no'] }}</dd></div>
                <div><dt class="text-gray-500">From</dt><dd class="font-medium">{{ $log['flight_details']['from'] }}</dd></div>
                <div><dt class="text-gray-500">To</dt><dd class="font-medium">{{ $log['flight_details']['to'] }}</dd></div>
                <div><dt class="text-gray-500">Rotor Start</dt><dd class="font-medium">{{ $log['flight_details']['rotor_start'] }}</dd></div>
                <div><dt class="text-gray-500">Duration (HH:MM)</dt><dd class="font-medium">{{ $log['flight_details']['duration'] }}</dd></div>
                <div><dt class="text-gray-500">Sectors</dt><dd class="font-medium">{{ $log['flight_details']['sectors'] }}</dd></div>
                <div><dt class="text-gray-500">Landing</dt><dd class="font-medium">{{ $log['flight_details']['landing'] }}</dd></div>
                <div><dt class="text-gray-500">Rotor Stop</dt><dd class="font-medium">{{ $log['flight_details']['rotor_stop'] }}</dd></div>
                <div><dt class="text-gray-500">Engine Start</dt><dd class="font-medium">{{ $log['flight_details']['engine_start'] }}</dd></div>
                <div><dt class="text-gray-500">Landings</dt><dd class="font-medium">{{ $log['flight_details']['landings'] }}</dd></div>
                <div><dt class="text-gray-500">Arrival Fuel</dt><dd class="font-medium">{{ $log['flight_details']['arrival_fuel'] ? '✓' : '—' }}</dd></div>
                <div>
                    <dt class="text-gray-500">Penalties (if Applicable)</dt>
                    <dd class="flex items-center gap-2 text-[10px]">
                        <label><input type="checkbox" class="h-3 w-3"> START/STOP 30 < V < 45</label>
                        <label><input type="checkbox" class="h-3 w-3"> START/STOP 47 < V < 60</label>
                        <label><input type="checkbox" class="h-3 w-3"> CAT A TRG</label>
                    </dd>
                </div>
            </dl>
        </div>

        {{-- 3 columns: PIC + Fuel Log + Aircraft Rate --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">2</span> Pilot In-Command</h4>
                <dl class="grid grid-cols-2 gap-3 text-xs">
                    <div><dt class="text-gray-500">Rank / Name</dt><dd class="font-medium">{{ $log['pic']['rank_name'] }}</dd></div>
                    <div><dt class="text-gray-500">Service License Number</dt><dd class="font-medium">{{ $log['pic']['service_license_number'] }}</dd></div>
                </dl>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">3</span> Fuel Log</h4>
                <dl class="grid grid-cols-3 gap-3 text-xs">
                    <div><dt class="text-gray-500">Remaining Fuel Unloaded</dt><dd class="font-medium">{{ $log['fuel_log']['remaining_fuel_unloaded'] }}</dd></div>
                    <div><dt class="text-gray-500">Fuel Uplifted</dt><dd class="font-medium">{{ $log['fuel_log']['fuel_uplifted'] }}</dd></div>
                    <div><dt class="text-gray-500">Total Fuel</dt><dd class="font-medium">{{ $log['fuel_log']['total_fuel'] }}</dd></div>
                    <div class="col-span-3 mt-1 grid grid-cols-6 gap-2 text-[10px] uppercase text-gray-500">
                        <span>ENG 1: <strong class="text-gray-900">{{ $log['fuel_log']['eng1'] }}</strong></span>
                        <span>ENG 2: <strong class="text-gray-900">{{ $log['fuel_log']['eng2'] }}</strong></span>
                        <span>MGE: <strong class="text-gray-900">{{ $log['fuel_log']['mge'] }}</strong></span>
                        <span>TGE: <strong class="text-gray-900">{{ $log['fuel_log']['tge'] }}</strong></span>
                        <span>IDG: <strong class="text-gray-900">{{ $log['fuel_log']['idg'] }}</strong></span>
                        <span>RTU 1: <strong class="text-gray-900">{{ $log['fuel_log']['rtu1'] }}</strong></span>
                    </div>
                </dl>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">4</span> Aircraft Rate</h4>
                <div class="flex items-center gap-3 text-xs">
                    <label class="inline-flex items-center gap-1"><input type="checkbox" {{ $log['aircraft_rate']['sfb'] ? 'checked' : '' }} class="h-3 w-3"> SFB</label>
                    <label class="inline-flex items-center gap-1"><input type="checkbox" {{ $log['aircraft_rate']['cat1'] ? 'checked' : '' }} class="h-3 w-3"> CAT 1</label>
                    <label class="inline-flex items-center gap-1"><input type="checkbox" {{ $log['aircraft_rate']['cat2'] ? 'checked' : '' }} class="h-3 w-3"> CAT 2</label>
                </div>
            </div>
        </div>

        {{-- CRS + Maintenance Supervisor --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">5</span> Certificate to Release to Service</h4>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <dl class="grid grid-cols-2 gap-3 text-xs">
                    <div><dt class="text-gray-500">Aircraft Basic Weight (Kg)</dt><dd class="font-medium">{{ $log['crs']['aircraft_basic_weight'] }}</dd></div>
                    <div><dt class="text-gray-500">All Up Weight (Kg)</dt><dd class="font-medium">{{ $log['crs']['aircraft_up_weight'] }}</dd></div>
                </dl>
                <dl class="grid grid-cols-3 gap-3 text-xs">
                    <div class="col-span-3 text-[11px] font-semibold uppercase text-gray-500">Certifying Staff / Authorised Crew Only</div>
                    <div><dt class="text-gray-500">Rank / Name</dt><dd class="font-medium">{{ $log['crs']['rank_name'] }}</dd></div>
                    <div><dt class="text-gray-500">Authority No.</dt><dd class="font-medium">{{ $log['crs']['authority_no'] }}</dd></div>
                    <div><dt class="text-gray-500">Time</dt><dd class="font-medium">{{ $log['crs']['time'] }}</dd></div>
                </dl>
                <dl class="grid grid-cols-3 gap-3 text-xs">
                    <div class="col-span-3 text-[11px] font-semibold uppercase text-gray-500">Maintenance Supervisor / Authorised Crew Only</div>
                    <div><dt class="text-gray-500">Rank / Name</dt><dd class="font-medium">{{ $log['maint_supervisor']['rank_name'] }}</dd></div>
                    <div><dt class="text-gray-500">Authority No.</dt><dd class="font-medium">{{ $log['maint_supervisor']['authority_no'] }}</dd></div>
                    <div><dt class="text-gray-500">Time</dt><dd class="font-medium">{{ $log['maint_supervisor']['time'] }}</dd></div>
                </dl>
            </div>
        </div>

        {{-- Pre-flight + Next Due + Daily --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">6</span> Pre-Flight / Turn Around Maintenance</h4>
                <table class="w-full text-xs">
                    <thead class="text-[10px] text-gray-500"><tr><th class="text-left">Description</th><th class="text-left">Name</th><th class="text-left">Authority No.</th><th class="text-left">Date</th><th class="text-left">Time</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($log['pre_flight'] as $row)
                            <tr><td class="py-1.5">{{ $row['description'] }}</td><td class="py-1.5">{{ $row['name'] }}</td><td class="py-1.5">{{ $row['authority_no'] }}</td><td class="py-1.5">{{ $row['date'] }}</td><td class="py-1.5">{{ $row['time'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">7</span> Next Maintenance Due</h4>
                <dl class="space-y-2 text-xs">
                    <div><dt class="text-gray-500">Type of Maintenance</dt><dd class="font-medium">{{ $log['next_due']['type_of_maintenance'] }}</dd></div>
                    <div><dt class="text-gray-500">Due @ Flight Hours</dt><dd class="font-medium">{{ $log['next_due']['due_at_flight_hours'] }}</dd></div>
                    <div><dt class="text-gray-500">Due @ Date</dt><dd class="font-medium">{{ $log['next_due']['due_at_date'] }}</dd></div>
                </dl>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">8</span> Daily Maintenance</h4>
                <table class="w-full text-xs">
                    <thead class="text-[10px] text-gray-500"><tr><th class="text-left">Description</th><th class="text-left">Authority No.</th><th class="text-left">Date</th><th class="text-left">Time</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($log['daily_maint'] as $row)
                            <tr><td class="py-1.5">{{ $row['description'] }}</td><td class="py-1.5">{{ $row['authority_no'] }}</td><td class="py-1.5">{{ $row['date'] }}</td><td class="py-1.5">{{ $row['time'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Defects --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500"><span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded bg-blue-100 text-blue-700">9</span> Defects</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-[11px]">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                            <th class="py-1.5 pl-2">No.</th>
                            <th class="py-1.5">Type</th>
                            <th class="py-1.5">Description</th>
                            <th class="py-1.5">Reported By Name</th>
                            <th class="py-1.5">Authority No.</th>
                            <th class="py-1.5">Action Taken</th>
                            <th class="py-1.5">Performed By Name</th>
                            <th class="py-1.5">Authority No.</th>
                            <th class="py-1.5">Deferral</th>
                            <th class="py-1.5">MEL Reference No.</th>
                            <th class="py-1.5">MEL Repair Category</th>
                            <th class="py-1.5">MEL Expiry Date</th>
                            <th class="py-1.5">Reason for Deferral</th>
                            <th class="py-1.5">Part Number</th>
                            <th class="py-1.5">Qty</th>
                            <th class="py-1.5">Description</th>
                            <th class="py-1.5">Remarks</th>
                            <th class="py-1.5">Defect Category</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($log['defects'] as $r)
                            <tr>
                                <td class="py-1.5 pl-2">
                                    <span class="inline-flex h-4 w-4 items-center justify-center rounded-full {{ $r['tone'] === 'red' ? 'bg-red-100 text-red-800' : ($r['tone'] === 'amber' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }} text-[10px] font-bold">{{ $r['no'] }}</span>
                                </td>
                                <td class="py-1.5">
                                    <span class="rounded px-1.5 py-0.5 text-[10px] font-semibold {{ $r['tone'] === 'red' ? 'bg-red-100 text-red-800' : ($r['tone'] === 'amber' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }}">{{ $r['type'] }}</span>
                                </td>
                                <td class="py-1.5 text-gray-700">{{ $r['description'] }}</td>
                                <td class="py-1.5">{{ $r['reported_by_name'] }}</td>
                                <td class="py-1.5">{{ $r['reported_by_auth'] }}</td>
                                <td class="py-1.5 text-gray-700">{{ $r['action_taken'] }}</td>
                                <td class="py-1.5">{{ $r['performed_by_name'] }}</td>
                                <td class="py-1.5">{{ $r['performed_by_auth'] }}</td>
                                <td class="py-1.5">{{ $r['deferral'] }}</td>
                                <td class="py-1.5">{{ $r['mel_ref'] }}</td>
                                <td class="py-1.5">{{ $r['mel_repair_category'] }}</td>
                                <td class="py-1.5">{{ $r['mel_expiry_date'] }}</td>
                                <td class="py-1.5">{{ $r['reason_for_deferral'] }}</td>
                                <td class="py-1.5">{{ $r['part_number'] }}</td>
                                <td class="py-1.5">{{ $r['qty'] }}</td>
                                <td class="py-1.5">{{ $r['description_short'] }}</td>
                                <td class="py-1.5">{{ $r['remarks'] }}</td>
                                <td class="py-1.5 text-gray-700">{{ $r['defect_category'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
