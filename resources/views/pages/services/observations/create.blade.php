@extends('layouts.app')

@section('title', 'Create Observations')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Create Observations',
          'description' => 'Static placeholder form for creating a new observations entry.',
        ))

@endsection

