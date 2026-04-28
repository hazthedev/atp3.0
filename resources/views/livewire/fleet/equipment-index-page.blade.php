<div class="space-y-6">
    <x-page-header
        title="Search Equipments"
        description="Equipment register matching the legacy operational column layout, adapted into the current ATP table system."
    />

    <p class="text-sm text-gray-500">
        Browse {{ $rows->count() }} equipment records with client-side search, sorting, and pagination.
    </p>

    <x-data-table
        :empty="$rows->count() === 0"
        empty-label="No equipment records found"
        empty-description="Try a different equipment ID, item number, serial number, or owner."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">ID</th>
                <th class="table-th">Item No.</th>
                <th class="table-th">Item Name</th>
                <th class="table-th">Serial Number</th>
                <th class="table-th">Old</th>
                <th class="table-th">Category Part</th>
                <th class="table-th">Variant</th>
                <th class="table-th">Status</th>
                <th class="table-th">Father Object</th>
                <th class="table-th">Father Reference</th>
                <th class="table-th">Op. Code</th>
                <th class="table-th">Operator Name</th>
                <th class="table-th">Ow. Code</th>
                <th class="table-th">Owner Name</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($rows as $row)
                <tr class="table-row">
                    <td class="table-td">
                        <a href="{{ route('fleet.equipment.customer-equipment-card', ['id' => $row['id']]) }}" class="group/drill inline-flex items-center gap-3 font-semibold text-gray-900 transition hover:text-blue-700">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                            </span>
                            <span>{{ $row['id'] }}</span>
                        </a>
                    </td>
                    <td class="table-td">{{ $row['item_no'] }}</td>
                    <td class="table-td">{{ $row['item_name'] }}</td>
                    <td class="table-td">{{ $row['serial_number'] }}</td>
                    <td class="table-td">{{ $row['old'] }}</td>
                    <td class="table-td">{{ $row['category_part'] }}</td>
                    <td class="table-td">{{ $row['variant'] }}</td>
                    <td class="table-td">
                        <x-badge :color="$row['status'] === 'On Aircraft' ? 'success' : 'default'">
                            {{ $row['status'] }}
                        </x-badge>
                    </td>
                    <td class="table-td">{{ $row['father_object_type'] }}</td>
                    <td class="table-td">
                        @if ($row['father_reference'] !== '')
                            <span class="font-medium text-blue-600">{{ $row['father_reference'] }}</span>
                        @endif
                    </td>
                    <td class="table-td">{{ $row['operator_code'] }}</td>
                    <td class="table-td">{{ $row['operator_name'] }}</td>
                    <td class="table-td">{{ $row['owner_code'] }}</td>
                    <td class="table-td">{{ $row['owner_name'] }}</td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('fleet.equipment.show', ['id' => $row['id']]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('fleet.equipment.customer-equipment-card', ['id' => $row['id']]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
