@extends('layouts.app')

@section('title', 'Generate Equipment Card')

@section('content')
    @livewire('fleet.generate-equipment-card-page', ['mode' => 'standard'])
@endsection

