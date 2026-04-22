@extends('layouts.app')

@section('title', 'Edit Maintenance Program')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Edit Maintenance Program',
          'description' => 'Frontend-only edit experience for updating an existing maintenance program.',
          'isEdit' => true,
        ))

@endsection

