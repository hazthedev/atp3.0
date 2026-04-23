@extends('layouts.app')

@section('title', 'Category Parts')

@section('content')
    @php
        $rows = App\Models\CategoryPart::orderBy('name')->get()->map(fn ($p) => [
            '<code class="text-xs text-gray-500">'.e($p->code).'</code>',
            '<span class="font-medium text-gray-900">'.e($p->name).'</span>',
            $p->work_scope
                ? '<span class="inline-flex rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">Yes</span>'
                : '<span class="text-gray-400">—</span>',
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Category Parts',
        'description' => 'Component categorisation (H/T LLP, Engine L/R, APU, pilot/co-pilot displays) — SAP @MRO_OCAT.',
        'columns' => ['Code', 'Name', 'Work scope?'],
        'rows' => $rows,
        'source' => '@MRO_OCAT',
    ])
@endsection
