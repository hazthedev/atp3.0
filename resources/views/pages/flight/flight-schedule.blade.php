@extends('layouts.app')

@section('title', 'Flight Schedule')

@section('content')
    @include('pages.partials.simple-page',         array (
          'title' => 'Flight Schedule',
          'description' => 'Calendar and table hybrid placeholder for the flight-schedule experience.',
          'sections' => 
          array (
            0 => 
            array (
              'title' => 'Calendar lane',
              'body' => 'This area reserves space for a monthly or weekly planning surface once live schedule data is available.',
            ),
            1 => 
            array (
              'title' => 'Flight strip list',
              'body' => 'Use a synchronized list to show departures, arrivals, and task dependencies beside the calendar.',
            ),
            2 => 
            array (
              'title' => 'Dispatch notes',
              'body' => 'Static cards in the frontend phase preview the density and spacing of operational annotations.',
            ),
          ),
        ))

@endsection

