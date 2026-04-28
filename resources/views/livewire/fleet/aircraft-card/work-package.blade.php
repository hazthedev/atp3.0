@php
    $wp = $data['work_package'];
@endphp

<div class="space-y-3">
    {{-- Info banner --}}
    <div class="flex items-center justify-between gap-2 rounded-lg border border-blue-200 bg-blue-50 p-2 text-[11px] text-blue-800 shadow-sm">
        <div class="flex items-center gap-1.5">
            <x-icon name="information-circle" class="h-3.5 w-3.5" />
            <span>By default, all Work Packages and Work Orders of all statuses (Draft, Planned, Open, Closed) related to this aircraft are listed.</span>
        </div>
        <div class="flex items-center gap-1.5">
            <a href="#" class="text-[11px] font-medium text-blue-700 hover:underline">Go to Maintenance Planning ↗</a>
            <button type="button" class="rounded p-1 hover:bg-blue-100"><x-icon name="cog-6-tooth" class="h-3.5 w-3.5" /></button>
        </div>
    </div>

    {{-- Work Packages --}}
    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <div class="mb-2 flex items-center justify-between">
            <h3 class="text-xs font-semibold text-gray-900">Work Packages ({{ count($wp['packages']) }})</h3>
            <div class="flex items-center gap-1.5">
                <input type="text" placeholder="Search WP..." class="input-field w-48 text-[11px]" />
                <select class="input-field w-24 text-[11px]"><option>All Status</option></select>
                <input type="text" placeholder="Start" class="input-field w-24 text-[11px]" />
                <input type="text" placeholder="End" class="input-field w-24 text-[11px]" />
                <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More</button>
                <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">Clear</button>
                <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="document-arrow-down" class="h-3 w-3" /> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px] text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                        <th class="py-1 pl-1.5 w-7" rowspan="2"></th>
                        <th class="py-1" rowspan="2">No.</th>
                        <th class="py-1" rowspan="2">Description</th>
                        <th class="py-1" rowspan="2">Status</th>
                        <th class="py-1" rowspan="2">Prepared By</th>
                        <th class="py-1" rowspan="2">Start Date</th>
                        <th class="py-1" rowspan="2">Start Time</th>
                        <th class="py-1 text-center" colspan="2">Inspectors / Engineers</th>
                        <th class="py-1" rowspan="2">Technician</th>
                        <th class="py-1" rowspan="2">End Date</th>
                        <th class="py-1" rowspan="2">End Time</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left text-[10px] uppercase text-gray-500">
                        <th class="py-1">Name</th>
                        <th class="py-1">Auth.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($wp['packages'] as $pkg)
                        <tr class="{{ $pkg['no'] === $wp['selected_pkg_no'] ? 'bg-blue-50' : '' }}">
                            <td class="py-1 pl-1.5 text-center"><input type="radio" name="selected_pkg" {{ $pkg['no'] === $wp['selected_pkg_no'] ? 'checked' : '' }} class="h-3 w-3"></td>
                            <td class="py-1 font-medium text-gray-900">{{ $pkg['no'] }}</td>
                            <td class="py-1 text-gray-700">{{ $pkg['description'] }}</td>
                            <td class="py-1">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $pkg['status']])</td>
                            <td class="py-1">{{ $pkg['prepared_by'] }}</td>
                            <td class="py-1">{{ $pkg['start_date'] }}</td>
                            <td class="py-1">{{ $pkg['start_time'] }}</td>
                            <td class="py-1">{{ $pkg['inspector_name'] }}</td>
                            <td class="py-1">{{ $pkg['inspector_auth'] }}</td>
                            <td class="py-1">{{ $pkg['tech_name'] }}</td>
                            <td class="py-1">{{ $pkg['end_date'] }}</td>
                            <td class="py-1">{{ $pkg['end_time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($wp['packages']) }} of 12 work packages</span>
            <span>Rows per page: 10</span>
        </div>
    </section>

    {{-- Work Orders --}}
    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <div class="mb-2 flex items-center justify-between gap-2">
            <h3 class="text-xs font-semibold text-gray-900">Work Orders ({{ count($wp['orders']) }}) · {{ $wp['selected_pkg_label'] }}</h3>
            <div class="flex items-center gap-1.5">
                <input type="text" placeholder="Search WO..." class="input-field w-48 text-[11px]" />
                <select class="input-field w-24 text-[11px]"><option>All Status</option></select>
                <input type="text" placeholder="Start" class="input-field w-24 text-[11px]" />
                <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More</button>
                <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">Clear</button>
                <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="document-arrow-down" class="h-3 w-3" /> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1300px] text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                        <th class="py-1 pl-1.5 w-7" rowspan="2"></th>
                        <th class="py-1" rowspan="2">No.</th>
                        <th class="py-1" rowspan="2">Type</th>
                        <th class="py-1" rowspan="2">Description</th>
                        <th class="py-1" rowspan="2">Status</th>
                        <th class="py-1" rowspan="2">Prepared By</th>
                        <th class="py-1" rowspan="2">Start Date</th>
                        <th class="py-1" rowspan="2">Due (Date / Hrs / Cyc)</th>
                        <th class="py-1" rowspan="2">Completed (Date / Hrs / Cyc)</th>
                        <th class="py-1 text-center" colspan="2">Action By</th>
                        <th class="py-1 text-center" colspan="2">Verified By</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left text-[10px] uppercase text-gray-500">
                        <th class="py-1">Name</th>
                        <th class="py-1">Auth.</th>
                        <th class="py-1">Name</th>
                        <th class="py-1">Auth.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($wp['orders'] as $i => $wo)
                        <tr class="{{ $i === 0 ? 'bg-blue-50' : '' }}">
                            <td class="py-1 pl-1.5 text-center"><input type="radio" name="selected_wo" {{ $i === 0 ? 'checked' : '' }} class="h-3 w-3"></td>
                            <td class="py-1 font-medium text-gray-900">{{ $wo['no'] }}</td>
                            <td class="py-1">{{ $wo['type'] }}</td>
                            <td class="py-1 text-gray-700">{{ $wo['description'] }}</td>
                            <td class="py-1">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $wo['status']])</td>
                            <td class="py-1">{{ $wo['prepared_by'] }}</td>
                            <td class="py-1">{{ $wo['start_date'] }}</td>
                            <td class="py-1">{{ $wo['due'] }}</td>
                            <td class="py-1">{{ $wo['completed'] }}</td>
                            <td class="py-1">{{ $wo['action_by_name'] }}</td>
                            <td class="py-1">{{ $wo['action_by_auth'] }}</td>
                            <td class="py-1">{{ $wo['verified_by_name'] }}</td>
                            <td class="py-1">{{ $wo['verified_by_auth'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($wp['orders']) }} of {{ count($wp['orders']) }} work orders</span>
            <span>Rows per page: 10</span>
        </div>
    </section>

    {{-- Status legend --}}
    <div class="flex items-center gap-2 text-[10px] text-gray-500">
        <span class="font-semibold uppercase">Legend:</span>
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'DRAFT'])
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'PLANNED'])
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'OPEN'])
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'CLOSED'])
    </div>
</div>
