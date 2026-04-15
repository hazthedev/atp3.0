@extends('layouts.app')

@section('title', 'Service Contract')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Service Contract',
          'description' => 'Frontend list preview for the Service Contract service area.',
          'createRoute' => 'services.service-contract.create',
        ))

@endsection

