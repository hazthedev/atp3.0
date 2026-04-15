@extends('layouts.app')

@section('title', 'Operations Fleet Management Cockpit')

@section('content')
    @include('pages.partials.fleet-management-cockpit-page', [
        'title' => 'Operations Fleet Management Cockpit',
        'description' => 'Operations-oriented cockpit for structure review, hierarchy traces, and message follow-up.',
    ])
@endsection
