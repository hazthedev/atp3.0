@extends('layouts.auth')

@section('title', '500')

@section('content')
    <x-card padding="p-10" class="text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-300">
            <x-icon name="exclamation-triangle" class="h-8 w-8" />
        </div>
        <h1 class="mt-4 text-6xl font-bold text-gray-900">500</h1>
        <h2 class="mt-2 text-xl font-semibold text-gray-700">Something went wrong</h2>
        <p class="mt-2 text-sm text-gray-500">Unexpected failures will land here once live data and backend workflows are connected.</p>
        <a href="{{ route('dashboard') }}" class="btn-primary mt-6 inline-flex">Go to dashboard</a>
    </x-card>
@endsection
