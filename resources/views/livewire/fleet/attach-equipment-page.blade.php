@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red'   => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };

    $selectedAvailableEquipment ??= null;
@endphp

<div class="space-y-6">
    <x-page-header
        title="Functional Location / Equipment Tree"
        description="Two-pane workspace for attaching, detaching, and swapping equipment on a functional location."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="attach-workspace-shell">
        <div class="attach-workspace-grid">

            {{-- ─── LEFT PANEL ─── --}}
            <div class="flex flex-col gap-4">

                {{-- Functional Location lookup fields --}}
                <div class="attach-panel attach-panel-muted">
                    <div class="attach-field-grid">
                        <label class="attach-field-label" for="fl_code">Code</label>
                        <x-enterprise.input
                            id="fl_code"
                            variant="lookup"
                            wire:model.blur="functionalLocationCode"
                            wire:keydown.enter.prevent="loadFunctionalLocation"
                            class="attach-input {{ $recordLoaded ? 'border-blue-300 bg-blue-50' : '' }}"
                            placeholder="e.g. 9M-WAA"
                        >
                            <x-slot:lookupAction>
                                <button
                                    type="button"
                                    wire:click="loadFunctionalLocation"
                                    class="flex items-center justify-center text-gray-400 transition-colors hover:text-gray-700 focus:outline-none"
                                >
                                    <x-icon name="magnifying-glass" class="h-4 w-4" />
                                </button>
                            </x-slot:lookupAction>
                        </x-enterprise.input>
                    </div>

                    @foreach ([
                        ['label' => 'Serial no',    'value' => $functionalLocation['serial_no']    ?? ''],
                        ['label' => 'Registration', 'value' => $functionalLocation['registration'] ?? ''],
                        ['label' => 'Type',         'value' => $functionalLocation['type']         ?? ''],
                    ] as $field)
                        <div class="attach-field-grid">
                            <span class="attach-field-label">{{ $field['label'] }}</span>
                            <x-enterprise.input variant="disabled" class="attach-input" value="{{ $field['value'] }}" />
                        </div>
                    @endforeach

                    {{-- MEL Item: small code cell + description with embedded search --}}
                    <div class="attach-field-grid">
                        <span class="attach-field-label">MEL Item</span>
                        <div class="grid grid-cols-[56px_minmax(0,1fr)] gap-2">
                            <x-enterprise.input variant="disabled" class="attach-input" value="" />
                            <x-enterprise.input
                                variant="lookup"
                                class="attach-input"
                                value="{{ $functionalLocation['mel'] ?? '' }}"
                                disabled
                            />
                        </div>
                    </div>
                </div>

                {{-- Installed equipment table --}}
                <x-enterprise.table-shell
                    datatable="false"
                    table-class="attach-grid-table"
                    :min-rows="9"
                    :row-count="count($installedEquipment)"
                >
                    <x-slot:thead>
                        <tr>
                            <th>Designation</th>
                            <th>Part Number</th>
                            <th>Serial no</th>
                            <th>Install date</th>
                        </tr>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($installedEquipment as $row)
                            <tr
                                wire:key="installed-{{ $row['equipment_id'] }}"
                                wire:click="selectInstalledEquipment('{{ $row['equipment_id'] }}')"
                                class="{{ $selectedInstalledEquipmentId === $row['equipment_id'] ? 'is-selected' : '' }}"
                            >
                                <td>{{ $row['designation'] }}</td>
                                <td>{{ $row['part_number'] }}</td>
                                <td>{{ $row['serial_no'] }}</td>
                                <td>{{ $row['install_date'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot:tbody>
                </x-enterprise.table-shell>

                {{-- Uninstallation / detach controls --}}
                <div class="attach-panel attach-panel-muted space-y-3">
                    <div class="attach-date-row">
                        <span class="attach-field-label">Uninstallation date</span>
                        <x-enterprise.input wire:model.live="uninstallationDate" class="attach-input" />
                        <span class="attach-field-label attach-inline-label">Time</span>
                        <x-enterprise.input wire:model.live="uninstallationTime" class="attach-input" />
                        <label class="attach-checkbox-inline">
                            <input type="checkbox" wire:model.live="uninstallationScheduled" />
                            <span>Scheduled</span>
                        </label>
                    </div>

                    <div class="attach-textarea-row">
                        <span class="attach-field-label">Comment</span>
                        <textarea rows="2" wire:model.live="detachComment" class="input-field attach-textarea"></textarea>
                    </div>

                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="updateCountersOnFunctionalLocation" />
                        <span>Update counters on Functional Location</span>
                    </label>

                    @foreach ([
                        ['label' => 'Return Reason 1', 'model' => 'returnReason1'],
                        ['label' => 'Return Reason 2', 'model' => 'returnReason2'],
                        ['label' => 'Return Reason 3', 'model' => 'returnReason3'],
                    ] as $field)
                        <div class="attach-field-grid">
                            <span class="attach-field-label">{{ $field['label'] }}</span>
                            <x-enterprise.input
                                variant="lookup"
                                class="attach-input"
                                wire:model.live="{{ $field['model'] }}"
                            />
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ─── TRANSFER BUTTONS ─── --}}
            <div class="attach-transfer-stack">
                <button
                    type="button"
                    wire:click="detachSelected"
                    class="btn-secondary w-full justify-center text-xs"
                    @disabled($selectedInstalledEquipmentId === null)
                >
                    Detach &rsaquo;
                </button>
                <button
                    type="button"
                    wire:click="attachSelected"
                    class="btn-primary w-full justify-center text-xs"
                    @disabled($selectedAvailableEquipmentId === null)
                >
                    &lsaquo; Attach
                </button>
                <button
                    type="button"
                    wire:click="swapSelected"
                    class="btn-secondary w-full justify-center text-xs"
                    @disabled($selectedInstalledEquipmentId === null || $selectedAvailableEquipmentId === null)
                >
                    &lsaquo; Swap
                </button>
            </div>

            {{-- ─── RIGHT PANEL ─── --}}
            <div class="flex flex-col gap-4">

                {{-- Selected available equipment details --}}
                <div class="attach-panel attach-panel-muted" style="margin-bottom: 2.5rem;">
                    <div class="attach-field-grid">
                        <span class="attach-field-label">Equipment ID</span>
                        <x-enterprise.input
                            variant="lookup"
                            class="attach-input"
                            value="{{ $selectedAvailableEquipment['equipment_id'] ?? '' }}"
                            disabled
                        />
                    </div>

                    @foreach ([
                        ['label' => 'Serial no',     'key' => 'serial_no'],
                        ['label' => 'Item no',        'key' => 'item_no'],
                        ['label' => 'Category part',  'key' => 'category_part'],
                        ['label' => 'Variant',        'key' => 'variant'],
                    ] as $field)
                        <div class="attach-field-grid">
                            <span class="attach-field-label">{{ $field['label'] }}</span>
                            <x-enterprise.input
                                variant="disabled"
                                class="attach-input"
                                value="{{ $selectedAvailableEquipment[$field['key']] ?? '' }}"
                            />
                        </div>
                    @endforeach
                </div>

                {{-- Available equipment table --}}
                <x-enterprise.table-shell
                    datatable="false"
                    table-class="attach-grid-table"
                    :min-rows="9"
                    :row-count="count($availableEquipment)"
                >
                    <x-slot:thead>
                        <tr>
                            <th>Designation</th>
                            <th>Part Number</th>
                            <th>Serial no</th>
                        </tr>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($availableEquipment as $row)
                            <tr
                                wire:key="available-{{ $row['equipment_id'] }}"
                                wire:click="selectAvailableEquipment('{{ $row['equipment_id'] }}')"
                                class="{{ $selectedAvailableEquipmentId === $row['equipment_id'] ? 'is-selected' : '' }}"
                            >
                                <td>{{ $row['designation'] }}</td>
                                <td>{{ $row['part_number'] }}</td>
                                <td>{{ $row['serial_no'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot:tbody>
                </x-enterprise.table-shell>

                {{-- Installation / attach controls --}}
                <div class="attach-panel attach-panel-muted space-y-3">
                    <div class="attach-date-row attach-date-row-right">
                        <span class="attach-field-label">Installation date</span>
                        <x-enterprise.input wire:model.live="installationDate" class="attach-input" />
                        <span class="attach-field-label attach-inline-label">Time</span>
                        <x-enterprise.input wire:model.live="installationTime" class="attach-input" />
                    </div>

                    <div class="attach-textarea-row">
                        <span class="attach-field-label">Comment</span>
                        <textarea rows="2" wire:model.live="attachComment" class="input-field attach-textarea"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                        <label class="attach-checkbox-row">
                            <input type="checkbox" wire:model.live="updateCountersOnEquipment" />
                            <span>Update counters on Equipment</span>
                        </label>
                        <label class="attach-checkbox-row">
                            <input type="checkbox" wire:model.live="updateMaintenancePlan" />
                            <span>Update the Maintenance Plan</span>
                        </label>
                    </div>

                    @foreach ([
                        ['model' => 'synchronizeCounters', 'label' => 'Synchronize Counters Date (using Installation Time and Date)'],
                        ['model' => 'inheritsOwner',       'label' => 'Equipment Inherits Owner from Functional Location'],
                        ['model' => 'inheritsMaintCenter', 'label' => 'Equipment Inherits Maintenance Center from Functional Location'],
                    ] as $option)
                        <label class="attach-checkbox-row">
                            <input type="checkbox" wire:model.live="{{ $option['model'] }}" />
                            <span>{{ $option['label'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <footer class="attach-workspace-footer">
            <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
            <a href="{{ route('fleet.functional-location.customer') }}" class="btn-secondary">Cancel</a>
        </footer>
    </section>
</div>
