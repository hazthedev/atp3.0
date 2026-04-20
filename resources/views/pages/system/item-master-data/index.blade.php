@extends('layouts.app')

@section('title', 'Item Master Data')

@php
    $items = \App\Models\Item::orderBy('code')->get();
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

        <p class="text-sm text-gray-500">Browse {{ $items->count() }} item master records.</p>

        <x-data-table datatable>
            <x-slot name="thead">
                <tr>
                    <th class="w-10" data-sortable="false">#</th>
                    <th>Item No.</th>
                    <th>Item Description</th>
                    <th>In Stock</th>
                    <th>Manufacturer</th>
                    <th>Class</th>
                    <th>Calibration</th>
                    <th>Shelf Life</th>
                    <th>Sales Item</th>
                    <th>Manage by Batch/Serial</th>
                    <th>Inventory Item</th>
                    <th>Purchase Item</th>
                    <th>Item Group</th>
                    <th>UoM Group</th>
                    <th>Alternative Part</th>
                    <th>Serial No. Management</th>
                    <th>Item Type</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($items as $index => $item)
                    <tr class="hover:bg-neutral-secondary-soft">
                        <td class="text-gray-500">{{ $index + 1 }}</td>
                        <td class="font-medium whitespace-nowrap">
                            <a href="{{ route('system.item-master-data.edit', ['id' => $item->id]) }}" class="font-semibold text-[#2f5bff] transition hover:text-[#284ef0] hover:underline">
                                {{ $item->code }}
                            </a>
                        </td>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ number_format((float) $item->in_stock, 2) }}</td>
                        <td>{{ $item->manufacturer }}</td>
                        <td>{{ $item->item_class }}</td>
                        <td>{{ $item->calibration }}</td>
                        <td>{{ $item->shelf_life }}</td>
                        <td>{{ $item->sales_item }}</td>
                        <td>{{ $item->manage_by_batch_serial }}</td>
                        <td>{{ $item->inventory_item }}</td>
                        <td>{{ $item->purchase_item }}</td>
                        <td>{{ $item->item_group }}</td>
                        <td>{{ $item->uom_group }}</td>
                        <td>{{ $item->alternative_part }}</td>
                        <td>{{ $item->serial_no_management }}</td>
                        <td>{{ $item->item_type }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>
    </div>
@endsection
