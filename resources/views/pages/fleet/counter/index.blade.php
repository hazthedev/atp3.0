@extends('layouts.app')

@section('title', 'Counter')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Counter',
          'description' => 'Review fleet counters and their synchronization states.',
          'createRoute' => 'fleet.counter.create',
        ))

@endsection

