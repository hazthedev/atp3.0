@extends('layouts.app')

@section('title', 'System Functional Location')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'System Functional Location',
          'description' => 'Reference-level functional location administration list.',
        ))

@endsection

