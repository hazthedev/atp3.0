@extends('layouts.app')

@section('title', 'Create Item Master Data')

@section('content')
    @include('pages.system.item-master-data.partials.form', ['mode' => 'create'])
@endsection

