@extends('layouts.app')

@section('title', 'Create Warehouse')

@section('content')
    @livewire('admin.stock.warehouse-form', ['mode' => 'create'])
@endsection
