@extends('layouts.app')

@section('title', 'Operations · Technical Logs')

@section('content')
    @php
        $logs = App\Models\TechnicalLog::with(['status', 'melCategory'])
            ->orderByDesc('is_deferral')
            ->orderBy('deadline_date')
            ->get();

        $deferredCount = $logs->where('is_deferral', true)->count();
        $closedCount = $logs->where('status_code', '00000003')->count();
    @endphp

    <div class="space-y-6">
        <x-page-header
            title="Technical Logs"
            description="Deferred defects, MEL entries, and closed tech-log records — SAP @MRO_OTLG."
        >
            <x-slot name="actions">
                <span class="inline-flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                    {{ $deferredCount }} deferred
                </span>
                <span class="inline-flex items-center gap-2 rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                    {{ $closedCount }} closed
                </span>
                <span class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                    <x-icon name="document" class="h-3.5 w-3.5" />
                    @MRO_OTLG
                </span>
            </x-slot>
        </x-page-header>

        <x-data-table datatable>
            <x-slot name="search">
                <input type="text" class="input-field w-full md:w-72" placeholder="Search log number, A/C, description…" />
            </x-slot>

            <x-slot name="thead">
                <tr>
                    <th class="table-th">Log #</th>
                    <th class="table-th">A/C</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">MEL</th>
                    <th class="table-th">ATA</th>
                    <th class="table-th">Discovery</th>
                    <th class="table-th">Deadline</th>
                    <th class="table-th">Description</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($logs as $log)
                    <tr class="table-row">
                        <td class="table-td">
                            <span class="font-mono text-xs text-blue-700">{{ $log->log_number }}</span>
                        </td>
                        <td class="table-td font-medium text-gray-900">{{ $log->aircraft_registration ?? '—' }}</td>
                        <td class="table-td">
                            @php $status = optional($log->status)->name ?? $log->status_code ?? '—'; @endphp
                            @if ($log->is_deferral)
                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">{{ $status }}</span>
                            @elseif ($log->isClosed())
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">{{ $status }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700">{{ $status }}</span>
                            @endif
                        </td>
                        <td class="table-td">
                            @if ($log->melCategory)
                                <span class="inline-flex rounded bg-blue-50 px-1.5 py-0.5 text-xs font-semibold text-blue-700">MEL {{ $log->melCategory->name }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="table-td text-xs text-gray-500">{{ $log->ata_chapter ?? '—' }}</td>
                        <td class="table-td text-xs text-gray-600">{{ optional($log->discovery_date)->format('d.m.Y') ?? '—' }}</td>
                        <td class="table-td">
                            @if ($log->deadline_date)
                                @php $overdue = $log->deadline_date->isPast() && $log->is_deferral; @endphp
                                <span class="text-xs font-medium {{ $overdue ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $log->deadline_date->format('d.m.Y') }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="table-td max-w-md truncate text-xs text-gray-600" title="{{ $log->discovery_description }}">{{ $log->discovery_description }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="table-td text-center text-sm text-gray-400">No technical logs yet. Run <code>php artisan migrate --seed</code>.</td></tr>
                @endforelse
            </x-slot>
        </x-data-table>
    </div>
@endsection
