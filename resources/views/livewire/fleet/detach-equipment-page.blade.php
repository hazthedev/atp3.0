<div class="space-y-6">
    <x-page-header
        title="Detach Equipment from Functional Location"
        description="Single-table detachment workspace — locate a functional location or search by equipment code, then detach."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="attach-workspace-shell space-y-4">

        {{-- ── TOP: Functional location fields + Search via equipment ── --}}
        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_220px]">

            {{-- Left: FL lookup fields --}}
            <x-enterprise.panel :muted="true" class="space-y-3">
                <x-enterprise.field-row label="Code" for="detach_fl_code">
                    <x-enterprise.input
                        id="detach_fl_code"
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
            </x-enterprise.panel>

            {{-- Right: Search via equipment + Equipment Code --}}
            <x-enterprise.panel :muted="true" class="flex flex-col gap-3">
                <button type="button" wire:click="searchViaEquipment" class="btn-primary w-full justify-center">
                    Search via equipment
                </button>

                <div class="space-y-1.5">
                    <label for="detach_equipment_code" class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">
                        Equipment Code
                    </label>
                    <x-enterprise.input
                        id="detach_equipment_code"
                        wire:model.live="equipmentCode"
                        wire:keydown.enter.prevent="searchViaEquipment"
                        class="attach-input"
                    />
                </div>
            </x-enterprise.panel>
        </div>

        {{-- ── TOOLBAR: checkboxes + Detach button ── --}}
        <div class="flex items-center gap-5 rounded-xl border border-gray-200 bg-gray-50/80 px-4 py-2.5">
            <x-enterprise.checkbox label="Update counters" wire:model.live="updateCounters" />
            <x-enterprise.checkbox label="Scheduled" wire:model.live="scheduled" />

            <div class="ml-auto">
                <button
                    type="button"
                    wire:click="detachSelected"
                    class="btn-primary"
                    @disabled($selectedInstalledEquipmentId === null)
                >
                    Detach
                </button>
            </div>
        </div>

        {{-- ── TABLE: Installed equipment ── --}}
        <x-enterprise.table-shell
            datatable="false"
            table-class="attach-grid-table"
            :min-rows="9"
            :row-count="count($installedEquipment)"
        >
            <x-slot:thead>
                <tr>
                    <th>Designation</th>
                    <th>Item Code</th>
                    <th>Serial Number</th>
                    <th>Install date</th>
                </tr>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($installedEquipment as $row)
                    <tr
                        wire:key="detach-installed-{{ $row['equipment_id'] }}"
                        wire:click="selectInstalledEquipment('{{ $row['equipment_id'] }}')"
                        class="{{ $selectedInstalledEquipmentId === $row['equipment_id'] ? 'is-selected' : '' }}"
                    >
                        <td>{{ $row['designation'] }}</td>
                        <td>{{ $row['item_code'] }}</td>
                        <td>{{ $row['serial_number'] }}</td>
                        <td>{{ $row['install_date'] }}</td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-enterprise.table-shell>

        {{-- ── BOTTOM: Date / comment + Return reasons ── --}}
        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">

            {{-- Left: date, time, comment --}}
            <x-enterprise.panel :muted="true" class="space-y-3">
                <x-enterprise.date-row label="UnInstallation date" :compact="true">
                    <x-enterprise.input wire:model.live="uninstallationDate" class="attach-input" />
                    <span class="text-right text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Time</span>
                    <x-enterprise.input wire:model.live="uninstallationTime" class="attach-input" />
                </x-enterprise.date-row>

                <x-enterprise.textarea-row label="Comment" :rows="3" wire:model.live="comment" />
            </x-enterprise.panel>

            {{-- Right: Return reasons --}}
            <x-enterprise.panel :muted="true" class="space-y-3">
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

        {{-- ── FOOTER ── --}}
        <x-enterprise.action-bar>
            <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
            <a href="{{ route('fleet.functional-location.customer') }}" class="btn-secondary">Cancel</a>
        </x-enterprise.action-bar>

    </section>
</div>
