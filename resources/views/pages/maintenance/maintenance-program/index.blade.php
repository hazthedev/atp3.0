@extends('layouts.app')

@section('title', 'Maintenance Program')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Maintenance Program',
          'description' => 'Static placeholder list view for the Maintenance Program module.',
          'createRoute' => 'maintenance.maintenance-program.create',
        ))

@endsection

