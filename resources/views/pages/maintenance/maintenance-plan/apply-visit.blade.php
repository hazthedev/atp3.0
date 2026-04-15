@extends('layouts.app')

@section('title', 'Apply Visits and Task Lists')

@section('content')
    @livewire('maintenance.apply-visit-and-task-list-page', ['initialTab' => 'visit'])
@endsection

