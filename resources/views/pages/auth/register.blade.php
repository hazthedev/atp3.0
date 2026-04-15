@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <x-card title="Create preview account" description="Registration is visual-only for this phase and does not persist data." padding="p-8">
        <div class="space-y-4">
            <x-form.input label="Full name" name="name" placeholder="Test User" />
            <x-form.input label="Email address" name="email" type="email" placeholder="test@example.com" />
            <x-form.select label="Role" name="role" :options="['admin' => 'Administrator', 'planner' => 'Planner', 'viewer' => 'Viewer']" />
            <x-form.input label="Password" name="password" type="password" />
            <x-form.input label="Confirm password" name="password_confirmation" type="password" />
            <x-form.checkbox name="terms" label="I understand this is a frontend-only preview." :checked="true" />
        </div>

        <div class="mt-6 space-y-3">
            <a href="{{ route('dashboard') }}" class="btn-primary w-full justify-center">Create account</a>
            <a href="{{ route('login') }}" class="btn-secondary w-full justify-center">Back to sign in</a>
        </div>
    </x-card>
@endsection
