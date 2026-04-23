@extends('layouts.app')

@section('title', 'Technical Log Types')

@section('content')
    @php
        $rows = App\Models\TechnicalLogType::orderBy('code')->get()->map(fn ($t) => [
            '<code class="text-xs text-gray-500">'.e($t->code).'</code>',
            '<span class="font-medium text-gray-900">'.e($t->name).'</span>',
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Technical Log Types',
        'description' => 'Technical log classification — SAP @MRO_OTLT.',
        'columns' => ['Code', 'Name'],
        'rows' => $rows,
        'source' => '@MRO_OTLT',
    ])
@endsection
