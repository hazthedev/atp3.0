@extends('layouts.app')

@section('title', 'Tasklist')

@section('content')
    @include('pages.partials.search-page',         array (
          'title' => 'Tasklist',
          'description' => 'Filterable tasklist experience with a results grid preview.',
        ))

@endsection

