@extends('layouts.app')

@section('title', 'Receiving & Shipping')

@section('content')
    @include('pages.partials.form-page',         array (
          'title' => 'Receiving & Shipping',
          'description' => 'Combined receiving and shipping workflow preview for MRO coordination.',
        ))

@endsection

