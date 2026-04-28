@extends('layouts.app')

@section('title', 'Business Partner Master Data')

@section('content')
    @include('pages.system.business-partner-master-data.partials.form', [
        'mode' => 'show',
        'recordId' => request()->route('id'),
    ])
@endsection
