@extends('layouts.app')

@section('title', 'MEL Categories')

@section('content')
    @php
        $rows = App\Models\MelCategory::orderBy('name')->get()->map(fn ($c) => [
            '<code class="text-xs text-gray-500">'.e($c->code).'</code>',
            '<span class="font-semibold text-gray-900">'.e($c->name).'</span>',
            e($c->description),
            '<span class="font-mono">'.e($c->duration_days).' d</span>',
            $c->only_one
                ? '<span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">Yes</span>'
                : '<span class="text-gray-400">—</span>',
        ])->all();
    @endphp

    @include('pages.partials.reference-table-page', [
        'title' => 'MEL Categories',
        'description' => 'Minimum Equipment List categories and their deferral durations — SAP @MRO_OCML.',
        'columns' => ['Code', 'Short', 'Description', 'Duration', 'Only one'],
        'rows' => $rows,
        'source' => '@MRO_OCML',
    ])
@endsection
