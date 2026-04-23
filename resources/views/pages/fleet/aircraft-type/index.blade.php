@extends('layouts.app')

@section('title', 'Aircraft Type')

@section('content')
    @php
        $rows = App\Models\AircraftVariant::orderBy('name')->get()->map(fn ($v) => [
            '<code class="text-xs text-gray-500">'.e($v->code).'</code>',
            '<span class="font-semibold text-gray-900">'.e($v->name).'</span>',
            e($v->interface_code ?? '—'),
            e($v->ipc_code ?? '—'),
            $v->is_inactive
                ? '<span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">Inactive</span>'
                : '<span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Active</span>',
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Aircraft Type',
        'description' => 'Aircraft variant / type master — SAP @MRO_OVAR. Used across the fleet as the primary A/C classification.',
        'columns' => ['Code', 'Name', 'Interface', 'IPC', 'Status'],
        'rows' => $rows,
        'source' => '@MRO_OVAR',
    ])

    <div class="flex justify-end">
        <button type="button" class="btn-secondary" @click="$dispatch('open-modal', { id: 'aircraft-type-create' })">Quick add aircraft type</button>
    </div>
@endsection

@push('modals')
    <x-modal id="aircraft-type-create" title="Quick Add Aircraft Type">
        <div class="grid gap-4 md:grid-cols-2">
            <x-form.input label="Aircraft type" name="aircraft_type_name" placeholder="AW139" />
            <x-form.input label="Manufacturer" name="manufacturer" placeholder="Leonardo" />
            <x-form.select label="Configuration" name="configuration" :options="['vip' => 'VIP', 'utility' => 'Utility', 'medical' => 'Medical']" />
            <x-form.select label="Status" name="status" :options="['active' => 'Active', 'planned' => 'Planned']" />
        </div>
        <x-slot name="footer">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', { id: 'aircraft-type-create' })">Cancel</button>
            <button type="button" class="btn-primary">Save aircraft type</button>
        </x-slot>
    </x-modal>
@endpush
