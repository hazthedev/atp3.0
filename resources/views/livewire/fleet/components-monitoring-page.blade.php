<div class="space-y-6">
    <x-page-header
        title="Components Monitoring"
        description="Monitor serialized components, equipment state, and warehouse context using the ATP equipment workspace pattern."
    />

    <x-card title="Components Monitoring" description="Legacy workspace layout adapted into the current ATP design system." padding="p-6">
        <div class="space-y-5">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="w-full max-w-md">
                        <x-form.select
                            label="Display Only"
                            name="display_only"
                            wire:model.live="displayOnly"
                            :options="$displayOptions"
                        />
                    </div>

                    <label class="flex items-center gap-3 pb-2 text-sm text-gray-700">
                        <input
                            type="checkbox"
                            wire:model.live="excludeAppliedAndNonApplicableTask"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                        <span>Exclude Applied and Non Applicable Task</span>
                    </label>
                </div>

                <button type="button" class="btn-secondary h-fit self-start xl:self-auto" wire:click="$refresh">Refresh</button>
            </div>

            @if ($actionMessage !== '')
                <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                    {{ $actionMessage }}
                </div>
            @endif

            <x-data-table
                :empty="$rows->count() === 0"
                empty-label="No monitored components found"
                empty-description="Adjust the display filter or include applied/non-applicable tasks to repopulate the monitoring table."
                search-meta=""
            >
                <x-slot name="thead">
                    <tr>
                        <th class="table-th">Equipment Id</th>
                        <th class="table-th">Equipment Status</th>
                        <th class="table-th">Part Number</th>
                        <th class="table-th">Item Name</th>
                        <th class="table-th">Serial Number</th>
                        <th class="table-th">Item Group/C...</th>
                        <th class="table-th">Whse Code</th>
                        <th class="table-th">Whse Name</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    @foreach ($rows as $row)
                        <tr
                            class="table-row cursor-pointer transition-colors {{ ($selectedRow['row_key'] ?? '') === $row['row_key'] ? 'bg-blue-50/70' : '' }}"
                            wire:key="components-monitoring-{{ $row['row_key'] }}"
                            wire:click="selectRow('{{ $row['row_key'] }}')"
                        >
                            <td class="table-td">
                                @if ($row['equipment_id'] !== '')
                                    <a href="{{ route('fleet.equipment.show', ['id' => $row['equipment_id']]) }}" class="group/drill inline-flex items-center gap-3 font-semibold text-gray-900 transition hover:text-blue-700">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                        </span>
                                        <span>{{ $row['equipment_id'] }}</span>
                                    </a>
                                @endif
                            </td>
                            <td class="table-td">{{ $row['equipment_status'] }}</td>
                            <td class="table-td font-medium text-blue-700">{{ $row['part_number'] }}</td>
                            <td class="table-td">{{ $row['item_name'] }}</td>
                            <td class="table-td">{{ $row['serial_number'] }}</td>
                            <td class="table-td">{{ $row['item_group_code'] }}</td>
                            <td class="table-td">{{ $row['whse_code'] }}</td>
                            <td class="table-td">{{ $row['whse_name'] }}</td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-data-table>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-7">
                <button type="button" class="btn-secondary">Cancel</button>

                <div class="ml-auto flex flex-wrap gap-3">
                    <button type="button" class="btn-secondary" wire:click="includeIntoWorkOrder" @disabled($selectedRow === null)>Include Into Work Order</button>
                    <button type="button" class="btn-primary" wire:click="applyTaskList" @disabled($selectedRow === null)>Apply Task List</button>
                </div>
            </div>
        </div>
    </x-card>
</div>
