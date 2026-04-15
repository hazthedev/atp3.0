@extends('layouts.app')

@section('title', 'Fleet Report')

@section('content')
    @include('pages.partials.report-page',         array (
          'title' => 'Fleet Report',
          'description' => 'Reporting surface preview for fleet report.',
        ))

@endsection

