@extends('layouts.app')

@section('title', 'Fleet Management Cockpit')

@section('content')
    @include('pages.partials.fleet-management-cockpit-page', [
        'title' => 'Fleet Management Cockpit',
        'description' => 'Structure-and-log cockpit for fleet snapshots, hierarchy browsing, and counter follow-up.',
    ])
@endsection
