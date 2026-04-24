<div class="space-y-6">
    <x-page-header
        :title="$pageTitle"
        :description="$pageDescription"
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <x-card :title="$pageTitle" description="Legacy workflow layout adapted into the current ATP table and form system." padding="p-6">
        <div class="space-y-6">
            <div class="flex flex-wrap items-end justify-end gap-4">
                <div class="w-full sm:w-40 lg:w-44">
                    <x-form.select
                        label="In stock"
                        name="generate_equipment_card_in_stock"
                        wire:model.live="inStockFilter"
                        placeholder="-"
                        :options="$inStockOptions"
                    />
                </div>

                <div class="w-full sm:w-72 lg:w-80">
                    <x-form.select
                        label="Item Group Filter"
                        name="generate_equipment_card_item_group"
                        wire:model.live="itemGroupFilter"
                        placeholder="-"
                        :options="$itemGroupOptions"
                    />
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                <table class="pending-base-table min-w-[1500px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-th w-16">Generate</th>
                            <th class="table-th">Document</th>
                            <th class="table-th">ID Equipment</th>
                            <th class="table-th">S/N</th>
                            <th class="table-th">Item Code</th>
                            <th class="table-th">Item Name</th>
                            <th class="table-th">Counters</th>
                            <th class="table-th">Item Category</th>
                            <th class="table-th">Item Group</th>
                            <th class="table-th">In Stock</th>
                            <th class="table-th">Variant</th>
                            <th class="table-th">Operator Code</th>
                            <th class="table-th">Operator Name</th>
                            <th class="table-th">Owner Code</th>
                            <th class="table-th">Owner Name</th>
                            <th class="table-th">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($rows as $row)
                            <tr class="table-row" wire:key="generate-equipment-card-row-{{ $row['id'] }}">
                                <td class="table-td align-middle">
                                    <label class="flex items-center justify-center">
                                        <input type="checkbox" wire:model.live="selectedIds" value="{{ $row['id'] }}" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    </label>
                                </td>
                                <td class="table-td">
                                    <span class="inline-flex items-center gap-3 font-medium text-gray-900">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                        </span>
                                        <span>{{ $row['document'] }}</span>
                                    </span>
                                </td>
                                <td class="table-td">{{ $row['equipment_id'] }}</td>
                                <td class="table-td">{{ $row['serial_number'] }}</td>
                                <td class="table-td">{{ $row['item_code'] }}</td>
                                <td class="table-td">{{ $row['item_name'] }}</td>
                                <td class="table-td text-center">
                                    @if ($row['counters'])
                                        <span class="inline-flex h-5 w-5 items-center justify-center rounded border border-gray-300 bg-white text-xs text-gray-700">Y</span>
                                    @endif
                                </td>
                                <td class="table-td">{{ $row['item_category'] }}</td>
                                <td class="table-td">{{ $row['item_group'] }}</td>
                                <td class="table-td">{{ $row['in_stock'] }}</td>
                                <td class="table-td">{{ $row['variant'] }}</td>
                                <td class="table-td">{{ $row['operator_code'] }}</td>
                                <td class="table-td">{{ $row['operator_name'] }}</td>
                                <td class="table-td">{{ $row['owner_code'] }}</td>
                                <td class="table-td">{{ $row['owner_name'] }}</td>
                                <td class="table-td">
                                    <x-enterprise.select wire:model.live="rowStatuses.{{ $row['id'] }}" class="min-w-[140px] py-2 text-xs">
                                        <option value="Serviceable">Serviceable</option>
                                        <option value="Unserviceable">Unserviceable</option>
                                        <option value="In Repair">In Repair</option>
                                    </x-enterprise.select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="px-6 py-10 text-center text-sm text-gray-500">
                                    No equipment rows match the selected stock and item-group filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" wire:click="generatePreview">Generate</button>
                    <button type="button" class="btn-secondary" wire:click="cancelSelection">Cancel</button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-secondary" wire:click="checkAllVisible">Check All</button>
                    <button type="button" class="btn-secondary" wire:click="uncheckAll">Uncheck All</button>
                </div>
            </div>
        </div>
    </x-card>
</div>
