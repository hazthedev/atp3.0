@extends('layouts.app')

@section('title', 'Aircraft Variants')

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
        'title' => 'Aircraft Variants',
        'description' => 'Aircraft variant / type master — SAP @MRO_OVAR.',
        'columns' => ['Code', 'Name', 'Interface', 'IPC', 'Status'],
        'rows' => $rows,
        'source' => '@MRO_OVAR',
    ])
@endsection
