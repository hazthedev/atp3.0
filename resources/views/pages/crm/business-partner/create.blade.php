@extends('layouts.app')

@section('title', 'Create Business Partner')

@section('content')
    @include('pages.crm.business-partner.partials.form', ['mode' => 'create'])
@endsection

