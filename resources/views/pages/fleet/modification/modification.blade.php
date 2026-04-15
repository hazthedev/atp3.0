@extends('layouts.app')

@section('title', 'Modification')

@section('content')
    <div class="space-y-6">
        <x-page-header
            title="Modification"
            description="Blank modification workspace until a record is selected from Search Modifications."
        >
            <x-slot name="actions">
                <a href="{{ route('fleet.modification.index') }}" class="btn-primary">Search Modifications</a>
            </x-slot>
        </x-page-header>

        <x-empty-state
            icon="magnifying-glass"
            label="No modification selected"
            description="Open Search Modifications and click a Unique Ref. row to populate this workspace with the selected modification package."
        >
            <a href="{{ route('fleet.modification.index') }}" class="btn-primary">Go to Search Modifications</a>
        </x-empty-state>
    </div>
@endsection

