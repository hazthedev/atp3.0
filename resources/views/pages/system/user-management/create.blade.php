@extends('layouts.app')

@section('title', 'Create User Management')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Create User Management',
          'description' => 'Frontend-only form shell for creating a new user management.',
        ))

@endsection

