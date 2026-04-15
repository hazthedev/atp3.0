@extends('layouts.app')

@section('title', 'Time Tracking')

@section('content')
    @include('pages.partials.report-page',         array (
          'title' => 'Time Tracking',
          'description' => 'Reporting surface preview for time tracking.',
        ))

@endsection

