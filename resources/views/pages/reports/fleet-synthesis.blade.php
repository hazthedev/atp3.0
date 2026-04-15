@extends('layouts.app')

@section('title', 'Fleet Synthesis')

@section('content')
    @include('pages.partials.report-page',         array (
          'title' => 'Fleet Synthesis',
          'description' => 'Reporting surface preview for fleet synthesis.',
        ))

@endsection

