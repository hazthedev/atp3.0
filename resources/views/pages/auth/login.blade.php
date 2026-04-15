@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <x-card title="Welcome back" description="Sign in to preview the Laravel 12 frontend shell for ATP 3.0." padding="p-8">
        <div class="space-y-6">
            <div class="flex items-center justify-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-lg font-bold text-white shadow-md">A3</div>
            </div>

            <div class="space-y-4">
                <x-form.input label="Email address" name="email" type="email" value="test@example.com" />
                <x-form.input label="Password" name="password" type="password" value="password" />
                <x-form.checkbox name="remember" label="Keep me signed in on this device" :checked="true" />
            </div>

            <div class="space-y-3">
                <a href="{{ route('dashboard') }}" class="btn-primary w-full justify-center">Sign in</a>
                <a href="{{ route('register') }}" class="btn-secondary w-full justify-center">Create an account</a>
            </div>

            <p class="text-center text-xs text-gray-500">Guest authentication is stubbed in this frontend phase. Use any route to continue exploring the UI.</p>
        </div>
    </x-card>
@endsection
