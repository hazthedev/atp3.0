@extends('layouts.app')

@section('title', 'Create Counter')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Create Counter',
          'description' => 'Add a counter definition used for monitoring fleet utilization.',
        ))

@endsection

