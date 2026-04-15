@extends('layouts.app')

@section('title', 'Create Activities')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Create Activities',
          'description' => 'Static placeholder form for creating a new activities entry.',
        ))

@endsection

