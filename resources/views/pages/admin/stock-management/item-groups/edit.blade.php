@extends('layouts.app')

@section('title', 'Item Group')

@section('content')
    @livewire('admin.stock.item-group-form', ['itemGroupId' => (int) request()->route('id'), 'mode' => 'edit'])
@endsection
