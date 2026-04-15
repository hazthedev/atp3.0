@extends('layouts.app')

@section('title', 'Equipment Card')

@section('content')
    @include('pages.partials.show-page',         array (
          'title' => 'Equipment Card',
          'description' => 'Preview the card layout for equipment summaries at the functional location level.',
        ))

@endsection

