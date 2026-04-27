@extends('layouts.app')

@section('title', 'Task Types')

@section('content')
    @php
        $types = App\Models\TaskType::orderBy('name')->get();
        $primary = ['AD/SB', 'EOAS', 'OOP', 'Kardex', 'Others', 'Checks', 'Aircraft AD/SB'];
        $rows = $types->map(function ($t) use ($primary) {
            $badge = in_array($t->name, $primary, true)
                ? '<span class="ml-2 inline-flex rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">Fleet Dashboard primary</span>'
                : '';
            return [
                '<code class="text-xs text-gray-500">'.e($t->code).'</code>',
                '<span class="font-medium text-gray-900">'.e($t->name).'</span>'.$badge,
            ];
        })->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Task Types',
        'description' => 'Task type catalogue from SAP @MRO_OTAT. Seven of these are the primary Fleet Dashboard matrix columns (AD/SB, EOAS, OOP, Kardex, Others, Checks, MEL/CFD).',
        'columns' => ['Code', 'Name'],
        'rows' => $rows,
        'source' => '@MRO_OTAT',
    ])
@endsection
