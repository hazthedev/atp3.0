@extends('layouts.app')

@section('title', 'Technical Logs')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Technical Logs',
          'description' => 'Preview technical-log list states and action affordances.',
          'createRoute' => 'fleet.technical-logs.create',
        ))

@endsection

