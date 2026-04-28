@php
    $cfg = $data['configuration'];
    $node = $cfg['selected_node'];
@endphp

<div class="space-y-4">
    {{-- Top summary row --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[280px_1fr_280px]">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Configuration Status</div>
            <div class="flex items-center gap-2">
                <x-icon name="check-circle" class="h-6 w-6 text-emerald-500" />
                <div>
                    <div class="text-base font-bold text-gray-900">{{ $cfg['status_pill'] }}</div>
                    <div class="text-[11px] text-gray-500">{{ $cfg['status_note'] }}</div>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Configuration Summary</div>
            <div class="grid grid-cols-5 gap-3">
                @foreach ($cfg['summary'] as $tile)
                    <div>
                        <div class="text-lg font-bold {{ ($tile['tone'] ?? '') === 'red' ? 'text-red-600' : (($tile['tone'] ?? '') === 'amber' ? 'text-amber-600' : 'text-gray-900') }}">{{ $tile['value'] }}</div>
                        <div class="text-[11px] text-gray-500">{{ $tile['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Configuration Effective</div>
            <div class="text-xs text-gray-500">Effective Date / Time</div>
            <div class="text-sm font-semibold text-gray-900">{{ $cfg['effective']['effective_date_time'] }}</div>
            <div class="mt-2 text-xs text-gray-500">Source</div>
            <div class="text-sm font-semibold text-gray-900">{{ $cfg['effective']['source'] }}</div>
            <a href="#" class="mt-2 inline-block text-xs text-blue-600 hover:underline">View Configuration History →</a>
        </section>
    </div>

    {{-- Tree + Detail panel --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[380px_1fr]">
        {{-- ATA Tree --}}
        <section class="rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Aircraft Configuration Tree</h3>
            </div>
            <div class="mb-2">
                <input type="text" placeholder="Search ATA, Part Number, Description, Serial Number..."
                       class="input-field text-xs" />
            </div>
            <div class="mb-2 flex items-center gap-3 text-[11px] text-gray-600">
                <label class="inline-flex items-center gap-1"><input type="checkbox" class="h-3 w-3"> Show Missing Only</label>
                <label class="inline-flex items-center gap-1"><input type="checkbox" class="h-3 w-3"> Show Unserviceable</label>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-[11px]">
                    <thead class="border-b border-gray-200 text-left font-semibold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="py-1.5">Component</th>
                            <th class="py-1.5">Inst.</th>
                            <th class="py-1.5">Cfg.</th>
                            <th class="py-1.5">Miss.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($cfg['tree'] as $branch)
                            <tr class="bg-gray-50">
                                <td class="py-1.5 font-semibold text-gray-900">{{ $branch['chapter'] }}</td>
                                <td class="py-1.5"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $branch['installation_status'] === 'OK' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $branch['installation_status'] }}</span></td>
                                <td class="py-1.5"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $branch['config_status'] === 'OK' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $branch['config_status'] }}</span></td>
                                <td class="py-1.5 text-gray-700">{{ $branch['missing'] }}</td>
                            </tr>
                            @if (! empty($branch['children']))
                                @foreach ($branch['children'] as $sub)
                                    <tr>
                                        <td class="py-1.5 pl-3 text-gray-800">{{ $sub['chapter'] }}</td>
                                        <td class="py-1.5"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $sub['installation_status'] === 'OK' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $sub['installation_status'] }}</span></td>
                                        <td class="py-1.5"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $sub['config_status'] === 'OK' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $sub['config_status'] }}</span></td>
                                        <td class="py-1.5">{{ $sub['missing'] }}</td>
                                    </tr>
                                    @if (! empty($sub['children']))
                                        @foreach ($sub['children'] as $leaf)
                                            <tr class="{{ ($leaf['selected'] ?? false) ? 'bg-blue-50' : '' }}">
                                                <td class="py-1.5 pl-6 text-gray-700">{{ $leaf['chapter'] }}</td>
                                                <td class="py-1.5"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $leaf['installation_status'] === 'OK' ? 'bg-emerald-100 text-emerald-800' : (($leaf['tone'] ?? '') === 'red' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">{{ $leaf['installation_status'] }}</span></td>
                                                <td class="py-1.5"><span class="rounded px-1 py-0.5 text-[10px] font-semibold {{ $leaf['config_status'] === 'Installed' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $leaf['config_status'] }}</span></td>
                                                <td class="py-1.5">{{ $leaf['missing'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 flex items-center gap-3 text-[10px] text-gray-500">
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-sm bg-emerald-500"></span>Installed</span>
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-sm bg-red-500"></span>Missing</span>
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-sm bg-amber-500"></span>Unconfirmed</span>
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-sm bg-gray-400"></span>N/A</span>
            </div>
        </section>

        {{-- Detail panel --}}
        <section class="space-y-3">
            {{-- Breadcrumbs + header --}}
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-2 text-xs text-gray-500">{{ $node['breadcrumbs'] }}</div>
                <div class="mb-3 flex items-center gap-2">
                    <h3 class="text-base font-bold text-gray-900">{{ $node['chapter'] }}</h3>
                    @include('livewire.fleet.aircraft-card._status-pill', ['status' => $node['status']])
                    <button type="button" disabled class="ml-auto inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-400">
                        Component Card
                    </button>
                    <button type="button" disabled class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-3 py-1 text-xs font-semibold text-white opacity-60">
                        Component Actions
                    </button>
                </div>
                <dl class="grid grid-cols-3 gap-3 text-xs sm:grid-cols-6">
                    <div><dt class="text-gray-500">Part Number</dt><dd class="font-medium text-gray-900">{{ $node['header']['part_number'] }}</dd></div>
                    <div><dt class="text-gray-500">Serial Number</dt><dd class="font-medium text-gray-900">{{ $node['header']['serial_number'] }}</dd></div>
                    <div><dt class="text-gray-500">Manufacturer</dt><dd class="font-medium text-gray-900">{{ $node['header']['manufacturer'] }}</dd></div>
                    <div><dt class="text-gray-500">Mfr Part No.</dt><dd class="font-medium text-gray-900">{{ $node['header']['manufacturer_part_no'] }}</dd></div>
                    <div><dt class="text-gray-500">Position</dt><dd class="font-medium text-gray-900">{{ $node['header']['position'] }}</dd></div>
                    <div><dt class="text-gray-500">Installed Date</dt><dd class="font-medium text-gray-900">{{ $node['header']['installed_date'] }}</dd></div>
                </dl>
            </div>

            {{-- Installation & Status, Counters, Maintenance --}}
            <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Installation & Status</h4>
                    <dl class="space-y-1.5 text-xs">
                        @foreach ($node['installation_status'] as $row)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">{{ $row['label'] }}</dt>
                                <dd class="font-medium text-gray-900">{{ $row['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Counters</h4>
                        <a href="#" class="text-[11px] text-blue-600 hover:underline">Manage Counters →</a>
                    </div>
                    <table class="w-full text-xs">
                        <thead class="text-[11px] text-gray-500">
                            <tr><th class="text-left">Counter</th><th class="text-right">Value</th><th class="text-right">UoM</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($node['counters'] as $c)
                                <tr>
                                    <td class="py-1.5">{{ $c['code'] }}</td>
                                    <td class="py-1.5 text-right font-medium">{{ $c['value'] }}</td>
                                    <td class="py-1.5 text-right text-gray-500">{{ $c['uom'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Maintenance & Due</h4>
                    </div>
                    <ul class="space-y-2 text-xs">
                        @foreach ($node['maintenance_due'] as $m)
                            <li class="rounded border border-gray-100 p-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $m['item'] }} · {{ $m['reference'] }}</div>
                                        <div class="text-gray-600">{{ $m['description'] }}</div>
                                    </div>
                                    <span class="rounded px-1.5 py-0.5 text-[10px] font-semibold {{ ($m['tone'] ?? '') === 'red' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800' }}">{{ $m['remaining'] }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a href="#" class="mt-2 inline-block text-[11px] text-blue-600 hover:underline">View Maintenance Planning →</a>
                </div>
            </div>

            {{-- Component History + Quick Actions --}}
            <div class="grid grid-cols-1 gap-3 lg:grid-cols-[1fr_280px]">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Component History (Latest 5)</h4>
                        <a href="#" class="text-[11px] text-blue-600 hover:underline">View Full History →</a>
                    </div>
                    <table class="w-full text-xs">
                        <thead class="border-b border-gray-200 text-left text-[11px] uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="py-1.5">Date</th>
                                <th class="py-1.5">Action</th>
                                <th class="py-1.5">Part Number</th>
                                <th class="py-1.5">Serial Number</th>
                                <th class="py-1.5">Status</th>
                                <th class="py-1.5">Performed By</th>
                                <th class="py-1.5">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($node['history'] as $h)
                                <tr>
                                    <td class="py-1.5">{{ $h['date'] }}</td>
                                    <td class="py-1.5 font-medium">{{ $h['action'] }}</td>
                                    <td class="py-1.5">{{ $h['part_number'] }}</td>
                                    <td class="py-1.5">{{ $h['serial_number'] }}</td>
                                    <td class="py-1.5">{{ $h['status'] }}</td>
                                    <td class="py-1.5">{{ $h['performed_by'] }}</td>
                                    <td class="py-1.5 text-gray-600">{{ $h['remarks'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="space-y-3">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                        <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Quick Actions</h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-md border border-gray-300 bg-white px-2.5 py-1.5 font-medium text-gray-700 hover:bg-gray-50">
                                <x-icon name="arrow-down-tray" class="h-3.5 w-3.5" /> Install PN/SN
                            </button>
                            <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-md border border-red-200 bg-red-50 px-2.5 py-1.5 font-medium text-red-700 hover:bg-red-100">
                                <x-icon name="arrow-up-tray" class="h-3.5 w-3.5" /> Remove PN/SN
                            </button>
                            <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-md border border-gray-300 bg-white px-2.5 py-1.5 font-medium text-gray-700 hover:bg-gray-50">
                                <x-icon name="arrows-right-left" class="h-3.5 w-3.5" /> Swap PN/SN
                            </button>
                            <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-md border border-gray-300 bg-white px-2.5 py-1.5 font-medium text-gray-700 hover:bg-gray-50">
                                <x-icon name="clock" class="h-3.5 w-3.5" /> Manage Counters
                            </button>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                        <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Configuration Control</h4>
                        <dl class="space-y-1.5 text-xs">
                            @foreach ($node['config_control'] as $row)
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-500">{{ $row['label'] }}</dt>
                                    <dd class="font-medium text-gray-900">{{ $row['value'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                        <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Compliance & Validation</h4>
                        <dl class="space-y-1.5 text-xs">
                            @foreach ($node['compliance'] as $row)
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-500">{{ $row['label'] }}</dt>
                                    <dd class="font-medium text-emerald-700">
                                        <span class="inline-flex items-center gap-1">
                                            <x-icon name="check-circle" class="h-3.5 w-3.5" />
                                            {{ $row['value'] }}
                                        </span>
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
