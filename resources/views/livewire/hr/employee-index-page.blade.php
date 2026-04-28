<div class="space-y-6">
    <x-page-header
        title="Employee Master Data"
        description="Master list of employees. Click an employee to open their detail card."
    />

    <p class="text-sm text-gray-500">Browse {{ $employees->count() }} employee master records.</p>

    <x-data-table
        :empty="$employees->isEmpty()"
        empty-label="No employees found"
        empty-description="Try a different employee number, name, or department."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">Employee No.</th>
                <th class="table-th">Name</th>
                <th class="table-th">Position</th>
                <th class="table-th">Department</th>
                <th class="table-th">Status</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($employees as $employee)
                <tr class="table-row" wire:key="employee-row-{{ $employee->id }}">
                    <td class="table-td">
                        <a href="{{ route('human-resources.employee-master-data.show', ['id' => $employee->id]) }}" class="font-semibold text-blue-600 hover:underline">
                            {{ $employee->employee_no }}
                        </a>
                    </td>
                    <td class="table-td">{{ $employee->fullName() }}</td>
                    <td class="table-td">{{ $employee->position ?? '—' }}</td>
                    <td class="table-td">{{ $employee->department ?? '—' }}</td>
                    <td class="table-td">
                        @if ($employee->active_employee)
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">{{ $employee->status ?: 'Active' }}</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">Inactive</span>
                        @endif
                    </td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('human-resources.employee-master-data.show', ['id' => $employee->id]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('human-resources.employee-master-data.edit', ['id' => $employee->id]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
