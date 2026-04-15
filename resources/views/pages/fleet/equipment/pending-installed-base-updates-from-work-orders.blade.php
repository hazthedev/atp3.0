@extends('layouts.app')

@section('title', 'Pending Installed Base updates from Work Orders')

@section('content')
    @livewire('fleet.pending-installed-base-updates-page', ['context' => 'equipment'])
@endsection

