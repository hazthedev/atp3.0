@extends('layouts.app')

@section('title', 'Component History')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Component History',
          'description' => 'Review historical component activity tied to a functional location.',
        ))

@endsection

