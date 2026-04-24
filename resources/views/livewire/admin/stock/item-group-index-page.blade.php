<div class="space-y-6">
    <x-page-header title="Item Groups" description="Reference data for item categorisation — default UoM group, valuation method, and per-warehouse bin defaults.">
        <x-slot name="actions">
            <a href="{{ route('admin.stock-management.item-groups.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                Create Item Group
            </a>
        </x-slot>
    </x-page-header>

    <p class="text-sm text-gray-500">
        Browse {{ $groups->count() }} item groups with client-side search, sorting, and pagination.
    </p>

    <x-data-table
        :empty="$groups->count() === 0"
        empty-label="No item groups found"
        empty-description="Create a new item group to get started."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">Item Group Name</th>
                <th class="table-th">Default UoM Group</th>
                <th class="table-th">Lead Time (days)</th>
                <th class="table-th">Valuation Method</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($groups as $group)
                <tr class="table-row">
                    <td class="table-td">
                        <a href="{{ route('admin.stock-management.item-groups.edit', ['id' => $group->id]) }}" class="font-medium text-blue-600 hover:underline">
                            {{ $group->name }}
                        </a>
                    </td>
                    <td class="table-td">{{ $group->default_uom_group ?: '—' }}</td>
                    <td class="table-td">{{ $group->lead_time_days ?? '—' }}</td>
                    <td class="table-td">{{ $group->default_valuation_method }}</td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.stock-management.item-groups.edit', ['id' => $group->id]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('admin.stock-management.item-groups.edit', ['id' => $group->id]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
