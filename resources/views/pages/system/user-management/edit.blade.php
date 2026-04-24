@extends('layouts.app')

@section('title', 'User')

@section('content')
    @livewire('system.user-form', ['userId' => (int) request()->route('id'), 'mode' => 'edit'])
@endsection
