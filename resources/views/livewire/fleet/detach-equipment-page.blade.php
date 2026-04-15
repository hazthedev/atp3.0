@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };

    $paddingRows = max(0, 9 - count($installedEquipment));
@endphp

<div class="space-y-6">
    <x-page-header
        title="Detach Equipment from Functional Location"
        description="Single-table detachment workspace following the original equipment-tree layout while keeping the ATP design system."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="attach-workspace-shell">
        {{-- Lookup panels — always visible so users can type a code --}}
        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_240px]">
            <div class="attach-panel attach-panel-muted">
                <div class="attach-field-grid">
                    <label class="attach-field-label" for="detach_functional_location_code">Code</label>
                    <div class="attach-inline-control">
                        <input
                            id="detach_functional_location_code"
                            type="text"
                            wire:model.blur="functionalLocationCode"
                            wire:keydown.enter.prevent="loadFunctionalLocation"
                            class="input-field attach-input attach-input-highlight"
                        />
                        <button type="button" wire:click="loadFunctionalLocation" class="attach-mini-button">Go</button>
                    </div>
                </div>

                @foreach ([
                    ['label' => 'Serial no', 'value' => $functionalLocation['serial_no'] ?? ''],
                    ['label' => 'Registration', 'value' => $functionalLocation['registration'] ?? ''],
                    ['label' => 'Type', 'value' => $functionalLocation['type'] ?? ''],
                ] as $field)
                    <div class="attach-field-grid">
                        <span class="attach-field-label">{{ $field['label'] }}</span>
                        <input type="text" readonly value="{{ $field['value'] }}" class="input-field attach-input attach-input-readonly" />
                    </div>
                @endforeach
            </div>

            <div class="attach-panel attach-panel-muted flex flex-col gap-3">
                <button type="button" wire:click="searchViaEquipment" class="btn-secondary w-full justify-center">
                    Search via equipment
                </button>

                <div class="space-y-2">
                    <label class="attach-field-label" for="detach_equipment_code">Equipment Code</label>
                    <input
                        id="detach_equipment_code"
                        type="text"
                        wire:model.live="equipmentCode"
                        wire:keydown.enter.prevent="searchViaEquipment"
                        class="input-field attach-input"
                    />
                </div>
            </div>
        </div>

        @if ($recordLoaded)
            <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-center gap-4 border-b border-gray-200 bg-gray-50/80 px-4 py-3">
                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="updateCounters" />
                        <span>Update counters</span>
                    </label>

                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="scheduled" />
                        <span>Scheduled</span>
                    </label>

                    <div class="ml-auto"></div>

                    <button type="button" wire:click="detachSelected" class="btn-primary" @disabled($selectedInstalledEquipmentId === null)>
                        Detach
                    </button>
                </div>

                <table class="attach-grid-table">
                    <thead>
                        <tr>
                            <th>Designation</th>
                            <th>Item Code</th>
                            <th>Serial Number</th>
                            <th>Install date</th>
                        </tr>
                    </thead>
                    <tbody>
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

                        @for ($i = 0; $i < $paddingRows; $i++)
                            <tr class="is-empty"><td>&nbsp;</td><td></td><td></td><td></td></tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="mt-4 grid gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
                <div class="attach-panel attach-panel-muted space-y-3">
                    <div class="attach-date-row">
                        <span class="attach-field-label">UnInstallation date</span>
                        <input type="text" wire:model.live="uninstallationDate" class="input-field attach-input" />
                        <span class="attach-field-label attach-inline-label">Time</span>
                        <input type="text" wire:model.live="uninstallationTime" class="input-field attach-input" />
                        <span></span>
                    </div>

                    <div class="attach-textarea-row">
                        <span class="attach-field-label">Comment</span>
                        <textarea rows="3" wire:model.live="comment" class="input-field attach-textarea"></textarea>
                    </div>
                </div>

                <div class="attach-panel attach-panel-muted space-y-3">
                    @foreach ([
                        ['label' => 'Return Reason 1', 'model' => 'returnReason1'],
                        ['label' => 'Return Reason 2', 'model' => 'returnReason2'],
                        ['label' => 'Return Reason 3', 'model' => 'returnReason3'],
                    ] as $field)
                        <div class="attach-field-grid">
                            <span class="attach-field-label">{{ $field['label'] }}</span>
                            <div class="attach-inline-control">
                                <input type="text" wire:model.live="{{ $field['model'] }}" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <footer class="attach-workspace-footer">
                <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
                <a href="{{ route('fleet.functional-location.customer') }}" class="btn-secondary">Cancel</a>
            </footer>
        @else
            <x-empty-state
                icon="magnifying-glass"
                label="No functional location selected"
                description="Enter a functional location code above and press Go, or open Search Functional Locations to select a record."
            >
                <a href="{{ route('fleet.functional-location.index') }}" class="btn-primary">Go to Search Functional Locations</a>
            </x-empty-state>
        @endif
    </section>
</div>
