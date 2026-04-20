@extends('layouts.app')

@section('title', 'Edit User Management')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Edit User Management',
          'description' => 'Frontend-only edit experience for updating an existing user management.',
          'isEdit' => true,
        ))

@endsection

