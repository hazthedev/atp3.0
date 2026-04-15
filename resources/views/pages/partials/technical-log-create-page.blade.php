@php
    use App\Support\EquipmentCatalog;

    $selectedEquipmentId = request()->integer('equipment_id', 1);

    $equipment = EquipmentCatalog::find($selectedEquipmentId) ?? [
        'id' => (string) $selectedEquipmentId,
        'equipment_no' => '1',
        'serial_number' => '31324',
        'item_no' => 'AW139',
        'item_name' => 'AW139',
        'variant' => 'AW139',
        'status' => 'On Aircraft',
    ];

    $equipmentIdentityFields = [
        ['label' => 'Log Number', 'name' => 'log_number', 'value' => ''],
        ['label' => 'Equipment', 'name' => 'equipment_no', 'value' => $equipment['equipment_no'] ?? '1'],
        ['label' => 'Serial Number', 'name' => 'serial_number', 'value' => $equipment['serial_number']],
        ['label' => 'Part Number', 'name' => 'part_number', 'value' => $equipment['item_no']],
        ['label' => 'Variant', 'name' => 'variant', 'value' => $equipment['variant']],
    ];

    $applyOnFields = [
        ['label' => 'Equipment', 'name' => 'apply_equipment', 'value' => ''],
        ['label' => 'Part Number', 'name' => 'apply_part_number', 'value' => ''],
        ['label' => 'Serial Number', 'name' => 'apply_serial_number', 'value' => ''],
    ];

    $ataFields = [
        ['label' => 'Chapter', 'value' => ''],
        ['label' => 'Section', 'value' => ''],
        ['label' => 'Subject', 'value' => ''],
        ['label' => 'Sheet', 'value' => ''],
        ['label' => 'Mark', 'value' => ''],
    ];

    $tabs = [
        ['id' => 'defect', 'label' => 'Defect'],
        ['id' => 'corrective-actions', 'label' => 'Corrective Actions'],
        ['id' => 'workaround', 'label' => 'Workaround'],
        ['id' => 'deferral', 'label' => 'Deferral'],
        ['id' => 'attachments', 'label' => 'Attachments'],
        ['id' => 'properties', 'label' => 'Properties'],
    ];

    $actionTabFields = [
        ['label' => 'Employee', 'name' => 'action_employee', 'value' => ''],
        ['label' => 'Date', 'name' => 'action_date', 'value' => ''],
        ['label' => 'Time', 'name' => 'action_time', 'value' => ''],
        ['label' => 'Work Type', 'name' => 'action_work_type', 'value' => ''],
        ['label' => 'WorkLoad', 'name' => 'action_workload', 'value' => ''],
        ['label' => 'WO Linked', 'name' => 'action_wo_linked', 'value' => ''],
    ];

    $deferralFields = [
        ['label' => 'MEL Category', 'name' => 'mel_category', 'value' => ''],
        ['label' => 'Dead Line', 'name' => 'dead_line', 'value' => ''],
        ['label' => 'Authorization Number', 'name' => 'authorization_number', 'value' => ''],
        ['label' => 'Extension Number', 'name' => 'extension_number', 'value' => ''],
    ];

    $attachmentRows = range(1, 6);
@endphp

<div class="space-y-6" x-data="tabs('defect')">
    <x-page-header
        title="Technical Log"
        description="Technical log creation workspace using the selected equipment as the default reference."
    />

    <x-card title="Technical Log" description="Capture a technical log against the selected equipment." padding="p-6">
        <div class="space-y-6">
            <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">
                <div class="space-y-3">
                    @foreach ($equipmentIdentityFields as $field)
                        <div class="grid gap-3 md:grid-cols-[132px_minmax(0,1fr)] md:items-center">
                            <label for="{{ $field['name'] }}" class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                            <input
                                id="{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                type="text"
                                value="{{ $field['value'] }}"
                                class="input-field {{ $field['value'] !== '' ? 'input-field-filled' : '' }}"
                                @if ($field['value'] !== '' && $field['name'] !== 'log_number') readonly @endif
                            />
                        </div>
                    @endforeach
                </div>

                <div class="space-y-4">
                    <div class="grid gap-3 md:grid-cols-[132px_minmax(0,1fr)] md:items-center">
                        <label for="technical_log_status" class="text-sm font-medium text-gray-600">Status</label>
                        <input id="technical_log_status" name="technical_log_status" type="text" value="Draft" readonly class="input-field input-field-filled" />
                    </div>

                    <div class="grid gap-4 md:grid-cols-[140px_minmax(0,1fr)] md:items-center">
                        <label for="apply_on" class="text-sm font-medium text-gray-600">Apply On</label>
                        <select id="apply_on" name="apply_on" class="input-field">
                            <option>Item Code</option>
                        </select>
                    </div>

                    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
                        <div class="space-y-3">
                            @foreach ($applyOnFields as $field)
                                <div class="grid gap-3 md:grid-cols-[132px_minmax(0,1fr)] md:items-center">
                                    <label for="{{ $field['name'] }}" class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                                    <input id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="text" value="{{ $field['value'] }}" class="input-field" />
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/80 p-4">
                                <p class="text-sm font-semibold text-gray-900">Chapter - Section - Subject - Sheet - Mark</p>
                                <div class="grid gap-3 sm:grid-cols-5">
                                    @foreach ($ataFields as $field)
                                        <div class="space-y-1.5">
                                            <x-form.label :for="'ata_' . strtolower($field['label'])">{{ $field['label'] }}</x-form.label>
                                            <input
                                                id="{{ 'ata_' . strtolower($field['label']) }}"
                                                name="{{ 'ata_' . strtolower($field['label']) }}"
                                                type="text"
                                                value="{{ $field['value'] }}"
                                                class="input-field"
                                            />
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                                <label for="mel_items" class="text-sm font-medium text-gray-600">MEL Items</label>
                                <input id="mel_items" name="mel_items" type="text" value="" class="input-field" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach ($tabs as $tab)
                            <li class="subtab-item">
                                <button
                                    type="button"
                                    class="subtab-link"
                                    :class="activeTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                    @click="setTab('{{ $tab['id'] }}')"
                                >
                                    {{ $tab['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'defect'" class="space-y-5">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="space-y-3">
                        <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                            <label for="defect_employee" class="text-sm font-medium text-gray-600">Employee</label>
                            <input id="defect_employee" name="defect_employee" type="text" value="" class="input-field" />
                        </div>
                        <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                            <label for="defect_date" class="text-sm font-medium text-gray-600">Date</label>
                            <input id="defect_date" name="defect_date" type="text" value="" class="input-field" />
                        </div>
                        <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                            <label for="defect_time" class="text-sm font-medium text-gray-600">Time</label>
                            <input id="defect_time" name="defect_time" type="text" value="" class="input-field" />
                        </div>
                        <label class="flex items-center gap-3 pt-1 text-sm text-gray-700">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span>Deferral</span>
                        </label>
                    </div>

                    <div class="grid gap-3">
                        <label for="defect_description" class="text-sm font-medium text-gray-600">Description</label>
                        <textarea id="defect_description" name="defect_description" rows="9" class="input-field resize-none"></textarea>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 border-t border-gray-200 pt-4">
                    <button type="button" class="btn-secondary" disabled>Counter Reading</button>
                    <button type="button" class="btn-secondary" disabled>Fleet Mngt Cockpit</button>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'corrective-actions'" class="space-y-5">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="space-y-3">
                        @foreach ($actionTabFields as $field)
                            <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                                <label for="corrective_{{ $field['name'] }}" class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                                <input id="corrective_{{ $field['name'] }}" name="corrective_{{ $field['name'] }}" type="text" value="{{ $field['value'] }}" class="input-field" />
                            </div>
                        @endforeach
                    </div>

                    <div class="grid gap-3">
                        <label for="corrective_description" class="text-sm font-medium text-gray-600">Description</label>
                        <textarea id="corrective_description" name="corrective_description" rows="9" class="input-field resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'workaround'" class="space-y-5">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="space-y-3">
                        @foreach ($actionTabFields as $field)
                            <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                                <label for="workaround_{{ $field['name'] }}" class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                                <input id="workaround_{{ $field['name'] }}" name="workaround_{{ $field['name'] }}" type="text" value="{{ $field['value'] }}" class="input-field" />
                            </div>
                        @endforeach
                    </div>

                    <div class="grid gap-3">
                        <label for="workaround_description" class="text-sm font-medium text-gray-600">Description</label>
                        <textarea id="workaround_description" name="workaround_description" rows="9" class="input-field resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'deferral'" class="space-y-5">
                <div class="max-w-xl space-y-3">
                    @foreach ($deferralFields as $field)
                        <div class="grid gap-3 md:grid-cols-[148px_minmax(0,1fr)] md:items-center">
                            <label for="{{ $field['name'] }}" class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                            <input id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="text" value="{{ $field['value'] }}" class="input-field" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'attachments'" class="space-y-5">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_140px] xl:items-start">
                    <x-data-table>
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">#</th>
                                <th class="table-th">Path</th>
                                <th class="table-th">File Name</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($attachmentRows as $rowNumber)
                                <tr class="table-row">
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>

                    <div class="flex flex-col gap-3">
                        <button type="button" class="btn-secondary justify-center">Browse</button>
                        <button type="button" class="btn-secondary justify-center">Display</button>
                        <div class="hidden flex-1 xl:block"></div>
                        <button type="button" class="btn-secondary justify-center">Delete</button>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_220px] xl:items-start">
                    <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)] md:items-center">
                        <label for="techlog_id" class="text-sm font-medium text-gray-600">Techlog ID</label>
                        <input id="techlog_id" name="techlog_id" type="text" value="" class="input-field" />
                    </div>

                    <div class="space-y-3 pt-1">
                        <label class="flex items-center gap-3 text-sm text-gray-700">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span>Repetitive</span>
                        </label>
                        <label class="flex items-center gap-3 text-sm text-gray-700">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span>Failure Confirmed</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary">Add</button>
                <button type="button" class="btn-secondary">Cancel</button>
            </div>
        </div>
    </x-card>
</div>
