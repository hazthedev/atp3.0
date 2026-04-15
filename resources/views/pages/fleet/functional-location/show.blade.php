@extends('layouts.app')

@section('title', 'Customer Functional Location')

@section('content')
    @livewire('fleet.customer-functional-location-page', ['recordId' => (int) request()->route('id')])
@endsection

