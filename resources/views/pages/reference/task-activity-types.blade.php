@extends('layouts.app')

@section('title', 'Task Activity Types')

@section('content')
    @php
        $rows = App\Models\TaskActivityType::orderBy('name')->get()->map(fn ($t) => [
            '<code class="text-xs text-gray-500">'.e($t->code).'</code>',
            '<span class="font-medium text-gray-900">'.e($t->name).'</span>',
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Task Activity Types',
        'description' => 'Activities performed against a task (overhaul, inspection, removal, etc.) — SAP @MRO_OATY.',
        'columns' => ['Code', 'Name'],
        'rows' => $rows,
        'source' => '@MRO_OATY',
    ])
@endsection
