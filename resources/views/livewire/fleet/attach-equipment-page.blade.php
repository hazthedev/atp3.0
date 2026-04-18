@php
    $selectedAvailableEquipment ??= null;
@endphp

<div class="space-y-6">
    <x-page-header
        title="Functional Location / Equipment Tree"
        description="Two-pane workspace for attaching, detaching, and swapping equipment on a functional location."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="attach-workspace-shell">
        <div class="attach-workspace-grid">

            {{-- ─── LEFT PANEL ─── --}}
            <div class="flex flex-col gap-4">

                {{-- Functional Location lookup fields --}}
                <x-enterprise.panel :muted="true" class="space-y-3">
                    <x-enterprise.field-row label="Code" for="fl_code">
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
                    </x-enterprise.field-row>

                    @foreach ([
                        ['label' => 'Serial no',    'value' => $functionalLocation['serial_no']    ?? ''],
                        ['label' => 'Registration', 'value' => $functionalLocation['registration'] ?? ''],
                        ['label' => 'Type',         'value' => $functionalLocation['type']         ?? ''],
                    ] as $field)
                        <x-enterprise.field-row :label="$field['label']">
                            <x-enterprise.input variant="disabled" class="attach-input" value="{{ $field['value'] }}" />
                        </x-enterprise.field-row>
                    @endforeach

                    {{-- MEL Item: small code cell + description with embedded search --}}
                    <x-enterprise.field-row label="MEL Item">
                        <div class="grid grid-cols-[56px_minmax(0,1fr)] gap-2">
                            <x-enterprise.input variant="disabled" class="attach-input" value="" />
                            <x-enterprise.input
                                variant="lookup"
                                class="attach-input"
                                value="{{ $functionalLocation['mel'] ?? '' }}"
                                disabled
                            />
                        </div>
                    </x-enterprise.field-row>
                </x-enterprise.panel>

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
                <x-enterprise.panel :muted="true" class="space-y-3">
                    <x-enterprise.date-row label="Uninstallation date">
                        <x-enterprise.input wire:model.live="uninstallationDate" class="attach-input" />
                        <span class="text-right text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Time</span>
                        <x-enterprise.input wire:model.live="uninstallationTime" class="attach-input" />
                        <x-enterprise.checkbox :inline="true" label="Scheduled" wire:model.live="uninstallationScheduled" />
                    </x-enterprise.date-row>

                    <x-enterprise.textarea-row label="Comment" :rows="2" wire:model.live="detachComment" />

                    <x-enterprise.checkbox
                        label="Update counters on Functional Location"
                        wire:model.live="updateCountersOnFunctionalLocation"
                    />

                    @foreach ([
                        ['label' => 'Return Reason 1', 'model' => 'returnReason1'],
                        ['label' => 'Return Reason 2', 'model' => 'returnReason2'],
                        ['label' => 'Return Reason 3', 'model' => 'returnReason3'],
                    ] as $field)
                        <x-enterprise.field-row :label="$field['label']">
                            <x-enterprise.input
                                variant="lookup"
                                class="attach-input"
                                wire:model.live="{{ $field['model'] }}"
                            />
                        </x-enterprise.field-row>
                    @endforeach
                </x-enterprise.panel>
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
                <x-enterprise.panel :muted="true" class="space-y-3" style="margin-bottom: 2.5rem;">
                    <x-enterprise.field-row label="Equipment ID">
                        <x-enterprise.input
                            variant="lookup"
                            class="attach-input"
                            value="{{ $selectedAvailableEquipment['equipment_id'] ?? '' }}"
                            disabled
                        />
                    </x-enterprise.field-row>

                    @foreach ([
                        ['label' => 'Serial no',     'key' => 'serial_no'],
                        ['label' => 'Item no',        'key' => 'item_no'],
                        ['label' => 'Category part',  'key' => 'category_part'],
                        ['label' => 'Variant',        'key' => 'variant'],
                    ] as $field)
                        <x-enterprise.field-row :label="$field['label']">
                            <x-enterprise.input
                                variant="disabled"
                                class="attach-input"
                                value="{{ $selectedAvailableEquipment[$field['key']] ?? '' }}"
                            />
                        </x-enterprise.field-row>
                    @endforeach
                </x-enterprise.panel>

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
                <x-enterprise.panel :muted="true" class="space-y-3">
                    <x-enterprise.date-row label="Installation date" :compact="true">
                        <x-enterprise.input wire:model.live="installationDate" class="attach-input" />
                        <span class="text-right text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Time</span>
                        <x-enterprise.input wire:model.live="installationTime" class="attach-input" />
                    </x-enterprise.date-row>

                    <x-enterprise.textarea-row label="Comment" :rows="2" wire:model.live="attachComment" />

                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                        <x-enterprise.checkbox
                            label="Update counters on Equipment"
                            wire:model.live="updateCountersOnEquipment"
                        />
                        <x-enterprise.checkbox
                            label="Update the Maintenance Plan"
                            wire:model.live="updateMaintenancePlan"
                        />
                    </div>

                    @foreach ([
                        ['model' => 'synchronizeCounters', 'label' => 'Synchronize Counters Date (using Installation Time and Date)'],
                        ['model' => 'inheritsOwner',       'label' => 'Equipment Inherits Owner from Functional Location'],
                        ['model' => 'inheritsMaintCenter', 'label' => 'Equipment Inherits Maintenance Center from Functional Location'],
                    ] as $option)
                        <x-enterprise.checkbox
                            :label="$option['label']"
                            wire:model.live="{{ $option['model'] }}"
                        />
                    @endforeach
                </x-enterprise.panel>
            </div>
        </div>

        <x-enterprise.action-bar>
            <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
            <a href="{{ route('fleet.functional-location.customer') }}" class="btn-secondary">Cancel</a>
        </x-enterprise.action-bar>
    </section>
</div>
