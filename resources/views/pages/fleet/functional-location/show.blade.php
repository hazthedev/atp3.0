@extends('layouts.app')

@section('title', 'Customer Functional Location')

@section('content')
    @php
        $recordId = (int) request()->route('id');
        $dbFl = \App\Models\FunctionalLocation::with(['item', 'counters.counterRef', 'calendarCounter'])->find($recordId);

        if ($dbFl !== null) {
            $record = [
                'id' => (string) $dbFl->id,
                'code' => $dbFl->code,
                'serial_no' => $dbFl->serial_no ?? '',
                'registration' => $dbFl->registration ?? '',
                'type' => $dbFl->type ?? '',
                'mel' => $dbFl->mel ?? '',
                'status' => $dbFl->status ?? '',
                'maintenance_plan' => $dbFl->maintenance_plan ?? '',
                'owner_code' => $dbFl->owner_code ?? '',
                'owner_name' => $dbFl->owner_name ?? '',
                'operator_code' => $dbFl->operator_code ?? '',
                'operator_name' => $dbFl->operator_name ?? '',
            ];
        } else {
            $record = \App\Support\FunctionalLocationCatalog::find($recordId);
            abort_if($record === null, 404);
        }

        $dbFlCounters = $dbFl?->counters
            ->sortBy(fn ($c) => $c->counterRef?->sort_order ?? 999)
            ->values() ?? collect();
        $dbFlCalendarCounter = $dbFl?->calendarCounter;
    @endphp

    @include('pages.partials.functional-location-show-page', [
        'title'       => 'Customer Functional Location',
        'description' => 'Detail workspace for the selected aircraft record.',
        'emptyState'  => false,
        'readonly'    => true,
        'recordId'    => $recordId,
        'record'      => $record,
        'flModel'     => $dbFl,
        'dbFlCounters' => $dbFlCounters,
        'dbFlCalendarCounter' => $dbFlCalendarCounter,
    ])

    @livewire('fleet.functional-location-counters-manager')
@endsection
