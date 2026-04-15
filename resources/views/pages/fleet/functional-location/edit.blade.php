@extends('layouts.app')

@section('title', 'Edit Functional Location')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Edit Functional Location',
          'description' => 'Adjust the functional location hierarchy, naming, and planning metadata.',
        ))

@endsection

