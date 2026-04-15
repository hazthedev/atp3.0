@extends('layouts.app')

@section('title', 'Fleet Maintenance Plan')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Fleet Maintenance Plan',
          'description' => 'Fleet-linked maintenance planning overview for quick navigation.',
        ))

@endsection

