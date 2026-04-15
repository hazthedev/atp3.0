@extends('layouts.app')

@section('title', 'Flight Record')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Flight Record',
          'description' => 'Track flight records, crew metadata, and operational events in list form.',
          'createRoute' => 'flight.flight-record.create',
        ))

@endsection

