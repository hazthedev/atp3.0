@extends('layouts.app')

@section('title', 'Equipment Information')

@section('content')
    @include('pages.partials.show-page',         array (
          'title' => 'Equipment Information',
          'description' => 'Overview of equipment metadata, ownership, and reporting context.',
        ))

@endsection

