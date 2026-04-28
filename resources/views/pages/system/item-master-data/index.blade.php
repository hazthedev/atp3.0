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

        <x-data-table
            :empty="$items->isEmpty()"
            empty-label="No items found"
            empty-description="Try a different item number, description, or class."
            search-meta=""
            datatable
        >
            <x-slot name="thead">
                <tr>
                    <th class="table-th w-10" data-sortable="false">#</th>
                    <th class="table-th">Item No.</th>
                    <th class="table-th">Item Description</th>
                    <th class="table-th">In Stock</th>
                    <th class="table-th">Manufacturer</th>
                    <th class="table-th">Class</th>
                    <th class="table-th">Calibration</th>
                    <th class="table-th">Shelf Life</th>
                    <th class="table-th">Sales Item</th>
                    <th class="table-th">Manage by Batch/Serial</th>
                    <th class="table-th">Inventory Item</th>
                    <th class="table-th">Purchase Item</th>
                    <th class="table-th">Item Group</th>
                    <th class="table-th">UoM Group</th>
                    <th class="table-th">Alternative Part</th>
                    <th class="table-th">Serial No. Management</th>
                    <th class="table-th">Item Type</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($items as $index => $item)
                    <tr class="table-row">
                        <td class="table-td text-gray-500">{{ $index + 1 }}</td>
                        <td class="table-td">
                            <a href="{{ route('system.item-master-data.edit', ['id' => $item->id]) }}" class="font-semibold text-blue-600 hover:underline">
                                {{ $item->code }}
                            </a>
                        </td>
                        <td class="table-td">{{ $item->description }}</td>
                        <td class="table-td text-right">{{ number_format((float) $item->in_stock, 2) }}</td>
                        <td class="table-td">{{ $item->manufacturer }}</td>
                        <td class="table-td">{{ $item->item_class }}</td>
                        <td class="table-td">{{ $item->calibration }}</td>
                        <td class="table-td">{{ $item->shelf_life }}</td>
                        <td class="table-td">{{ $item->sales_item }}</td>
                        <td class="table-td">{{ $item->manage_by_batch_serial }}</td>
                        <td class="table-td">{{ $item->inventory_item }}</td>
                        <td class="table-td">{{ $item->purchase_item }}</td>
                        <td class="table-td">{{ $item->item_group }}</td>
                        <td class="table-td">{{ $item->uom_group }}</td>
                        <td class="table-td">{{ $item->alternative_part }}</td>
                        <td class="table-td">{{ $item->serial_no_management }}</td>
                        <td class="table-td">{{ $item->item_type }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>
    </div>
@endsection
