@php
    $e = $data['events'];
@endphp

<div class="space-y-4">
    {{-- Filters --}}
    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
        <input type="text" placeholder="Search by Event ID, Type, Description, User..." class="input-field w-72 text-xs" />
        <select class="input-field w-36 text-xs"><option>All Event Type</option></select>
        <select class="input-field w-36 text-xs"><option>All Category</option></select>
        <input type="text" placeholder="01 Apr 2025 — 22 May 2025" class="input-field w-56 text-xs" />
        <button type="button" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
        <button type="button" class="ml-auto inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
            <x-icon name="document-arrow-down" class="h-3.5 w-3.5" /> Export
        </button>
    </div>

    {{-- Events table --}}
    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-sm font-semibold text-gray-900">Events ({{ count($e['rows']) }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px]">
                <thead class="border-b border-gray-200 bg-gray-50 text-left uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="py-2 pl-2"></th>
                        <th class="py-2">Event ID</th>
                        <th class="py-2">Event Type</th>
                        <th class="py-2">Category</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">Date</th>
                        <th class="py-2">Time</th>
                        <th class="py-2">Performed By</th>
                        <th class="py-2">Reference / Source</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($e['rows'] as $r)
                        @php
                            $typeColor = match (true) {
                                str_contains($r['type'], 'Installation')      => 'bg-blue-100 text-blue-800',
                                str_contains($r['type'], 'Uninstallation')    => 'bg-amber-100 text-amber-800',
                                str_contains($r['type'], 'Configuration')     => 'bg-orange-100 text-orange-800',
                                str_contains($r['type'], 'Visit')             => 'bg-purple-100 text-purple-800',
                                str_contains($r['type'], 'Task')              => 'bg-emerald-100 text-emerald-800',
                                str_contains($r['type'], 'Publication')       => 'bg-indigo-100 text-indigo-800',
                                str_contains($r['type'], 'Status')            => 'bg-cyan-100 text-cyan-800',
                                str_contains($r['type'], 'Airworthiness')     => 'bg-emerald-100 text-emerald-800',
                                str_contains($r['type'], 'Service Bulletin')  => 'bg-pink-100 text-pink-800',
                                str_contains($r['type'], 'Mandatory')         => 'bg-yellow-100 text-yellow-800',
                                default                                       => 'bg-gray-100 text-gray-700',
                            };
                            $iconName = match (true) {
                                str_contains($r['type'], 'Installation')      => 'cog-6-tooth',
                                str_contains($r['type'], 'Uninstallation')    => 'cog-6-tooth',
                                str_contains($r['type'], 'Configuration')     => 'squares-2x2',
                                str_contains($r['type'], 'Visit')             => 'document',
                                str_contains($r['type'], 'Task')              => 'paperclip',
                                str_contains($r['type'], 'Publication')       => 'document-text',
                                str_contains($r['type'], 'Status')            => 'arrow-path',
                                str_contains($r['type'], 'Airworthiness')     => 'calendar-days',
                                str_contains($r['type'], 'Service Bulletin')  => 'document-text',
                                str_contains($r['type'], 'Mandatory')         => 'check-circle',
                                default                                       => 'document',
                            };
                        @endphp
                        <tr>
                            <td class="py-1.5 pl-2 text-center"><x-icon :name="$iconName" class="h-4 w-4 text-gray-400" /></td>
                            <td class="py-1.5 font-medium text-gray-900">{{ $r['id'] }}</td>
                            <td class="py-1.5"><span class="rounded px-1.5 py-0.5 text-[10px] font-semibold {{ $typeColor }}">{{ $r['type'] }}</span></td>
                            <td class="py-1.5">{{ $r['category'] }}</td>
                            <td class="py-1.5 text-gray-700">{{ $r['description'] }}</td>
                            <td class="py-1.5">{{ $r['date'] }}</td>
                            <td class="py-1.5">{{ $r['time'] }}</td>
                            <td class="py-1.5">{{ $r['performed_by'] }}</td>
                            <td class="py-1.5">{{ $r['reference'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
            <span>Showing 1 to {{ count($e['rows']) }} of 198 events</span>
            <span>Rows per page: 10</span>
        </div>
    </section>
</div>
