@extends('layouts.app')

@section('title', 'System Aircraft Type')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'System Aircraft Type',
          'description' => 'Administrative aircraft-type reference list for system settings.',
        ))

@endsection

