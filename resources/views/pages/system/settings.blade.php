@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Settings',
          'description' => 'Global system settings shell with reusable form sections.',
        ))

@endsection

