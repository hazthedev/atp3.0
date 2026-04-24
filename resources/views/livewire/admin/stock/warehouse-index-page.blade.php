<div class="space-y-6">
    <x-page-header title="Warehouses" description="Physical and logical inventory storage locations, their address block, and G/L account mapping.">
        <x-slot name="actions">
            <a href="{{ route('admin.stock-management.warehouses.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                Create Warehouse
            </a>
        </x-slot>
    </x-page-header>

    <p class="text-sm text-gray-500">
        Browse {{ $warehouses->count() }} warehouses with client-side search, sorting, and pagination.
    </p>

    <x-data-table
        :empty="$warehouses->count() === 0"
        empty-label="No warehouses found"
        empty-description="Create a new warehouse to get started."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">Warehouse Code</th>
                <th class="table-th">Warehouse Name</th>
                <th class="table-th">Location</th>
                <th class="table-th">Nettable</th>
                <th class="table-th">Bin Locations</th>
                <th class="table-th">Status</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($warehouses as $warehouse)
                <tr class="table-row">
                    <td class="table-td">
                        <a href="{{ route('admin.stock-management.warehouses.edit', ['id' => $warehouse->id]) }}" class="font-medium text-blue-600 hover:underline">
                            {{ $warehouse->code }}
                        </a>
                    </td>
                    <td class="table-td">{{ $warehouse->name }}</td>
                    <td class="table-td">{{ $warehouse->location ?: '—' }}</td>
                    <td class="table-td">{{ $warehouse->nettable ? 'Yes' : 'No' }}</td>
                    <td class="table-td">{{ $warehouse->enable_bin_locations ? 'Enabled' : '—' }}</td>
                    <td class="table-td">
                        @if ($warehouse->inactive)
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">Inactive</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Active</span>
                        @endif
                    </td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.stock-management.warehouses.edit', ['id' => $warehouse->id]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('admin.stock-management.warehouses.edit', ['id' => $warehouse->id]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
