@extends('layouts.app')

@section('title', 'Edit Business Partner')

@section('content')
    @include('pages.crm.business-partner.partials.form', [
        'mode' => 'edit',
        'recordId' => (int) request()->route('id'),
    ])
@endsection

