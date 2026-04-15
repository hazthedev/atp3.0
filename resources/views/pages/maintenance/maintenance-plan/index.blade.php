@extends('layouts.app')

@section('title', 'Maintenance Plan')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Maintenance Plan',
          'description' => 'Browse maintenance plans and staging scenarios.',
        ))

@endsection

