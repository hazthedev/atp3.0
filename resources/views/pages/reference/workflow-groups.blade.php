@extends('layouts.app')

@section('title', 'Workflow Groups')

@section('content')
    @php
        $rows = App\Models\WorkflowGroup::orderBy('name')->get()->map(fn ($g) => [
            '<code class="text-xs text-gray-500">'.e($g->code).'</code>',
            '<span class="font-medium text-gray-900">'.e($g->name).'</span>',
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Workflow Groups',
        'description' => 'Workflow group master — SAP @MRO_OWFG. Paired with @MRO_OSTA to define status transitions per object type.',
        'columns' => ['Code', 'Name'],
        'rows' => $rows,
        'source' => '@MRO_OWFG',
    ])
@endsection
