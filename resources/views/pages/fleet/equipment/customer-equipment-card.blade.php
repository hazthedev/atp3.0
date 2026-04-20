@extends('layouts.app')

@section('title', 'Customer Equipment Card')

@section('content')
    @livewire('fleet.customer-equipment-card-page', ['recordId' => request('id'), 'emptyState' => request('id') === null])
@endsection
