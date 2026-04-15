@extends('layouts.app')

@section('title', 'Time Tracking')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Time Tracking',
          'description' => 'Preview time-tracking entries and approval states.',
        ))

@endsection

