<div class="space-y-6">
    <x-page-header
        title="Customer Functional Location"
        description="Search and browse registered functional locations before drilling into the selected aircraft record."
    />

    <p class="text-sm text-gray-500">
        Browse {{ $records->count() }} functional locations with client-side search, sorting, and pagination.
    </p>

    <x-data-table
        :empty="$records->count() === 0"
        empty-label="No functional locations found"
        empty-description="Try a different ID, registration, serial number, or operator."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">ID</th>
                <th class="table-th">Serial No.</th>
                <th class="table-th">Registration</th>
                <th class="table-th">Type</th>
                <th class="table-th">Op. Code</th>
                <th class="table-th">Operator name</th>
                <th class="table-th">Ow. Code</th>
                <th class="table-th">Owner</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($records as $record)
                <tr class="table-row">
                    <td class="table-td"><x-enterprise.table-cell variant="arrow" :href="route('fleet.functional-location.show', ['id' => $record['id']])">{{ $record['code'] }}</x-enterprise.table-cell></td>
                    <td class="table-td">{{ $record['serial_no'] }}</td>
                    <td class="table-td">{{ $record['registration'] }}</td>
                    <td class="table-td">{{ $record['type'] }}</td>
                    <td class="table-td">{{ $record['operator_code'] }}</td>
                    <td class="table-td">{{ $record['operator_name'] }}</td>
                    <td class="table-td">{{ $record['owner_code'] }}</td>
                    <td class="table-td">{{ $record['owner_name'] }}</td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('fleet.functional-location.show', ['id' => $record['id']]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('fleet.functional-location.edit', ['id' => $record['id']]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
