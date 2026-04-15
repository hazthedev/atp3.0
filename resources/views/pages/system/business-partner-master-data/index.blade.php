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

        <x-data-table datatable>
            <x-slot name="thead">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>BP Group</th>
                    <th>BP Type</th>
                    <th>Currency</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th data-sortable="false">Actions</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($partners as $partner)
                    <tr class="hover:bg-neutral-secondary-soft cursor-pointer">
                        <td class="font-medium text-heading whitespace-nowrap">
                            <a href="{{ route('system.business-partner-master-data.edit', ['id' => $partner['id']]) }}" class="font-semibold text-[#2f5bff] transition hover:text-[#284ef0] hover:underline">
                                {{ $partner['code'] }}
                            </a>
                        </td>
                        <td>{{ $partner['name'] }}</td>
                        <td>{{ $partner['bp_group'] }}</td>
                        <td>{{ $partner['bp_type'] }}</td>
                        <td>{{ $partner['currency'] }}</td>
                        <td>{{ $partner['contact_person'] }}</td>
                        <td>{{ $partner['email'] }}</td>
                        <td>{{ $partner['status'] }}</td>
                        <td>
                            <a
                                href="{{ route('system.business-partner-master-data.edit', ['id' => $partner['id']]) }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-[#9fb2ff] hover:text-[#2f5bff]"
                            >
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>
    </div>
@endsection
