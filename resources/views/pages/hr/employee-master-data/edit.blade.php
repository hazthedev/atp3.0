@extends('layouts.app')

@section('title', 'Employee Master Data')

@section('content')
    @livewire('hr.employee-master-data-form', ['employeeId' => (int) request()->route('id')])
@endsection
