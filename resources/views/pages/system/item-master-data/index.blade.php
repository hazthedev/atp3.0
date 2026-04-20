@extends('layouts.app')

@section('title', 'Item Master Data')

@php
    $items = \App\Models\Item::orderBy('code')->get()->map(fn ($row) => [
        'id' => $row->id,
        'item_no' => $row->code,
        'description' => $row->description,
        'item_group' => '',
        'uom_group' => '',
        'price_list' => '',
        'inventory' => '',
        'sales' => '',
        'purchase' => '',
    ])->all();
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
