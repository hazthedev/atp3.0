@extends('layouts.app')

@section('title', 'Aircraft Card')

@section('content')
    @php
        $registration = request()->route('registration');
        $params = $registration ? ['registration' => $registration] : [];
    @endphp

    @livewire('fleet.aircraft-card-page', $params)
@endsection
