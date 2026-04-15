@extends('layouts.app')

@section('title', 'Customer Equipment Card')

@section('content')
    @livewire('fleet.customer-equipment-card-page', ['recordId' => (int) request()->route('id')])
@endsection

