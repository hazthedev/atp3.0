@extends('layouts.app')

@section('title', 'Edit Business Partner Master Data')

@section('content')
    @include('pages.system.business-partner-master-data.partials.form', [
        'mode' => 'edit',
        'recordId' => request()->route('id'),
    ])
@endsection
