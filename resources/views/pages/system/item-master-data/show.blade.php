@extends('layouts.app')

@section('title', 'Item Master Data')

@section('content')
    @include('pages.system.item-master-data.partials.form', [
        'mode' => 'show',
        'recordId' => request()->route('id'),
    ])
@endsection
