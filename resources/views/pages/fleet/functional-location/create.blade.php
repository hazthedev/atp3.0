@extends('layouts.app')

@section('title', 'Create Functional Location')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Create Functional Location',
          'description' => 'Establish a new functional location within the fleet structure.',
        ))

@endsection

