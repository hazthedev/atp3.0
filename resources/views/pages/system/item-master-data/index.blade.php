@extends('layouts.app')

@section('title', 'Item Master Data')

@php
    $items = [
        ['id' => 410001, 'item_no' => 'AW139-001', 'description' => 'Main Rotor Blade Set', 'item_group' => 'Rotor Components', 'uom_group' => 'EA', 'price_list' => 'Price List 01', 'inventory' => 'Yes', 'sales' => 'No', 'purchase' => 'Yes'],
        ['id' => 410044, 'item_no' => 'AW139-044', 'description' => 'Fuel Filter Assembly', 'item_group' => 'Consumables', 'uom_group' => 'EA', 'price_list' => 'Price List 01', 'inventory' => 'Yes', 'sales' => 'Yes', 'purchase' => 'Yes'],
        ['id' => 410088, 'item_no' => 'AW189-088', 'description' => 'Landing Light Module', 'item_group' => 'Electrical', 'uom_group' => 'EA', 'price_list' => 'Price List 02', 'inventory' => 'Yes', 'sales' => 'No', 'purchase' => 'Yes'],
        ['id' => 410144, 'item_no' => 'TOOL-144', 'description' => 'Torque Calibration Kit', 'item_group' => 'Tooling', 'uom_group' => 'SET', 'price_list' => 'Price List 03', 'inventory' => 'No', 'sales' => 'No', 'purchase' => 'Yes'],
        ['id' => 410203, 'item_no' => 'CHEM-203', 'description' => 'Sealant Compound', 'item_group' => 'Chemicals', 'uom_group' => 'BOX', 'price_list' => 'Price List 01', 'inventory' => 'Yes', 'sales' => 'Yes', 'purchase' => 'Yes'],
    ];
@endphp

@section('content')
    <div class="space-y-6">
        <x-page-header
            title="Item Master Data"
            description="Search and maintain item master records before opening the full purchasing, inventory, planning, and attachment setup."
        >
            <x-slot name="actions">
                <a href="{{ route('system.item-master-data.create') }}" class="btn-primary">
                    <x-icon name="plus" class="h-4 w-4" />
                    New Item
                </a>
            </x-slot>
        </x-page-header>

        <p class="text-sm text-gray-500">Browse {{ count($items) }} item master records with client-side search, sorting, and pagination.</p>

        <x-data-table datatable>
            <x-slot name="thead">
                <tr>
                    <th>Item No.</th>
                    <th>Description</th>
                    <th>Item Group</th>
                    <th>UoM Group</th>
                    <th>Price List</th>
                    <th>Inventory</th>
                    <th>Sales</th>
                    <th>Purchase</th>
                    <th data-sortable="false">Actions</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($items as $item)
                    <tr class="hover:bg-neutral-secondary-soft cursor-pointer">
                        <td class="font-medium text-heading whitespace-nowrap">
                            <a href="{{ route('system.item-master-data.edit', ['id' => $item['id']]) }}" class="font-semibold text-[#2f5bff] transition hover:text-[#284ef0] hover:underline">
                                {{ $item['item_no'] }}
                            </a>
                        </td>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['item_group'] }}</td>
                        <td>{{ $item['uom_group'] }}</td>
                        <td>{{ $item['price_list'] }}</td>
                        <td>{{ $item['inventory'] }}</td>
                        <td>{{ $item['sales'] }}</td>
                        <td>{{ $item['purchase'] }}</td>
                        <td>
                            <a
                                href="{{ route('system.item-master-data.edit', ['id' => $item['id']]) }}"
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
