@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };
@endphp

<div class="space-y-6">
    <x-page-header
        title="Maintenance Item Monitoring"
        description="Monitor equipment maintenance items using the legacy manage-by workflow adapted to the current ATP design system."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="grid max-w-[520px] items-end gap-4 sm:grid-cols-[160px_minmax(0,320px)]">
                <label for="maintenance_item_manage_by" class="attach-field-label">Manage Item By</label>
                <div class="w-full">
                    <select
                        id="maintenance_item_manage_by"
                        name="maintenance_item_manage_by"
                        wire:model.live="manageItemBy"
                        class="input-field w-full"
                    >
                        <option value="">2  -  Serial number</option>
                        @foreach ($manageByOptions as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) $optionValue === (string) $manageItemBy)>{{ $optionLabel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm mt-5">
                <table class="pending-base-table">
                    <thead>
                        <tr>
                            <th>Item No.</th>
                            <th>Description</th>
                            <th>Item Group</th>
                            <th>Category Part</th>
                            <th class="text-center">Is Tool</th>
                            <th class="text-center">Serialized</th>
                            <th class="text-center">Counters</th>
                            <th class="text-center">Task Lists</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr wire:key="maintenance-item-{{ $row['item_no'] }}">
                                <td>
                                    <a href="#" class="inline-flex items-center gap-2 font-semibold text-gray-900 transition hover:text-blue-700">
                                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                        </span>
                                        <span>{{ $row['item_no'] }}</span>
                                    </a>
                                </td>
                                <td>{{ $row['description'] }}</td>
                                <td>{{ $row['item_group'] }}</td>
                                <td>{{ $row['category_part'] }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($row['is_tool']) disabled />
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($row['serialized']) disabled />
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($row['counters']) disabled />
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($row['task_lists']) disabled />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
                <button type="button" wire:click="cancelPreview" class="btn-secondary">Cancel</button>
            </div>
        </div>
    </section>
</div>
