@extends('layouts.app')

@section('title', 'Airworthiness Review')

@section('content')
    <div class="flex min-h-64 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-white">
        <div class="max-w-xl space-y-3 text-center">
            <p class="text-sm font-medium text-gray-500">This page is under construction.</p>
            <div class="space-y-2 text-left">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Planned feature</p>
                <p class="text-xs text-gray-500">
                    Check the airworthiness of a Functional Location by aggregating its open
                    operational items:
                </p>
                <ul class="list-disc space-y-1 pl-5 text-xs text-gray-500">
                    <li>Open Work Packages / Work Orders</li>
                    <li>Overdue Visits and Tasks</li>
                    <li>Open Defects</li>
                    <li>Configuration Control state</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
