@extends('layouts.app')

@section('title', 'Customer Functional Location')

@section('content')
    @php
        $recordId = (int) request()->route('id');
        $record = \App\Support\FunctionalLocationCatalog::find($recordId);
        abort_if($record === null, 404);
    @endphp

    @include('pages.partials.functional-location-show-page', [
        'title'       => 'Customer Functional Location',
        'description' => 'Detail workspace for the selected aircraft record.',
        'emptyState'  => false,
        'readonly'    => true,
        'recordId'    => $recordId,
        'record'      => $record,
    ])
@endsection
