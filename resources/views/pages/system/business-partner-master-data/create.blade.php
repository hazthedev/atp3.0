@extends('layouts.app')

@section('title', 'Create Business Partner Master Data')

@section('content')
    @include('pages.system.business-partner-master-data.partials.form', ['mode' => 'create'])
@endsection
