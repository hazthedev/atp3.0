@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Profile',
          'description' => 'User profile editing surface for the frontend preview.',
        ))

@endsection

