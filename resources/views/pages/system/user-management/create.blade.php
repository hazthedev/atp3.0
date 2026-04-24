@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    @livewire('system.user-form', ['mode' => 'create'])
@endsection
