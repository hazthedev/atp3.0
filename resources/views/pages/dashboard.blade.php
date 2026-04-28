@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <x-page-header title="Dashboard" description="Monitor the ATP 3.0 frontend rewrite through reusable stat cards, activity timelines, and launch points into each module." />

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Active modules" value="12" trend="All frontend sections scaffolded" icon="squares-2x2" />
            <x-stat-card label="Pages delivered" value="60+" trend="Route-complete placeholder coverage" icon="document-chart-bar" />
            <x-stat-card label="Pending integrations" value="9" trend="Backend phase required" icon="clock" trend-color="text-amber-600" />
            <x-stat-card label="Critical blockers" value="0" trend="Frontend preview is unblocked" icon="check-circle" />
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.35fr_1fr]">
            <x-card title="Recent activity" description="Static preview of the dashboard feed that will later be wired to live events.">
                <div class="space-y-4">
                    @foreach ([
                        ['title' => 'Fleet management cockpit refreshed', 'time' => '10 minutes ago', 'tone' => 'bg-blue-50 text-blue-700'],
                        ['title' => 'Business partner workflow staged for backend integration', 'time' => '45 minutes ago', 'tone' => 'bg-emerald-50 text-emerald-700'],
                        ['title' => 'Maintenance plan simulation flagged for review', 'time' => '2 hours ago', 'tone' => 'bg-amber-50 text-amber-700'],
                        ['title' => 'System administration views added to navigation', 'time' => 'Yesterday', 'tone' => 'bg-gray-100 text-gray-700'],
                    ] as $item)
                        <div class="flex gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <div class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full {{ $item['tone'] }}"></div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $item['title'] }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $item['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <div class="space-y-6">
                <x-card title="Quick actions" description="Launch common flows from the dashboard without drilling into the menu.">
                    <div class="grid gap-3">
                        <a href="{{ route('business-partners.business-partner-master-data.create') }}" class="btn-primary justify-start">
                            <x-icon name="plus" class="h-4 w-4" />
                            Create business partner
                        </a>
                        <a href="{{ route('fleet.functional-location.create') }}" class="btn-secondary justify-start">Add functional location</a>
                        <a href="{{ route('maintenance.maintenance-program.create') }}" class="btn-secondary justify-start">Draft maintenance program</a>
                        <a href="{{ route('services.contact-report.create') }}" class="btn-secondary justify-start">Log contact report</a>
                    </div>
                </x-card>

                <x-card title="Frontend status" description="Acceptance cues for this phase.">
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3">
                            <span>Reusable components</span>
                            <x-badge color="success">Ready</x-badge>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3">
                            <span>Placeholder data coverage</span>
                            <x-badge color="info">Complete</x-badge>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3">
                            <span>Backend integration</span>
                            <x-badge color="warning">Next phase</x-badge>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
@endsection
