@extends('layouts.app')

@section('title', 'Edit Functional Location')

@section('content')
    @php
        $recordId = (int) request()->route('id');
        $record = \App\Support\FunctionalLocationCatalog::find($recordId);
        abort_if($record === null, 404);
    @endphp

    @include('pages.partials.functional-location-show-page', [
        'title'       => 'Edit Functional Location',
        'description' => 'Adjust the functional location hierarchy, naming, and planning metadata.',
        'emptyState'  => false,
        'readonly'    => false,
        'recordId'    => $recordId,
        'record'      => $record,
    ])
@endsection
