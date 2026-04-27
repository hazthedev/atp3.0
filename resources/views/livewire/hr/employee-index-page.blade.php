<div class="space-y-6">
    <x-page-header
        title="Employee Master Data"
        description="Master list of employees. Click an employee to open their detail card."
    />

    <x-card padding="p-0">
        <x-data-table>
            <x-slot name="thead">
                <tr>
                    <th class="table-th">Employee No.</th>
                    <th class="table-th">Name</th>
                    <th class="table-th">Position</th>
                    <th class="table-th">Department</th>
                    <th class="table-th">Status</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($employees as $employee)
                    <tr class="table-row" wire:key="employee-row-{{ $employee->id }}">
                        <td class="table-td">
                            <a href="{{ route('hr.employee-master-data.edit', ['id' => $employee->id]) }}"
                               class="inline-flex items-center gap-3 font-semibold text-gray-900 transition hover:text-blue-700">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                </span>
                                <span>{{ $employee->employee_no }}</span>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-sm text-gray-500">
                            No employees yet. Run <code class="rounded bg-gray-100 px-1.5 py-0.5">php artisan db:seed --class=EmployeeSeeder</code> to load samples.
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>
    </x-card>
</div>
