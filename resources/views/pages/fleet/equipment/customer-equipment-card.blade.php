@extends('layouts.app')

@section('title', 'Customer Equipment Card')

@php
    $requestedId = request('id');
    $equipmentQuery = \App\Models\Equipment::with([
        'item',
        'counters.counterRef',
        'calendarCounter',
    ]);

    $equipment = $requestedId
        ? $equipmentQuery->find($requestedId)
        : $equipmentQuery->first();

    $counters = collect();
    if ($equipment) {
        $counters = $equipment->counters
            ->sortBy(fn ($c) => $c->counterRef?->sort_order ?? 999)
            ->values();
    }

    $calendarCounter = $equipment?->calendarCounter;
@endphp

@section('content')
    @if ($equipment === null)
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
            No equipment seeded yet. Run <code>php artisan db:seed --class=EquipmentSeeder --force</code> to populate the sample record.
        </div>
    @else
    <div class="space-y-6" x-data="{ activeTab: 'counters' }">
        <x-page-header
            title="Customer Equipment Card"
            :description="'Serial ' . $equipment->serial_number . ' · ' . ($equipment->item?->description ?? '')"
        />

        <x-enterprise.panel class="space-y-5">
            {{-- Header fields --}}
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="space-y-2 text-sm">
                    <x-enterprise.field-row label="Equipment No." class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->equipment_no }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Serial Number" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->serial_number }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Item No." class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->item?->code }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Item Description" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->item?->description }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Category Part" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->category_part }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Variant" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->variant }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                </div>
                <div class="space-y-2 text-sm">
                    <x-enterprise.field-row label="Status" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->status }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Owner Code" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->owner_code }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Owner Name" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->owner_name }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Operator Code" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->operator_code }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Operator Name" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->operator_name }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Maintenance Plan" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->maintenance_plan }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="MEL" class="grid-cols-[140px_minmax(0,1fr)]"><input type="text" value="{{ $equipment->mel }}" readonly class="input-field attach-input" /></x-enterprise.field-row>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="subtab-shell">
                <ul class="subtab-list">
                    @foreach (['general' => 'General', 'bom' => 'Bill of Material', 'counters' => 'Counters', 'modif' => 'Modif.', 'events' => 'Events', 'properties' => 'Properties', 'address' => 'Address', 'trans' => 'Trans.', 'remark' => 'Remark'] as $k => $l)
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === '{{ $k }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $k }}'">{{ $l }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Counters tab --}}
            <div x-cloak x-show="activeTab === 'counters'">
                <div class="space-y-4">
                    <table class="w-full border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[90px]">Counter Desc</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-32">Value</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-10 text-center">!</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[120px]">Unit</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Reading Date</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Max</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Remaining</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Residual</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Equi. ID</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[120px]">Info. Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($counters as $c)
                                @php
                                    $value = $c->value_hhmm ?: ($c->value_dec !== null ? number_format((float) $c->value_dec, 4) : '');
                                    $max = $c->max_hhmm ?: ($c->max_dec !== null ? number_format((float) $c->max_dec, 4) : '');
                                    $isUsed = $c->is_used;
                                    $tone = $isUsed ? 'bg-emerald-500' : 'bg-gray-300';
                                @endphp
                                <tr @class(['text-gray-400' => ! $isUsed])>
                                    <td class="border border-gray-200 px-2 py-1 font-medium">{{ $c->counterRef?->name }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $value }}</td>
                                    <td class="border border-gray-200 px-1 py-1 text-center align-middle"><span class="inline-block h-2.5 w-2.5 rounded-full {{ $tone }}"></span></td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $c->counterRef?->measure_unit }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ optional($c->reading_date)->format('d.m.y') }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $max }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $c->remaining }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $c->residual }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $c->linked_equi_id }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $c->info_source }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="border border-gray-200 px-2 py-3 text-center text-gray-400">No counters configured.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Calendar counter --}}
                    <table class="w-full border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[120px]">Counter Desc</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Value</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-10 text-center">!</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Unit</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Limit</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Remaining</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Residual</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Equi. ID</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[120px]">Info Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($calendarCounter)
                                <tr @class(['text-gray-400' => ! $calendarCounter->is_used])>
                                    <td class="border border-gray-200 px-2 py-1 font-medium">{{ $calendarCounter->label }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ optional($calendarCounter->value_date)->format('d.m.y') }}</td>
                                    <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                        @if (! $calendarCounter->is_used)
                                            <span class="font-bold text-red-500">X</span>
                                        @else
                                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 px-2 py-1">Days</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $calendarCounter->limit }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $calendarCounter->remaining }}</td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $calendarCounter->residual }}</td>
                                    <td class="border border-gray-200 px-2 py-1"></td>
                                    <td class="border border-gray-200 px-2 py-1">{{ $calendarCounter->info_source }}</td>
                                </tr>
                            @else
                                <tr><td colspan="9" class="border border-gray-200 px-2 py-3 text-center text-gray-400">No calendar counter configured.</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="flex flex-wrap justify-end gap-2">
                        <button type="button" class="btn-primary"
                                @click="$dispatch('open-equipment-counters', { equipmentId: {{ $equipment->id }} })">
                            Update Counters
                        </button>
                        <button type="button" class="btn-secondary">Counter History</button>
                        <button type="button" class="btn-secondary">Counters Reading</button>
                        <button type="button" class="btn-secondary">Counter Hierarchy</button>
                    </div>
                </div>
            </div>

            {{-- Stub for other tabs --}}
            @foreach (['general', 'bom', 'modif', 'events', 'properties', 'address', 'trans', 'remark'] as $k)
                <div x-cloak x-show="activeTab === '{{ $k }}'" class="px-2 py-8 text-center text-sm text-gray-400">
                    This tab is not yet implemented.
                </div>
            @endforeach
        </x-enterprise.panel>
    </div>

    @livewire('fleet.equipment-counters-manager')
    @endif
@endsection
