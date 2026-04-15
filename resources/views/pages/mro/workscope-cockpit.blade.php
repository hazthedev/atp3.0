@extends('layouts.app')

@section('title', 'Workscope Cockpit')

@section('content')
    @include('pages.partials.cockpit-page',         array (
          'title' => 'Workscope Cockpit',
          'description' => 'View workscope progress and readiness from a cockpit layout.',
        ))

@endsection

