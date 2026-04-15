@extends('layouts.auth')

@section('title', '403')

@section('content')
    <x-card padding="p-10" class="text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-300">
            <x-icon name="lock-closed" class="h-8 w-8" />
        </div>
        <h1 class="mt-4 text-6xl font-bold text-gray-900">403</h1>
        <h2 class="mt-2 text-xl font-semibold text-gray-700">Access denied</h2>
        <p class="mt-2 text-sm text-gray-500">Permissions are not enforced yet, but this page preserves the final error-state layout.</p>
        <a href="{{ route('dashboard') }}" class="btn-primary mt-6 inline-flex">Go to dashboard</a>
    </x-card>
@endsection
