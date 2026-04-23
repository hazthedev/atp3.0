@extends('layouts.app')

@section('title', 'Visits')

@section('content')
    @php
        $visits = App\Models\Visit::orderBy('sort_order')->get();
        $rows = $visits->map(fn ($v) => [
            '<code class="text-xs text-gray-500">'.e($v->code).'</code>',
            '<span class="font-medium text-gray-900">'.e($v->name).'</span>',
            e($v->sort_order),
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'Visits',
        'description' => 'Visit templates driven by SAP @MRO_OVST. Each row can be attached to a Maintenance Program via @MRO_MPV1.',
        'columns' => ['Code', 'Name', 'Sort'],
        'rows' => $rows,
        'source' => '@MRO_OVST',
    ])
@endsection
