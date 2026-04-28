@php
    $e = $data['events'];
@endphp

<div class="space-y-3">
    {{-- Filters --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
        <div class="flex min-w-[1000px] items-center gap-1.5">
            <input type="text" placeholder="Search by Event ID, Type, Description, User..." class="input-field w-64 text-[11px]" />
            <select class="input-field w-32 text-[11px]"><option>All Event Type</option></select>
            <select class="input-field w-32 text-[11px]"><option>All Category</option></select>
            <input type="text" placeholder="01 Apr 2025 — 22 May 2025" class="input-field w-48 text-[11px]" />
            <button type="button" class="rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">More Filters</button>
            <button type="button" class="ml-auto inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 hover:bg-gray-50">
                <x-icon name="document-arrow-down" class="h-3 w-3" /> Export
            </button>
        </div>
    </div>

    {{-- Events table --}}
    <section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <h3 class="mb-2 text-xs font-semibold text-gray-900">Events ({{ count($e['rows']) }})</h3>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-[11px]">
                <thead class="border-b border-gray-200 bg-gray-50 text-left text-[10px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="py-1 pl-1.5 w-7"></th>
                        <th class="py-1">Event ID</th>
                        <th class="py-1">Event Type</th>
                        <th class="py-1">Category</th>
                        <th class="py-1">Description</th>
                        <th class="py-1">Date</th>
                        <th class="py-1">Time</th>
                        <th class="py-1">Performed By</th>
                        <th class="py-1">Reference / Source</th>
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
                            <td class="py-1 pl-1.5 text-center"><x-icon :name="$iconName" class="h-3.5 w-3.5 text-gray-400" /></td>
                            <td class="py-1 font-medium text-gray-900">{{ $r['id'] }}</td>
                            <td class="py-1"><span class="rounded px-1.5 py-0.5 text-[10px] font-semibold {{ $typeColor }}">{{ $r['type'] }}</span></td>
                            <td class="py-1">{{ $r['category'] }}</td>
                            <td class="py-1 text-gray-700">{{ $r['description'] }}</td>
                            <td class="py-1">{{ $r['date'] }}</td>
                            <td class="py-1">{{ $r['time'] }}</td>
                            <td class="py-1">{{ $r['performed_by'] }}</td>
                            <td class="py-1">{{ $r['reference'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
            <span>Showing 1 to {{ count($e['rows']) }} of 198 events</span>
            <span>Rows per page: 10</span>
        </div>
    </section>
</div>
