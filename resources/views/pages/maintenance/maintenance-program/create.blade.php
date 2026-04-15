@extends('layouts.app')

@section('title', 'Create Maintenance Program')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Create Maintenance Program',
          'description' => 'Frontend-only form shell for creating a new maintenance program.',
        ))

@endsection

