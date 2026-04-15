@extends('layouts.app')

@section('title', 'Manage Status')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Manage Status',
          'description' => 'Configure and review reusable status codes across the platform.',
        ))

@endsection

