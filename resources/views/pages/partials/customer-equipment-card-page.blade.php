@php
    use App\Support\EquipmentCatalog;

    $emptyState = (bool) ($emptyState ?? false);
    $recordLoaded = ! $emptyState;
    $recordSelected = $recordLoaded;
    $selectedRecord = array_merge([
        'id' => (string) ($recordId ?? 1),
        'equipment_no' => (string) ($recordId ?? 1),
        'serial_number' => '31324',
        'item_no' => 'AW139',
        'item_description' => 'AW139',
        'category_part' => '',
        'variant' => 'AW139',
        'status' => 'On Aircraft',
        'owner_code' => '300028',
        'owner_name' => '*WESTSTAR',
        'operator_code' => '300028',
        'operator_name' => '*WESTSTAR',
        'operator_name_display' => 'Weststar',
        'maintenance_plan' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
        'mel' => '',
        'chapter' => 'AC',
        'section' => '00',
        'subject' => '00',
        'sheet' => '000',
        'mark' => '00',
        'mel_item' => '',
        'next_higher_serial_number' => '',
        'next_higher_item_no' => '',
        'next_higher_category_part' => '',
        'next_higher_equipment_no' => '',
        'next_higher_item_desc' => '',
        'top_assembly_serial_number' => '',
        'top_assembly_item_no' => '',
        'top_assembly_category_part' => '',
        'top_assembly_equipment_no' => '',
        'top_assembly_item_desc' => '',
        'functional_location_serial_number' => '31324',
        'functional_location_code' => '9M-WAA',
        'functional_location_registration' => 'M104-04',
        'functional_location_type' => 'AW139',
        'functional_location_position' => 'Airframe',
        'manufacturer_item_code' => '',
        'manufacturing_date' => '',
        'first_date_of_using' => '',
        'delivery_date' => '',
        'configuration_standard' => '',
        'purchase_cost_of_engine' => '',
        'remark_text' => '',
        'mission_type' => '',
        'maint_center_code' => '',
        'maint_center_name' => '',
        'external_key' => '',
        'environment_type' => '',
        'utilization_model' => '9M-WAA',
        'contract_type' => '',
        'oil_type' => '',
        'address_name' => '',
        'street' => '',
        'block' => '',
        'city' => '',
        'zip_code' => '',
        'county' => '',
        'state' => '',
        'country' => '',
        'location' => '',
        'anomaly_on_data' => '',
        'lock_flag' => '',
        'updated_by' => 'Wan Mohammad R',
        'update_date' => '29.04.19',
    ], $record ?? []);

    $clearFieldValues = static function (array $fields): array {
        return array_map(static function (array $field): array {
            $field['value'] = '';

            return $field;
        }, $fields);
    };

    $summaryLeftFields = [
        ['name' => 'equipment_no', 'label' => 'Equipment No.', 'value' => $selectedRecord['equipment_no']],
        ['name' => 'serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['serial_number']],
        ['name' => 'item_no', 'label' => 'Item No.', 'value' => $selectedRecord['item_no']],
        ['name' => 'item_description', 'label' => 'Item Description', 'value' => $selectedRecord['item_description']],
        ['name' => 'category_part', 'label' => 'Category Part', 'value' => $selectedRecord['category_part']],
        ['name' => 'variant', 'label' => 'Variant', 'value' => $selectedRecord['variant']],
    ];

    $summaryRightFields = [
        ['name' => 'status', 'label' => 'Status', 'value' => $selectedRecord['status']],
        ['name' => 'owner_code', 'label' => 'Owner Code', 'value' => $selectedRecord['owner_code']],
        ['name' => 'owner_name', 'label' => 'Owner Name', 'value' => $selectedRecord['owner_name']],
        ['name' => 'operator_code', 'label' => 'Operator Code', 'value' => $selectedRecord['operator_code']],
        ['name' => 'operator_name_display', 'label' => 'Operator Name', 'value' => $selectedRecord['operator_name_display']],
        ['name' => 'maintenance_plan', 'label' => 'Maintenance Plan', 'value' => $selectedRecord['maintenance_plan']],
        ['name' => 'mel', 'label' => 'MEL', 'value' => $selectedRecord['mel']],
    ];

    $generalMetaFields = [
        ['name' => 'chapter', 'label' => 'Chapter', 'value' => $selectedRecord['chapter']],
        ['name' => 'section', 'label' => 'Section', 'value' => $selectedRecord['section']],
        ['name' => 'subject', 'label' => 'Subject', 'value' => $selectedRecord['subject']],
        ['name' => 'sheet', 'label' => 'Sheet', 'value' => $selectedRecord['sheet']],
        ['name' => 'mark', 'label' => 'Mark', 'value' => $selectedRecord['mark']],
        ['name' => 'mel_item', 'label' => 'MEL Item', 'value' => $selectedRecord['mel_item']],
    ];

    $nextHigherAssemblyFields = [
        ['name' => 'next_higher_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['next_higher_serial_number']],
        ['name' => 'next_higher_item_no', 'label' => 'Item No.', 'value' => $selectedRecord['next_higher_item_no']],
        ['name' => 'next_higher_category_part', 'label' => 'Category Part', 'value' => $selectedRecord['next_higher_category_part']],
        ['name' => 'next_higher_equipment_no', 'label' => 'Equipment No', 'value' => $selectedRecord['next_higher_equipment_no']],
        ['name' => 'next_higher_item_desc', 'label' => 'Item Desc.', 'value' => $selectedRecord['next_higher_item_desc']],
    ];

    $topAssemblyFields = [
        ['name' => 'top_assembly_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['top_assembly_serial_number']],
        ['name' => 'top_assembly_item_no', 'label' => 'Item No.', 'value' => $selectedRecord['top_assembly_item_no']],
        ['name' => 'top_assembly_category_part', 'label' => 'Category Part', 'value' => $selectedRecord['top_assembly_category_part']],
        ['name' => 'top_assembly_equipment_no', 'label' => 'Equipment No', 'value' => $selectedRecord['top_assembly_equipment_no']],
        ['name' => 'top_assembly_item_desc', 'label' => 'Item Desc.', 'value' => $selectedRecord['top_assembly_item_desc']],
    ];

    $functionalLocationFields = [
        ['name' => 'functional_location_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['functional_location_serial_number']],
        ['name' => 'functional_location_registration', 'label' => 'Registration', 'value' => $selectedRecord['functional_location_registration']],
        ['name' => 'functional_location_type', 'label' => 'Type', 'value' => $selectedRecord['functional_location_type']],
        ['name' => 'functional_location_code', 'label' => 'Code', 'value' => $selectedRecord['functional_location_code']],
        ['name' => 'functional_location_position', 'label' => 'Position', 'value' => $selectedRecord['functional_location_position']],
    ];

    $tabs = [
        ['id' => 'general', 'label' => 'General', 'icon' => 'information-circle'],
        ['id' => 'bill-of-material', 'label' => 'Bill of Material', 'icon' => 'document-text'],
        ['id' => 'counters', 'label' => 'Counters', 'icon' => 'chart-bar'],
        ['id' => 'modifications', 'label' => 'Modif.', 'icon' => 'adjustments-horizontal'],
        ['id' => 'events', 'label' => 'Events', 'icon' => 'bell'],
        ['id' => 'properties', 'label' => 'Properties', 'icon' => 'sliders'],
        ['id' => 'address', 'label' => 'Address', 'icon' => 'document'],
        ['id' => 'trans', 'label' => 'Trans.', 'icon' => 'document'],
        ['id' => 'remark', 'label' => 'Remark', 'icon' => 'document-text'],
    ];

    $propertiesTabs = [
        ['id' => 'properties-1', 'label' => 'Properties1'],
        ['id' => 'properties-2', 'label' => 'Properties2'],
    ];

    $billOfMaterialRows = collect(['2', '4', '5', '7', '8', '15', '18', '3', '6', '9'])
        ->map(static fn (string $id): ?array => EquipmentCatalog::find($id))
        ->filter(static fn (?array $row): bool => $row !== null && $row['id'] !== (string) $selectedRecord['id'])
        ->values();

    $blankCounterRows = range(1, 6);
    $blankCounterSummaryRows = range(1, 4);
    $dbCounters = $dbCounters ?? collect();
    $dbCalendarCounter = $dbCalendarCounter ?? null;
    $equipmentModel = $equipmentModel ?? null;
    $blankModificationRows = range(1, 6);
    $blankEventRows = range(1, 8);

    $eventTabs = [
        ['id' => 'workpackages', 'label' => 'Workpackages'],
        ['id' => 'repairs', 'label' => 'Repairs'],
        ['id' => 'installed-base', 'label' => 'Installed Base'],
        ['id' => 'others', 'label' => 'Others'],
        ['id' => 'technical-log', 'label' => 'Technical Log'],
        ['id' => 'work-orders', 'label' => 'Work Orders'],
        ['id' => 'operations', 'label' => 'Operations'],
    ];

    $installedBaseRows = [
        [
            'code' => '661',
            'type' => 'Attach on FL',
            'date_event' => '10.11.10',
            'time_event' => '',
            'subject' => "Equipment attached to functional location '{$selectedRecord['functional_location_code']}' ({$selectedRecord['functional_location_type']} - {$selectedRecord['functional_location_serial_number']})",
        ],
    ];

    $propertiesTopLeftFields = [
        ['name' => 'manufacturer_item_code', 'label' => 'Manufacturer Item Code', 'value' => $selectedRecord['manufacturer_item_code']],
        ['name' => 'manufacturing_date', 'label' => 'Manufacturing date', 'value' => $selectedRecord['manufacturing_date']],
        ['name' => 'first_date_of_using', 'label' => 'First date of using', 'value' => $selectedRecord['first_date_of_using']],
        ['name' => 'delivery_date', 'label' => 'Delivery Date', 'value' => $selectedRecord['delivery_date']],
        ['name' => 'configuration_standard', 'label' => 'Configuration standard', 'value' => $selectedRecord['configuration_standard']],
    ];

    $propertiesTopRightFields = [
        ['name' => 'purchase_cost_of_engine', 'label' => 'Purchase Cost of Engine', 'value' => $selectedRecord['purchase_cost_of_engine']],
        ['name' => 'remark_text', 'label' => 'Remark', 'value' => $selectedRecord['remark_text']],
    ];

    $propertiesOperationalFields = [
        ['name' => 'mission_type', 'label' => 'Mission Type', 'value' => $selectedRecord['mission_type']],
        ['name' => 'maint_center_code', 'label' => 'Maint. Center Code', 'value' => $selectedRecord['maint_center_code']],
        ['name' => 'maint_center_name', 'label' => 'Maint. Center Name', 'value' => $selectedRecord['maint_center_name']],
        ['name' => 'external_key', 'label' => 'External Key', 'value' => $selectedRecord['external_key']],
        ['name' => 'environment_type', 'label' => 'Environment Type', 'value' => $selectedRecord['environment_type']],
        ['name' => 'utilization_model', 'label' => 'Utilization Model', 'value' => $selectedRecord['utilization_model']],
        ['name' => 'contract_type', 'label' => 'Contract Type', 'value' => $selectedRecord['contract_type']],
        ['name' => 'oil_type', 'label' => 'Oil Type', 'value' => $selectedRecord['oil_type']],
    ];

    $addressFields = [
        ['name' => 'address_name', 'label' => 'Name', 'value' => $selectedRecord['address_name']],
        ['name' => 'street', 'label' => 'Street', 'value' => $selectedRecord['street']],
        ['name' => 'block', 'label' => 'Block', 'value' => $selectedRecord['block']],
        ['name' => 'city', 'label' => 'City', 'value' => $selectedRecord['city']],
        ['name' => 'zip_code', 'label' => 'Zip Code', 'value' => $selectedRecord['zip_code']],
        ['name' => 'county', 'label' => 'County', 'value' => $selectedRecord['county']],
        ['name' => 'state', 'label' => 'State', 'value' => $selectedRecord['state']],
        ['name' => 'country', 'label' => 'Country', 'value' => $selectedRecord['country']],
    ];

    $workOrderRows = [
        [
            'code' => 'SDHOP0684',
            'intervention_type' => 'Maintenance',
            'status' => 'Planned',
            'start_date' => '',
            'close_date' => '',
            'work_center' => '',
            'title' => 'DISPI',
        ],
    ];

    $blankTransactionRows = range(1, 8);
    $placeholderPanels = [];

    $metadata = [
        ['label' => 'Updated By', 'value' => $selectedRecord['updated_by']],
        ['label' => 'Update Date', 'value' => $selectedRecord['update_date']],
    ];

    if ($emptyState) {
        $summaryLeftFields = $clearFieldValues($summaryLeftFields);
        $summaryRightFields = $clearFieldValues($summaryRightFields);
        $generalMetaFields = $clearFieldValues($generalMetaFields);
        $nextHigherAssemblyFields = $clearFieldValues($nextHigherAssemblyFields);
        $topAssemblyFields = $clearFieldValues($topAssemblyFields);
        $functionalLocationFields = $clearFieldValues($functionalLocationFields);
        $propertiesTopLeftFields = $clearFieldValues($propertiesTopLeftFields);
        $propertiesTopRightFields = $clearFieldValues($propertiesTopRightFields);
        $propertiesOperationalFields = $clearFieldValues($propertiesOperationalFields);
        $addressFields = $clearFieldValues($addressFields);
        $billOfMaterialRows = collect();
        $installedBaseRows = [];
        $workOrderRows = [];
        $metadata = [
            ['label' => 'Updated By', 'value' => ''],
            ['label' => 'Update Date', 'value' => ''],
        ];
    }
@endphp

<div x-data="editMode(false)" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
<div class="space-y-6" x-data="tabs('general')">
    <x-page-header
        :title="$title"
        :description="$recordLoaded
            ? 'Equipment customer-card workspace using populated form controls and the approved ATP tab style.'
            : 'Blank customer equipment card shell ready for record lookup from Search Equipments.'"
    >
        @if ($recordLoaded)
            <x-slot name="actions">
                <template x-if="!editing">
                    <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-primary" @click="save()">Save</button>
                </template>
            </x-slot>
        @endif
    </x-page-header>

    @unless ($recordLoaded)
        <x-empty-state
            icon="magnifying-glass"
            label="No equipment selected"
            description="Open Search Equipments and click an equipment ID row to populate this workspace with ownership, bill of material, counters, and event data."
        >
            <a href="{{ route('fleet.equipment.index') }}" class="btn-primary">Go to Search Equipments</a>
        </x-empty-state>
    @endunless

    <x-card title="Customer Equipment Card" description="Key equipment identity, ownership, and maintenance reference fields." padding="p-6">
        @if ($equipmentModel ?? null)
            @livewire('fleet.equipment-show-form', ['equipmentId' => $equipmentModel->id], key('equipment-show-form-'.$equipmentModel->id))
        @else
            <div class="grid gap-6 xl:grid-cols-2">
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($summaryLeftFields as $field)
                        <x-form.input
                            :label="$field['label']"
                            :name="$field['name']"
                            :value="$field['value']"
                            readonly
                            class="input-field-filled"
                        />
                    @endforeach
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($summaryRightFields as $field)
                        <x-form.input
                            :label="$field['label']"
                            :name="$field['name']"
                            :value="$field['value']"
                            readonly
                            class="input-field-filled"
                        />
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-5 flex flex-wrap gap-3">
            @if ($recordLoaded)
                <a href="{{ route('fleet.modification.equipment-reference-evolution') }}" class="btn-secondary">Change References</a>
                <a href="{{ route('fleet.technical-logs.create', ['equipment_id' => $selectedRecord['id']]) }}" class="btn-secondary">Technical Log</a>
            @else
                <button type="button" class="btn-secondary" disabled>Change References</button>
                <button type="button" class="btn-secondary" disabled>Technical Log</button>
            @endif
        </div>
    </x-card>

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

    <div x-cloak x-show="activeTab === 'general'" class="space-y-6">
        <x-card title="General" description="Assembly relationships and linked functional-location context for the selected equipment." padding="p-6">
            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                    @foreach (array_slice($generalMetaFields, 0, 5) as $field)
                        <x-form.input
                            :label="$field['label']"
                            :name="$field['name']"
                            :value="$field['value']"
                            readonly
                            class="input-field-filled"
                        />
                    @endforeach
                </div>

                <x-form.input
                    :label="$generalMetaFields[5]['label']"
                    :name="$generalMetaFields[5]['name']"
                    :value="$generalMetaFields[5]['value']"
                    readonly
                    class="input-field-filled"
                />
            </div>

            <div class="mt-6 space-y-4">
                <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0 flex-1 space-y-4">
                            <div class="flex items-center gap-3">
                                <h4 class="text-sm font-semibold text-gray-900">Next Higher Assembly</h4>
                                <div class="h-px flex-1 bg-gray-200"></div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-3">
                                @foreach (array_slice($nextHigherAssemblyFields, 0, 3) as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (array_slice($nextHigherAssemblyFields, 3, 2) as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="flex shrink-0 gap-3 xl:flex-col">
                            <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>History</button>
                            <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>Attach</button>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0 flex-1 space-y-4">
                            <div class="flex items-center gap-3">
                                <h4 class="text-sm font-semibold text-gray-900">Top Assembly</h4>
                                <div class="h-px flex-1 bg-gray-200"></div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-3">
                                @foreach (array_slice($topAssemblyFields, 0, 3) as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (array_slice($topAssemblyFields, 3, 2) as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0 flex-1 space-y-4">
                            <div class="flex items-center gap-3">
                                <h4 class="text-sm font-semibold text-gray-900">Functional Location</h4>
                                <div class="h-px flex-1 bg-gray-200"></div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-3">
                                @foreach (array_slice($functionalLocationFields, 0, 3) as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (array_slice($functionalLocationFields, 3, 2) as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="flex shrink-0 gap-3 xl:flex-col">
                            <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>History</button>
                            <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>Detach</button>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'bill-of-material'" class="space-y-6">
        <x-card title="Bill of Material" description="Installed component structure for the selected equipment." padding="p-6">
                <div class="space-y-5">
                    <x-data-table>
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">ID</th>
                                <th class="table-th">Serial Number</th>
                                <th class="table-th">Item No</th>
                                <th class="table-th">Item Description</th>
                                <th class="table-th">Category Part</th>
                            </tr>
                        </x-slot>

                        <x-slot name="tbody">
                            @foreach ($billOfMaterialRows as $row)
                                <tr class="table-row">
                                    <td class="table-td">
                                        <a href="{{ route('fleet.equipment.show', ['id' => $row['id']]) }}" class="group/drill inline-flex items-center gap-3 font-semibold text-gray-900 transition hover:text-blue-700">
                                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                            </span>
                                            <span>{{ $row['id'] }}</span>
                                        </a>
                                    </td>
                                    <td class="table-td">{{ $row['serial_number'] !== '' ? $row['serial_number'] : 'N/A' }}</td>
                                    <td class="table-td font-medium text-gray-900">{{ $row['item_no'] }}</td>
                                    <td class="table-td">{{ $row['item_name'] }}</td>
                                    <td class="table-td">{{ $row['category_part'] !== '' ? $row['category_part'] : 'O/C' }}</td>
                                </tr>
                            @endforeach
                            @foreach (range(1, 8) as $rowNumber)
                                <tr class="table-row">
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('fleet.fleet-management-cockpit') }}" class="btn-secondary @if (! $recordLoaded) pointer-events-none opacity-50 @endif">Fleet Mngt Cockpit</a>
                        <a href="{{ route('fleet.equipment.attach-equipment') }}" class="btn-secondary @if (! $recordLoaded) pointer-events-none opacity-50 @endif">Attach Equipment</a>
                        <a href="{{ route('fleet.equipment.detach-equipment') }}" class="btn-secondary @if (! $recordLoaded) pointer-events-none opacity-50 @endif">Detach Equipment</a>
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'counters'" class="space-y-6">
        <x-card title="Counters" description="Counter grids and quick actions for the selected equipment." padding="p-6">
                <div class="space-y-5">
                    <x-data-table>
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">Counter Desc</th>
                                <th class="table-th">Value</th>
                                <th class="table-th">!</th>
                                <th class="table-th">Unit</th>
                                <th class="table-th">Reading Date</th>
                                <th class="table-th">Max</th>
                                <th class="table-th">Remaining</th>
                                <th class="table-th">Residual</th>
                                <th class="table-th">Equi. ID</th>
                                <th class="table-th">Info. Source</th>
                            </tr>
                        </x-slot>

                        <x-slot name="tbody">
                            @if ($dbCounters->isNotEmpty())
                                @foreach ($dbCounters as $c)
                                    @php
                                        $value = $c->value_hhmm ?: ($c->value_dec !== null ? number_format((float) $c->value_dec, 4) : '');
                                        $max = $c->max_hhmm ?: ($c->max_dec !== null ? number_format((float) $c->max_dec, 4) : '');
                                    @endphp
                                    <tr @class(['table-row', 'text-gray-400' => ! $c->is_used])>
                                        <td class="table-td font-medium">{{ $c->counterRef?->name }}</td>
                                        <td class="table-td">{{ $value }}</td>
                                        <td class="table-td"><span class="inline-block h-2.5 w-2.5 rounded-full {{ $c->is_used ? 'bg-emerald-500' : 'bg-gray-300' }}"></span></td>
                                        <td class="table-td">{{ $c->counterRef?->measure_unit }}</td>
                                        <td class="table-td">{{ optional($c->reading_date)->format('d.m.y') }}</td>
                                        <td class="table-td">{{ $max }}</td>
                                        <td class="table-td">{{ $c->remaining }}</td>
                                        <td class="table-td">{{ $c->residual }}</td>
                                        <td class="table-td">{{ $c->linked_equipment_id }}</td>
                                        <td class="table-td">{{ $c->info_source }}</td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($blankCounterRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-data-table>

                    <x-data-table>
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">Counter Desc</th>
                                <th class="table-th">Value</th>
                                <th class="table-th">!</th>
                                <th class="table-th">Unit</th>
                                <th class="table-th">Limit</th>
                                <th class="table-th">Remaining</th>
                                <th class="table-th">Residual</th>
                                <th class="table-th">Equi. ID</th>
                                <th class="table-th">Info. Source</th>
                            </tr>
                        </x-slot>

                        <x-slot name="tbody">
                            @if ($dbCalendarCounter)
                                <tr @class(['table-row', 'text-gray-400' => ! $dbCalendarCounter->is_used])>
                                    <td class="table-td font-medium">{{ $dbCalendarCounter->label }}</td>
                                    <td class="table-td">{{ optional($dbCalendarCounter->value_date)->format('d.m.y') }}</td>
                                    <td class="table-td">
                                        @if (! $dbCalendarCounter->is_used)
                                            <span class="font-bold text-red-500">X</span>
                                        @else
                                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                        @endif
                                    </td>
                                    <td class="table-td">Days</td>
                                    <td class="table-td">{{ $dbCalendarCounter->limit }}</td>
                                    <td class="table-td">{{ $dbCalendarCounter->remaining }}</td>
                                    <td class="table-td">{{ $dbCalendarCounter->residual }}</td>
                                    <td class="table-td"></td>
                                    <td class="table-td">{{ $dbCalendarCounter->info_source }}</td>
                                </tr>
                            @else
                                @foreach ($blankCounterSummaryRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-data-table>

                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="btn-primary"
                                @disabled(! $equipmentModel)
                                @if ($equipmentModel) @click="$dispatch('open-equipment-counters', { equipmentId: {{ $equipmentModel->id }} })" @endif>
                            Update Counters
                        </button>
                        <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>Counter History</button>
                        <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>Counters Reading</button>
                        <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>Counter Hierarchy</button>
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'modifications'" class="space-y-6">
        <x-card title="Modifications" description="Modification register and actions for the selected equipment." padding="p-6">
                <div class="space-y-5">
                    <x-data-table>
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">!</th>
                                <th class="table-th">Type</th>
                                <th class="table-th">Reference</th>
                                <th class="table-th">Revision</th>
                                <th class="table-th">Embodied</th>
                                <th class="table-th">Applied On</th>
                                <th class="table-th">Deleted</th>
                                <th class="table-th">Removed On</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">Comment</th>
                            </tr>
                        </x-slot>

                        <x-slot name="tbody">
                            @foreach ($blankModificationRows as $rowNumber)
                                <tr class="table-row">
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                    <td class="table-td"><span class="invisible">.</span></td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('reports.view-modification-on-equipment') }}" class="btn-secondary @if (! $recordLoaded) pointer-events-none opacity-50 @endif">View modification on all equipment</a>
                        <a href="{{ route('fleet.modification.apply-on-equipment') }}" class="btn-secondary @if (! $recordLoaded) pointer-events-none opacity-50 @endif">Apply modification</a>
                        <button type="button" class="btn-secondary" @disabled(! $recordLoaded)>Remove modification</button>
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'events'" class="space-y-6">
        <x-card title="Events" description="Operational history grouped into the event subtabs from the equipment card workflow." padding="p-6">
                <div class="space-y-5" x-data="tabs('workpackages')">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 pt-3">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                @foreach ($eventTabs as $tab)
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

                    <div x-cloak x-show="activeTab === 'workpackages'">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">Code</th>
                                    <th class="table-th">Status</th>
                                    <th class="table-th">Simulation Date</th>
                                    <th class="table-th">Planned Date</th>
                                    <th class="table-th">Released Date</th>
                                    <th class="table-th">Close Date</th>
                                    <th class="table-th">Comment</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($blankEventRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>
                    </div>

                    <div x-cloak x-show="activeTab === 'repairs'">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">Code</th>
                                    <th class="table-th">Intervention Type</th>
                                    <th class="table-th">Status</th>
                                    <th class="table-th">Date In</th>
                                    <th class="table-th">Date Out</th>
                                    <th class="table-th">Return Reason</th>
                                    <th class="table-th">Subject</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($blankEventRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>
                    </div>

                    <div x-cloak x-show="activeTab === 'installed-base'" class="space-y-4">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">Code</th>
                                    <th class="table-th">Type</th>
                                    <th class="table-th">Date Event</th>
                                    <th class="table-th">Time Event</th>
                                    <th class="table-th">Subject</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($installedBaseRows as $row)
                                    <tr class="table-row">
                                        <td class="table-td">
                                            <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                </span>
                                                <span>{{ $row['code'] }}</span>
                                            </span>
                                        </td>
                                        <td class="table-td">{{ $row['type'] }}</td>
                                        <td class="table-td">{{ $row['date_event'] }}</td>
                                        <td class="table-td">{{ $row['time_event'] }}</td>
                                        <td class="table-td">{{ $row['subject'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach (range(1, 6) as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>

                        <div class="flex flex-col gap-3 border border-gray-200 bg-gray-50/80 px-4 py-3 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <x-icon name="x-circle" class="h-4 w-4 text-gray-500" />
                                <span>Father information with this cross is not available</span>
                            </div>
                            <button type="button" class="btn-secondary">Display Counter</button>
                        </div>
                    </div>

                    <div x-cloak x-show="activeTab === 'others'">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">Code</th>
                                    <th class="table-th">Creation date</th>
                                    <th class="table-th">Date Event</th>
                                    <th class="table-th">Type</th>
                                    <th class="table-th">Subject</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($blankEventRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>
                    </div>

                    <div x-cloak x-show="activeTab === 'technical-log'">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">!</th>
                                    <th class="table-th">Log Number</th>
                                    <th class="table-th">Description</th>
                                    <th class="table-th">Status</th>
                                    <th class="table-th">ATA</th>
                                    <th class="table-th">MEL Item Ref.</th>
                                    <th class="table-th">MEL Item Name</th>
                                    <th class="table-th">Task Number</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($blankEventRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>
                    </div>

                    <div x-cloak x-show="activeTab === 'work-orders'">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">Code</th>
                                    <th class="table-th">Intervention Type</th>
                                    <th class="table-th">Status</th>
                                    <th class="table-th">Start Date</th>
                                    <th class="table-th">Close Date</th>
                                    <th class="table-th">Work Center</th>
                                    <th class="table-th">Title</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($workOrderRows as $row)
                                    <tr class="table-row">
                                        <td class="table-td">
                                            <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                </span>
                                                <span>{{ $row['code'] }}</span>
                                            </span>
                                        </td>
                                        <td class="table-td">{{ $row['intervention_type'] }}</td>
                                        <td class="table-td">{{ $row['status'] }}</td>
                                        <td class="table-td">{{ $row['start_date'] }}</td>
                                        <td class="table-td">{{ $row['close_date'] }}</td>
                                        <td class="table-td">{{ $row['work_center'] }}</td>
                                        <td class="table-td">{{ $row['title'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach (range(1, 6) as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>
                    </div>

                    <div x-cloak x-show="activeTab === 'operations'">
                        <x-data-table>
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">Work order Code</th>
                                    <th class="table-th">Operation Code</th>
                                    <th class="table-th">Description</th>
                                    <th class="table-th">Close Date</th>
                                    <th class="table-th">Closed By</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($blankEventRows as $rowNumber)
                                    <tr class="table-row">
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                        <td class="table-td"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'properties'" class="space-y-6">
        <x-card title="Properties" description="Commercial, configuration, and anomaly metadata for the selected equipment." padding="p-6">
                <div class="space-y-5" x-data="tabs('properties-1')">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 pt-3">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                @foreach ($propertiesTabs as $tab)
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

                    <div x-cloak x-show="activeTab === 'properties-1'" class="space-y-5">
                        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(0,0.9fr)]">
                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ($propertiesTopLeftFields as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ($propertiesTopRightFields as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ($propertiesOperationalFields as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                                <div class="flex items-center gap-3">
                                    <h4 class="text-sm font-semibold text-gray-900">Installed Base Data Anomaly</h4>
                                    <div class="h-px flex-1 bg-gray-200"></div>
                                </div>

                                <div class="mt-4 space-y-4">
                                    <div class="flex flex-wrap gap-5">
                                        <label class="flex items-center gap-3 text-sm text-gray-700">
                                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($selectedRecord['anomaly_on_data'] !== '')>
                                            <span>Anomaly on Data</span>
                                        </label>
                                        <label class="flex items-center gap-3 text-sm text-gray-400">
                                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($selectedRecord['lock_flag'] !== '')>
                                            <span>Lock</span>
                                        </label>
                                    </div>

                                    <div class="flex justify-start xl:justify-end">
                                        <button type="button" class="btn-secondary px-4 py-2 text-xs">Comment</button>
                                    </div>

                                    <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_120px]">
                                        <x-form.input
                                            label="Updated By"
                                            name="properties_updated_by"
                                            :value="$selectedRecord['updated_by']"
                                            readonly
                                            class="input-field-filled"
                                        />
                                        <x-form.input
                                            label="Date"
                                            name="properties_update_date"
                                            :value="$selectedRecord['update_date']"
                                            readonly
                                            class="input-field-filled"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="activeTab === 'properties-2'">
                        <div class="min-h-[360px] rounded-xl border border-gray-200 bg-gray-50/30"></div>
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'address'" class="space-y-6">
        <x-card title="Address" description="Address capture and owner/operator sourcing for the selected equipment." padding="p-6">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ($addressFields as $field)
                            <div class="grid grid-cols-[104px_minmax(0,1fr)] items-center gap-3">
                                <label for="{{ $field['name'] }}" class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                                <input
                                    id="{{ $field['name'] }}"
                                    name="{{ $field['name'] }}"
                                    type="text"
                                    value="{{ $field['value'] }}"
                                    readonly
                                    class="input-field input-field-filled"
                                />
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-6">
                        <div class="grid gap-4 sm:grid-cols-[minmax(0,1fr)_172px] sm:items-start">
                            <div class="space-y-3">
                                <p class="text-sm font-medium text-gray-600">Obtain address from</p>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 text-sm text-gray-700">
                                        <input type="radio" name="equipment_address_source" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span>Owner</span>
                                    </label>
                                    <label class="flex items-center gap-3 text-sm text-gray-700">
                                        <input type="radio" name="equipment_address_source" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span>Operator</span>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-6 sm:pt-7">
                                <button type="button" class="btn-secondary w-full justify-center">Obtain</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-[92px_minmax(0,1fr)] items-end gap-3">
                            <label for="equipment_location" class="text-sm font-medium text-gray-600">Location</label>
                            <textarea
                                id="equipment_location"
                                name="equipment_location"
                                rows="5"
                                readonly
                                class="input-field input-field-filled min-h-[168px] resize-none"
                            >{{ $selectedRecord['location'] }}</textarea>
                        </div>
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'trans'" class="space-y-6">
        <x-card title="Trans." description="Transaction history grid for the selected equipment." padding="p-6">
                <x-data-table>
                    <x-slot name="thead">
                        <tr>
                            <th class="table-th">Trans. ...</th>
                            <th class="table-th">Source</th>
                            <th class="table-th">Docum...</th>
                            <th class="table-th">Row No</th>
                            <th class="table-th">Date</th>
                            <th class="table-th">Whse</th>
                            <th class="table-th">G/L Acct/BP ...</th>
                            <th class="table-th">G/L Acct/BP Name</th>
                            <th class="table-th">Directi...</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        @foreach ($blankTransactionRows as $rowNumber)
                            <tr class="table-row">
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                                <td class="table-td"><span class="invisible">.</span></td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'remark'" class="space-y-6">
        <x-card title="Remark" description="Free-form remark workspace for the selected equipment." padding="p-6">
                <div class="min-h-[360px] rounded-xl border border-gray-200 bg-gray-50/30"></div>
        </x-card>
    </div>

    @foreach ($placeholderPanels as $tabId => $panel)
        <div x-cloak x-show="activeTab === '{{ $tabId }}'" class="space-y-6">
            <x-card :title="$panel['title']" :description="$panel['description']" padding="p-6">
                @if ($recordSelected)
                    <x-empty-state
                        icon="document"
                        :label="$panel['title'] . ' preview'"
                        description="This tab is reserved for the next implementation pass. The customer equipment card shell is ready, and this panel will be populated when its detailed screenshot/spec arrives."
                    />
                @else
                    <x-empty-state
                        icon="magnifying-glass"
                        :label="'No equipment selected for ' . $panel['title']"
                        description="Select a record from Search Equipments first, then this tab will show the customer equipment data for the chosen equipment."
                    />
                @endif
            </x-card>
        </div>
    @endforeach

    <div class="sticky-form-actions">
        @if (! $recordLoaded)
            <a href="{{ route('fleet.equipment.index') }}" class="btn-primary">Find</a>
            <div class="mx-auto">
                <x-record-meta :items="$metadata" />
            </div>
            <button type="button" class="btn-secondary">Cancel</button>
        @else
            <div class="mr-auto">
                <x-record-meta :items="$metadata" />
            </div>
            <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
            <button type="button" class="btn-primary" @click="save()">OK</button>
        @endif
    </div>
</div>
</div>
