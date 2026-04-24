@extends('layouts.app')

@section('title', 'Create Item Group')

@section('content')
    @livewire('admin.stock.item-group-form', ['mode' => 'create'])
@endsection
