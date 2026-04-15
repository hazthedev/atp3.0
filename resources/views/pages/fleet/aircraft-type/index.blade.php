@extends('layouts.app')

@section('title', 'Aircraft Type')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Aircraft Type',
          'description' => 'Manage aircraft-type reference data with an inline modal for quick adds.',
          'columns' => 
          array (
            0 => 'Type',
            1 => 'Manufacturer',
            2 => 'Configuration',
            3 => 'Status',
            4 => 'Updated',
          ),
        ))

    <div class="flex justify-end">
        <button type="button" class="btn-secondary" @click="$dispatch('open-modal', { id: 'aircraft-type-create' })">Quick add aircraft type</button>
    </div>
@endsection

@push('modals')
    <x-modal id="aircraft-type-create" title="Quick Add Aircraft Type">
        <div class="grid gap-4 md:grid-cols-2">
            <x-form.input label="Aircraft type" name="aircraft_type_name" placeholder="AW139" />
            <x-form.input label="Manufacturer" name="manufacturer" placeholder="Leonardo" />
            <x-form.select label="Configuration" name="configuration" :options="['vip' => 'VIP', 'utility' => 'Utility', 'medical' => 'Medical']" />
            <x-form.select label="Status" name="status" :options="['active' => 'Active', 'planned' => 'Planned']" />
        </div>
        <x-slot name="footer">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', { id: 'aircraft-type-create' })">Cancel</button>
            <button type="button" class="btn-primary">Save aircraft type</button>
        </x-slot>
    </x-modal>
@endpush
