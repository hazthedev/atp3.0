@extends('layouts.app')

@section('title', 'Generate Customer Equipment Card')

@section('content')
    @livewire('fleet.generate-equipment-card-page', ['mode' => 'customer'])
@endsection

