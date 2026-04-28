@extends('layouts.app')

@section('title', 'Business Partner Master Data')

@php
    $partners = [
        ['id' => 300028, 'code' => '300028', 'name' => 'Weststar Aviation Services Sdn. Bhd.', 'bp_group' => 'Trade Debtor', 'bp_type' => 'Company', 'currency' => 'MYR', 'contact_person' => 'Ahmad Shahrul', 'email' => 'ops@weststar.com.my', 'status' => 'Active'],
        ['id' => 300121, 'code' => '300121', 'name' => 'MHS Aviation Berhad', 'bp_group' => 'Trade Debtor', 'bp_type' => 'Company', 'currency' => 'MYR', 'contact_person' => 'Siti Aisyah Omar', 'email' => 'finance@mhsaviation.com', 'status' => 'Active'],
        ['id' => 300155, 'code' => '300155', 'name' => 'Aero One Services Pte. Ltd.', 'bp_group' => 'Trade Creditor', 'bp_type' => 'Company', 'currency' => 'USD', 'contact_person' => 'Nadiah Rahman', 'email' => 'vendor.control@aeroone.com', 'status' => 'Onboarding'],
        ['id' => 300418, 'code' => '300418', 'name' => 'Weststar Shared Services', 'bp_group' => 'Intercompany', 'bp_type' => 'Company', 'currency' => 'MYR', 'contact_person' => 'Nur Izzati', 'email' => 'shared.services@weststar.com.my', 'status' => 'Active'],
        ['id' => 300882, 'code' => '300882', 'name' => 'Heli Support APAC', 'bp_group' => 'Prospect', 'bp_type' => 'Company', 'currency' => 'AUD', 'contact_person' => 'Marco Bellini', 'email' => 'marco.bellini@helisupport-apac.com', 'status' => 'Prospect'],
    ];
@endphp

@section('content')
    <div class="space-y-6">
        <x-page-header
            title="Business Partner Master Data"
            description="Search and maintain business partner master-data records."
        >
            <x-slot name="actions">
                <a href="{{ route('system.business-partner-master-data.create') }}" class="btn-primary">
                    <x-icon name="plus" class="h-4 w-4" />
                    New Business Partner
                </a>
            </x-slot>
        </x-page-header>

        <p class="text-sm text-gray-500">Browse {{ count($partners) }} business partner records.</p>

        <x-data-table
            :empty="count($partners) === 0"
            empty-label="No business partners found"
            empty-description="Try a different code, name, or BP group."
            search-meta=""
            datatable
        >
            <x-slot name="thead">
                <tr>
                    <th class="table-th">Code</th>
                    <th class="table-th">Name</th>
                    <th class="table-th">BP Group</th>
                    <th class="table-th">BP Type</th>
                    <th class="table-th">Currency</th>
                    <th class="table-th">Contact Person</th>
                    <th class="table-th">Email</th>
                    <th class="table-th">Status</th>
                    <th class="table-th" data-sortable="false">Actions</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($partners as $partner)
                    <tr class="table-row">
                        <td class="table-td">
                            <a href="{{ route('system.business-partner-master-data.show', ['id' => $partner['id']]) }}" class="font-semibold text-blue-600 hover:underline">
                                {{ $partner['code'] }}
                            </a>
                        </td>
                        <td class="table-td">{{ $partner['name'] }}</td>
                        <td class="table-td">{{ $partner['bp_group'] }}</td>
                        <td class="table-td">{{ $partner['bp_type'] }}</td>
                        <td class="table-td">{{ $partner['currency'] }}</td>
                        <td class="table-td">{{ $partner['contact_person'] }}</td>
                        <td class="table-td">{{ $partner['email'] }}</td>
                        <td class="table-td">{{ $partner['status'] }}</td>
                        <td class="table-td">
                            <div class="flex gap-2">
                                <a href="{{ route('system.business-partner-master-data.show', ['id' => $partner['id']]) }}" class="btn-ghost px-3">View</a>
                                <a href="{{ route('system.business-partner-master-data.edit', ['id' => $partner['id']]) }}" class="btn-secondary px-3">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>
    </div>
@endsection
