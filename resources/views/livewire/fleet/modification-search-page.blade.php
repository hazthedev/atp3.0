<div class="space-y-6">
    <x-page-header
        title="Search Modifications"
        description="Modification register matching the legacy operational search grid, adapted to the current ATP table system."
    />

    <x-data-table
        :empty="$rows->count() === 0"
        empty-label="No modification records found"
        empty-description="Modification rows will appear here once the register is populated."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">Type</th>
                <th class="table-th">Unique Ref.</th>
                <th class="table-th">Reference</th>
                <th class="table-th">Revision</th>
                <th class="table-th">Title</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($rows as $row)
                <tr class="table-row" wire:key="modification-{{ $row['id'] }}">
                    <td class="table-td">{{ $row['type'] }}</td>
                    <td class="table-td">
                        <a href="{{ route('fleet.modification.show', ['id' => $row['id']]) }}" class="group/drill inline-flex items-center gap-3 font-semibold text-gray-900 transition hover:text-blue-700">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                            </span>
                            <span>{{ $row['unique_ref'] }}</span>
                        </a>
                    </td>
                    <td class="table-td">{{ $row['reference'] }}</td>
                    <td class="table-td">{{ $row['revision'] }}</td>
                    <td class="table-td">{{ $row['title'] }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
