@php
    $wp = $data['work_package'];
@endphp

<div class="space-y-4">
    {{-- Info banner + actions --}}
    <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-blue-200 bg-blue-50 p-3 text-xs text-blue-800 shadow-sm">
        <div class="flex items-center gap-2">
            <x-icon name="information-circle" class="h-4 w-4" />
            <span>By default, all Work Packages and Work Orders of all statuses (Draft, Planned, Open, Closed) related to this aircraft are listed.</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="#" class="text-xs font-medium text-blue-700 hover:underline">Go to Maintenance Planning ↗</a>
            <button type="button" class="rounded p-1 hover:bg-blue-100"><x-icon name="cog-6-tooth" class="h-4 w-4" /></button>
        </div>
    </div>

    {{-- Work Packages table --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Work Packages ({{ count($wp['packages']) }})</h3>
            <div class="flex items-center gap-2">
                <input type="text" placeholder="Search by WP No, Description, Prepared By..." class="input-field w-72 text-xs" />
                <select class="input-field w-32 text-xs"><option>All Status</option></select>
                <input type="text" placeholder="Start Date" class="input-field w-28 text-xs" />
                <input type="text" placeholder="End Date" class="input-field w-28 text-xs" />
                <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
                <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">Clear Selection</button>
                <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="document-arrow-down" class="h-3.5 w-3.5" /> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                        <th class="py-1.5 pl-2 w-8" rowspan="2"></th>
                        <th class="py-1.5" rowspan="2">No.</th>
                        <th class="py-1.5" rowspan="2">Description</th>
                        <th class="py-1.5" rowspan="2">Status</th>
                        <th class="py-1.5" rowspan="2">Prepared By</th>
                        <th class="py-1.5" rowspan="2">Start Date</th>
                        <th class="py-1.5" rowspan="2">Start Time</th>
                        <th class="py-1.5 text-center" colspan="2">Participating Inspectors / Engineers</th>
                        <th class="py-1.5 text-center" colspan="1">Participating Technicians</th>
                        <th class="py-1.5" rowspan="2">End Date</th>
                        <th class="py-1.5" rowspan="2">End Time</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left uppercase text-gray-500">
                        <th class="py-1.5">Name</th>
                        <th class="py-1.5">Authority No.</th>
                        <th class="py-1.5">Name</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($wp['packages'] as $pkg)
                        <tr class="{{ $pkg['no'] === $wp['selected_pkg_no'] ? 'bg-blue-50' : '' }}">
                            <td class="py-1.5 pl-2 text-center">
                                <input type="radio" name="selected_pkg" {{ $pkg['no'] === $wp['selected_pkg_no'] ? 'checked' : '' }} class="h-3.5 w-3.5">
                            </td>
                            <td class="py-1.5 font-medium text-gray-900">{{ $pkg['no'] }}</td>
                            <td class="py-1.5 text-gray-700">{{ $pkg['description'] }}</td>
                            <td class="py-1.5">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $pkg['status']])</td>
                            <td class="py-1.5">{{ $pkg['prepared_by'] }}</td>
                            <td class="py-1.5">{{ $pkg['start_date'] }}</td>
                            <td class="py-1.5">{{ $pkg['start_time'] }}</td>
                            <td class="py-1.5">{{ $pkg['inspector_name'] }}</td>
                            <td class="py-1.5">{{ $pkg['inspector_auth'] }}</td>
                            <td class="py-1.5">{{ $pkg['tech_name'] }}</td>
                            <td class="py-1.5">{{ $pkg['end_date'] }}</td>
                            <td class="py-1.5">{{ $pkg['end_time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
            <span>Showing 1 to {{ count($wp['packages']) }} of 12 work packages</span>
            <span>Rows per page: 10</span>
        </div>
    </section>

    {{-- Work Orders for selected package --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Work Orders ({{ count($wp['orders']) }}) for {{ $wp['selected_pkg_label'] }}</h3>
            <div class="flex items-center gap-2">
                <input type="text" placeholder="Search by WO No, Description..." class="input-field w-72 text-xs" />
                <select class="input-field w-32 text-xs"><option>All Status</option></select>
                <input type="text" placeholder="Start Date" class="input-field w-28 text-xs" />
                <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
                <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">Clear Selection</button>
                <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="document-arrow-down" class="h-3.5 w-3.5" /> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                        <th class="py-1.5 pl-2 w-8" rowspan="2"></th>
                        <th class="py-1.5" rowspan="2">No.</th>
                        <th class="py-1.5" rowspan="2">Type</th>
                        <th class="py-1.5" rowspan="2">Description</th>
                        <th class="py-1.5" rowspan="2">Status</th>
                        <th class="py-1.5" rowspan="2">Prepared By</th>
                        <th class="py-1.5" rowspan="2">Start Date</th>
                        <th class="py-1.5" rowspan="2">Due Date / Hours / Cycles</th>
                        <th class="py-1.5" rowspan="2">Completed Date / Hours / Cycles</th>
                        <th class="py-1.5 text-center" colspan="2">Action By</th>
                        <th class="py-1.5 text-center" colspan="2">Verified By</th>
                    </tr>
                    <tr class="border-b border-gray-200 text-left uppercase text-gray-500">
                        <th class="py-1.5">Name</th>
                        <th class="py-1.5">Authority No.</th>
                        <th class="py-1.5">Name</th>
                        <th class="py-1.5">Authority No.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($wp['orders'] as $i => $wo)
                        <tr class="{{ $i === 0 ? 'bg-blue-50' : '' }}">
                            <td class="py-1.5 pl-2 text-center"><input type="radio" name="selected_wo" {{ $i === 0 ? 'checked' : '' }} class="h-3.5 w-3.5"></td>
                            <td class="py-1.5 font-medium text-gray-900">{{ $wo['no'] }}</td>
                            <td class="py-1.5">{{ $wo['type'] }}</td>
                            <td class="py-1.5 text-gray-700">{{ $wo['description'] }}</td>
                            <td class="py-1.5">@include('livewire.fleet.aircraft-card._status-pill', ['status' => $wo['status']])</td>
                            <td class="py-1.5">{{ $wo['prepared_by'] }}</td>
                            <td class="py-1.5">{{ $wo['start_date'] }}</td>
                            <td class="py-1.5">{{ $wo['due'] }}</td>
                            <td class="py-1.5">{{ $wo['completed'] }}</td>
                            <td class="py-1.5">{{ $wo['action_by_name'] }}</td>
                            <td class="py-1.5">{{ $wo['action_by_auth'] }}</td>
                            <td class="py-1.5">{{ $wo['verified_by_name'] }}</td>
                            <td class="py-1.5">{{ $wo['verified_by_auth'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
            <span>Showing 1 to {{ count($wp['orders']) }} of {{ count($wp['orders']) }} work orders</span>
            <span>Rows per page: 10</span>
        </div>
    </section>

    {{-- Status legend --}}
    <div class="flex items-center gap-3 text-[11px] text-gray-500">
        <span class="font-semibold uppercase">Legend:</span>
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'DRAFT'])
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'PLANNED'])
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'OPEN'])
        @include('livewire.fleet.aircraft-card._status-pill', ['status' => 'CLOSED'])
    </div>
</div>
