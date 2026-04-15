@extends('layouts.app')

@section('title', 'Edit Item Master Data')

@section('content')
    @include('pages.system.item-master-data.partials.form', [
        'mode' => 'edit',
        'recordId' => request()->route('id'),
    ])
@endsection

