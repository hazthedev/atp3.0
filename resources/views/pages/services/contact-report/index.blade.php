@extends('layouts.app')

@section('title', 'Contact Report')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Contact Report',
          'description' => 'Frontend list preview for the Contact Report service area.',
          'createRoute' => 'services.contact-report.create',
        ))

@endsection

