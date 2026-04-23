@extends('layouts.app')

@section('title', 'Manage Status')

@section('content')
    @php
        $statuses = App\Models\MroStatusObject::orderBy('name')->get();
        $rows = $statuses->map(function ($s) {
            $badge = $s->locked
                ? '<span class="ml-2 inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700">Locked</span>'
                : '';
            return [
                '<code class="text-xs text-gray-500">'.e($s->code).'</code>',
                '<span class="font-medium text-gray-900">'.e($s->name).'</span>'.$badge,
                e($s->description ?? '—'),
            ];
        })->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Manage Status',
        'description' => 'Unified status lifecycle master for every object in the system — SAP @MRO_OSTA. Used by task lists, visits, work orders, work packages, technical logs, and aircraft airworthiness.',
        'columns' => ['Code', 'Name', 'Description'],
        'rows' => $rows,
        'source' => '@MRO_OSTA',
    ])
@endsection
