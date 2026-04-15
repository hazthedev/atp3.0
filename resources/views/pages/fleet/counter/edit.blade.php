@extends('layouts.app')

@section('title', 'Edit Counter')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Edit Counter',
          'description' => 'Modify counter thresholds, references, and labels.',
        ))

@endsection

