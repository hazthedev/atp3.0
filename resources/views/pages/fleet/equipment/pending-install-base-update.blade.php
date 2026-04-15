@extends('layouts.app')

@section('title', 'Pending Install Base Update')

@section('content')
    @livewire('fleet.pending-installed-base-updates-page', ['context' => 'equipment'])
@endsection

