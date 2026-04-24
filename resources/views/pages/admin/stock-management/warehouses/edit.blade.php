@extends('layouts.app')

@section('title', 'Warehouse')

@section('content')
    @livewire('admin.stock.warehouse-form', ['warehouseId' => (int) request()->route('id'), 'mode' => 'edit'])
@endsection
