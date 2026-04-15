@extends('layouts.app')

@section('title', 'Report Information Cockpit')

@section('content')
    @include('pages.partials.cockpit-page',         array (
          'title' => 'Report Information Cockpit',
          'description' => 'Quick visibility into report queues, approvals, and escalations.',
        ))

@endsection

