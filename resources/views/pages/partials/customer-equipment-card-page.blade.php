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
        'owner_name' => '*WESTSTAR',
        'operator_name' => '*WESTSTAR',
        'operator_name_display' => 'Weststar',
        'maintenance_plan' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
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
        'manufacturing_date' => '',
        'first_date_of_using' => '',
        'delivery_date' => '',
        'maint_center_code' => '',
        'maint_center_name' => '',
        'utilization_model' => '9M-WAA',
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
        ['name' => 'owner_name', 'label' => 'Owner Name', 'value' => $selectedRecord['owner_name']],
        ['name' => 'operator_name_display', 'label' => 'Operator Name', 'value' => $selectedRecord['operator_name_display']],
        ['name' => 'maintenance_plan', 'label' => 'Maintenance Plan', 'value' => $selectedRecord['maintenance_plan']],
    ];

    $generalMetaFields = [
        ['name' => 'chapter', 'label' => 'Chapter', 'value' => $selectedRecord['chapter'], 'variant' => null],
        ['name' => 'section', 'label' => 'Section', 'value' => $selectedRecord['section'], 'variant' => null],
        ['name' => 'subject', 'label' => 'Subject', 'value' => $selectedRecord['subject'], 'variant' => null],
        ['name' => 'sheet', 'label' => 'Sheet', 'value' => $selectedRecord['sheet'], 'variant' => null],
        ['name' => 'mark', 'label' => 'Mark', 'value' => $selectedRecord['mark'], 'variant' => 'indicator', 'tone' => 'green'],
        ['name' => 'mel_item', 'label' => 'MEL Item', 'value' => $selectedRecord['mel_item'], 'variant' => 'lookup'],
    ];

    $nextHigherAssemblyFields = [
        ['name' => 'next_higher_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['next_higher_serial_number'], 'variant' => 'tree'],
        ['name' => 'next_higher_item_no', 'label' => 'Item No.', 'value' => $selectedRecord['next_higher_item_no'], 'variant' => null],
        ['name' => 'next_higher_category_part', 'label' => 'Category Part', 'value' => $selectedRecord['next_higher_category_part'], 'variant' => 'lookup'],
        ['name' => 'next_higher_equipment_no', 'label' => 'Equipment No', 'value' => $selectedRecord['next_higher_equipment_no'], 'variant' => null],
        ['name' => 'next_higher_item_desc', 'label' => 'Item Desc.', 'value' => $selectedRecord['next_higher_item_desc'], 'variant' => null],
    ];

    $topAssemblyFields = [
        ['name' => 'top_assembly_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['top_assembly_serial_number'], 'variant' => 'tree'],
        ['name' => 'top_assembly_item_no', 'label' => 'Item No.', 'value' => $selectedRecord['top_assembly_item_no'], 'variant' => null],
        ['name' => 'top_assembly_category_part', 'label' => 'Category Part', 'value' => $selectedRecord['top_assembly_category_part'], 'variant' => 'lookup'],
        ['name' => 'top_assembly_equipment_no', 'label' => 'Equipment No', 'value' => $selectedRecord['top_assembly_equipment_no'], 'variant' => null],
        ['name' => 'top_assembly_item_desc', 'label' => 'Item Desc.', 'value' => $selectedRecord['top_assembly_item_desc'], 'variant' => null],
    ];

    $functionalLocationFields = [
        ['name' => 'functional_location_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['functional_location_serial_number'], 'variant' => 'tree'],
        ['name' => 'functional_location_registration', 'label' => 'Registration', 'value' => $selectedRecord['functional_location_registration'], 'variant' => null],
        ['name' => 'functional_location_type', 'label' => 'Type', 'value' => $selectedRecord['functional_location_type'], 'variant' => 'lookup'],
        ['name' => 'functional_location_code', 'label' => 'Code', 'value' => $selectedRecord['functional_location_code'], 'variant' => 'arrow-lookup'],
        ['name' => 'functional_location_position', 'label' => 'Position', 'value' => $selectedRecord['functional_location_position'], 'variant' => null],
    ];

    $tabs = [
        ['id' => 'general', 'label' => 'General', 'icon' => 'information-circle'],
        ['id' => 'bill-of-material', 'label' => 'Bill of Material', 'icon' => 'document-text'],
        ['id' => 'counters', 'label' => 'Counters', 'icon' => 'chart-bar'],
        ['id' => 'modifications', 'label' => 'Modif.', 'icon' => 'adjustments-horizontal'],
        ['id' => 'events', 'label' => 'Events', 'icon' => 'bell'],
        ['id' => 'properties', 'label' => 'Properties', 'icon' => 'sliders'],
        ['id' => 'maintenance', 'label' => 'Maintenance', 'icon' => 'wrench-screwdriver'],
    ];

    $maintenanceTabs = [
        ['id' => 'task-list-sub-equipment', 'label' => 'Task List on sub equipment'],
        ['id' => 'task-list-history', 'label' => 'Task List History of equipment'],
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
        ['id' => 'installed-base', 'label' => 'Installed Base'],
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
        ['name' => 'manufacturing_date', 'label' => 'Manufacturing date', 'value' => $selectedRecord['manufacturing_date'], 'variant' => null],
        ['name' => 'first_date_of_using', 'label' => 'First date of using', 'value' => $selectedRecord['first_date_of_using'], 'variant' => null],
        ['name' => 'delivery_date', 'label' => 'Delivery Date', 'value' => $selectedRecord['delivery_date'], 'variant' => null],
    ];

    $propertiesOperationalFields = [
        ['name' => 'maint_center_code', 'label' => 'Maint. Center Code', 'value' => $selectedRecord['maint_center_code'], 'variant' => 'lookup'],
        ['name' => 'maint_center_name', 'label' => 'Maint. Center Name', 'value' => $selectedRecord['maint_center_name'], 'variant' => 'lookup'],
        ['name' => 'utilization_model', 'label' => 'Utilization Model', 'value' => $selectedRecord['utilization_model'], 'variant' => 'arrow-lookup'],
    ];

    $workOrderRows = [
        [
            'code' => 'SHOP0684',
            'intervention_type' => 'Maintenance',
            'status' => 'Planned',
            'start_date' => '',
            'close_date' => '',
            'work_center' => '',
            'title' => 'DISPI',
        ],
    ];

    $maintenancePlanAppliedToFields = [
        ['name' => 'maintenance_fl_code', 'label' => 'Functional Location', 'value' => $selectedRecord['functional_location_code'], 'variant' => 'arrow-lookup'],
        ['name' => 'maintenance_fl_serial_number', 'label' => 'Serial Number', 'value' => $selectedRecord['functional_location_serial_number'], 'variant' => null],
        ['name' => 'maintenance_fl_type', 'label' => 'FL Type', 'value' => $selectedRecord['functional_location_type'], 'variant' => 'arrow-lookup'],
        ['name' => 'maintenance_fl_registration', 'label' => 'Registration', 'value' => $selectedRecord['functional_location_registration'], 'variant' => null],
    ];

    $maintenancePlanFilterOptions = [
        'AW139 AMP ISS 7 REV 4 / GOCOM' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
        'AW139 AMP ISS 6 REV 8 / GOCOM' => 'AW139 AMP ISS 6 REV 8 / GOCOM',
        'EC225 AMP ISS 4 REV 2 / GOCOM' => 'EC225 AMP ISS 4 REV 2 / GOCOM',
    ];

    $linkedTaskListRows = [
        ['reference' => 'AW139 PWC MM ENG', 'short_description' => 'Engine (Including sub components not specified)', 'mod_ref' => '', 'status' => 'Applicable', 'on_condition' => false, 'condition_monitoring' => false, 'initialized' => true, 'comment' => 'ENGINE RIGHT 5000:00 hrs OVH'],
        ['reference' => 'AW139 SB CAT8 41100 R9', 'short_description' => 'TURBOSHAFT ENGINE NO. 5 BEARING OUTPUT SHAFT SEAL - REPLA…', 'mod_ref' => 'CAT8 41100 R9', 'status' => 'Applied', 'on_condition' => false, 'condition_monitoring' => false, 'initialized' => false, 'comment' => ''],
        ['reference' => 'AW139 TCCA AD CF-2012-24', 'short_description' => 'SECOND STAGE POWER TURBINE DISK DAMAGE', 'mod_ref' => 'CF-2012-24', 'status' => 'Non applicable', 'on_condition' => false, 'condition_monitoring' => false, 'initialized' => false, 'comment' => 'ENGINE POST SB41056'],
        ['reference' => 'EOAS AW139/EOAS/277 - 9M-WAX', 'short_description' => 'AW139 WESTSTAR FLEET - ENGINE OIL ANALYSIS', 'mod_ref' => 'AW139/EOAS/277 - 9M-WAX', 'status' => 'Non applicable', 'on_condition' => false, 'condition_monitoring' => false, 'initialized' => false, 'comment' => 'TASK DEACTIVATED DUE TO NO OIL SAMPLING KIT AVAILABLE.'],
        ['reference' => 'EOAS AW139/EOAS/333 Rev A', 'short_description' => 'PWC PT6-67C SB 41113 REV 1 TURBOSHAFT ENGINE COUPLING NUT…', 'mod_ref' => 'AW139/EOAS/333 Rev A', 'status' => 'Applied', 'on_condition' => false, 'condition_monitoring' => false, 'initialized' => false, 'comment' => 'Complied with on 17/7/2020. Refer WO-23131.'],
    ];

    $maintenanceStandardCounterRows = [
        ['tone' => 'green', 'description' => 'TSN', 'reading_date' => '03.04.26', 'obj_value' => '13356:43', 'next_appli' => '14825:40', 'interval' => '5000:00', 'remaining' => '1468:57', 'last_appli' => '9825:40', 'sub_eq_reading_date' => '03.04.26', 'sub_eq_value' => '13467:03', 'sub_eq_next_appli' => '14936:00', 'sub_eq_remaining' => '1468:57', 'sub_eq_last_appli' => '', 'interval_ori' => '5000:00', 'tolerance' => '0:00', 'alarm' => '300:00'],
    ];

    $maintenanceCalendarCounterRows = [];

    $taskListsAppliedRows = [
        ['reference' => 'EOAS EO-20-095-N139M', 'short_description' => 'PWC PT6-67C SB 41113 REV 1 TURBOSHAFT', 'mod_ref' => 'EOAS EO-20-095-N139M'],
        ['reference' => 'AW139 SB CAT8 41100 R9', 'short_description' => 'TURBOSHAFT ENGINE NO. 5 BEARING OUTPUT SHAFT SEAL - REPLACEME', 'mod_ref' => 'AW139 SB CAT8 41100 R9'],
        ['reference' => 'EOAS EO-20-003-N139I ISS C', 'short_description' => 'PREVENTIVE MAINTENANCE: COMPRESSOR BLEED OFF VALVE (BOV) CLO', 'mod_ref' => 'EOAS EO-20-003-N139I ISS C'],
    ];

    $taskListApplicationHistoryRows = [
        ['application_date' => '17.07.20', 'work_order' => 'WO-23131', 'repair_id' => '57675', 'comment' => '', 'maintenance_plan' => 'AW139 AMP ISS 7 REV 5 / GOCOM AMP ISS 1 REV 3', 'object_code' => '9M-WAA', 'object_information' => 'AW139/31324'],
    ];

    $schedulingInformationRows = [
        ['description' => 'TSN', 'value_dec' => '', 'value_hhmm' => ''],
        ['description' => 'CSN', 'value_dec' => '', 'value_hhmm' => ''],
        ['description' => 'START', 'value_dec' => '', 'value_hhmm' => ''],
        ['description' => 'E#1CC', 'value_dec' => '', 'value_hhmm' => ''],
    ];

    $metadata = [
        ['label' => 'Updated By', 'value' => 'Wan Mohammad R'],
        ['label' => 'Update Date', 'value' => '29.04.19'],
    ];

    if ($emptyState) {
        $summaryLeftFields = $clearFieldValues($summaryLeftFields);
        $summaryRightFields = $clearFieldValues($summaryRightFields);
        $generalMetaFields = $clearFieldValues($generalMetaFields);
        $nextHigherAssemblyFields = $clearFieldValues($nextHigherAssemblyFields);
        $topAssemblyFields = $clearFieldValues($topAssemblyFields);
        $functionalLocationFields = $clearFieldValues($functionalLocationFields);
        $propertiesTopLeftFields = $clearFieldValues($propertiesTopLeftFields);
        $propertiesOperationalFields = $clearFieldValues($propertiesOperationalFields);
        $maintenancePlanAppliedToFields = $clearFieldValues($maintenancePlanAppliedToFields);
        $billOfMaterialRows = collect();
        $installedBaseRows = [];
        $workOrderRows = [];
        $linkedTaskListRows = [];
        $maintenanceStandardCounterRows = [];
        $maintenanceCalendarCounterRows = [];
        $taskListsAppliedRows = [];
        $taskListApplicationHistoryRows = [];
        $schedulingInformationRows = [];
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
                <a href="{{ route('fleet.technical-logs.create', ['equipment_id' => $selectedRecord['id']]) }}" class="btn-secondary">Technical Log</a>
            @else
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
            @if ($equipmentModel)
                @livewire('fleet.equipment-general-meta-form', ['equipmentId' => $equipmentModel->id], key('equipment-general-meta-form-'.$equipmentModel->id))
            @else
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                        @foreach (array_slice($generalMetaFields, 0, 5) as $field)
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                <x-enterprise.input
                                    variant="{{ $field['variant'] }}"
                                    tone="{{ $field['tone'] ?? null }}"
                                    :name="$field['name']"
                                    :value="$field['value']"
                                    readonly
                                    class="input-field-filled"
                                />
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-700">{{ $generalMetaFields[5]['label'] }}</label>
                        <x-enterprise.input
                            variant="{{ $generalMetaFields[5]['variant'] }}"
                            :name="$generalMetaFields[5]['name']"
                            :value="$generalMetaFields[5]['value']"
                            readonly
                            class="input-field-filled"
                        />
                    </div>
                </div>
            @endif

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
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            data-edit-locked="true"
                                            class="input-field-filled"
                                        />
                                    </div>
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (array_slice($nextHigherAssemblyFields, 3, 2) as $field)
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            data-edit-locked="true"
                                            class="input-field-filled"
                                        />
                                    </div>
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
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            data-edit-locked="true"
                                            class="input-field-filled"
                                        />
                                    </div>
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (array_slice($topAssemblyFields, 3, 2) as $field)
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            data-edit-locked="true"
                                            class="input-field-filled"
                                        />
                                    </div>
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
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            data-edit-locked="true"
                                            class="input-field-filled"
                                        />
                                    </div>
                                @endforeach
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach (array_slice($functionalLocationFields, 3, 2) as $field)
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            data-edit-locked="true"
                                            class="input-field-filled"
                                        />
                                    </div>
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
        <x-card title="Properties" description="Commercial and configuration metadata for the selected equipment." padding="p-6">
                <div class="space-y-5">
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ($propertiesTopLeftFields as $field)
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                <x-enterprise.input
                                    variant="{{ $field['variant'] }}"
                                    tone="{{ $field['tone'] ?? null }}"
                                    :name="$field['name']"
                                    :value="$field['value']"
                                    readonly
                                    class="input-field-filled"
                                />
                            </div>
                        @endforeach
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ($propertiesOperationalFields as $field)
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                <x-enterprise.input
                                    variant="{{ $field['variant'] }}"
                                    tone="{{ $field['tone'] ?? null }}"
                                    :name="$field['name']"
                                    :value="$field['value']"
                                    readonly
                                    class="input-field-filled"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'maintenance'" class="space-y-6">
        <x-card title="Maintenance" description="Task lists scoped to this equipment installation, plus the historical record of applied tasks." padding="p-6">
                <div class="space-y-5" x-data="tabs('task-list-sub-equipment')">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 pt-3">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                @foreach ($maintenanceTabs as $tab)
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

                    <div x-cloak x-show="activeTab === 'task-list-sub-equipment'" class="space-y-6">
                        <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                            <div class="flex items-center gap-3">
                                <h4 class="text-sm font-semibold text-gray-900">Maintenance Plan Applied To</h4>
                                <div class="h-px flex-1 bg-gray-200"></div>
                            </div>
                            <div class="mt-4 grid gap-4 md:grid-cols-2">
                                @foreach ($maintenancePlanAppliedToFields as $field)
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                                        <x-enterprise.input
                                            variant="{{ $field['variant'] }}"
                                            :name="$field['name']"
                                            :value="$field['value']"
                                            readonly
                                            class="input-field-filled"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid gap-3 md:grid-cols-[220px_minmax(0,1fr)] md:items-center">
                            <label for="maintenance_plan_filter" class="text-sm font-medium text-gray-600">Filter on Maintenance Plan</label>
                            <x-form.select
                                id="maintenance_plan_filter"
                                name="maintenance_plan_filter"
                                :options="$maintenancePlanFilterOptions"
                                readonly
                                class="input-field-filled max-w-md"
                            />
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-gray-900">Linked Task Lists</h4>
                            <x-data-table>
                                <x-slot name="thead">
                                    <tr>
                                        <th class="table-th">Reference</th>
                                        <th class="table-th">Short Description</th>
                                        <th class="table-th">Mod. Ref.</th>
                                        <th class="table-th">Status</th>
                                        <th class="table-th">On Condition</th>
                                        <th class="table-th">Condition Monitoring</th>
                                        <th class="table-th">Initialized</th>
                                        <th class="table-th">Comment</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($linkedTaskListRows as $row)
                                        <tr class="table-row">
                                            <td class="table-td">
                                                <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                        <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                    </span>
                                                    <span>{{ $row['reference'] }}</span>
                                                </span>
                                            </td>
                                            <td class="table-td">{{ $row['short_description'] }}</td>
                                            <td class="table-td">
                                                @if ($row['mod_ref'] !== '')
                                                    <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                        </span>
                                                        <span>{{ $row['mod_ref'] }}</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="table-td">{{ $row['status'] }}</td>
                                            <td class="table-td"><x-enterprise.checkbox inline disabled @checked($row['on_condition']) /></td>
                                            <td class="table-td"><x-enterprise.checkbox inline disabled @checked($row['condition_monitoring']) /></td>
                                            <td class="table-td"><x-enterprise.checkbox inline disabled @checked($row['initialized']) /></td>
                                            <td class="table-td">{{ $row['comment'] }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach (range(count($linkedTaskListRows) + 1, 8) as $rowNumber)
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

                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-gray-900">Standard Counters</h4>
                            <x-data-table>
                                <x-slot name="thead">
                                    <tr>
                                        <th class="table-th">!</th>
                                        <th class="table-th">Description</th>
                                        <th class="table-th">Reading Date</th>
                                        <th class="table-th">Obj. Value</th>
                                        <th class="table-th">Next Appli.</th>
                                        <th class="table-th">Interval</th>
                                        <th class="table-th">Remaining</th>
                                        <th class="table-th">Last Appli.</th>
                                        <th class="table-th">Sub Eq. Reading Date</th>
                                        <th class="table-th">Sub Eq. Value</th>
                                        <th class="table-th">Sub Eq. Next Appli.</th>
                                        <th class="table-th">Sub Eq. Remaining</th>
                                        <th class="table-th">Sub Eq. Last Appli.</th>
                                        <th class="table-th">Interval Ori.</th>
                                        <th class="table-th">Tolerance</th>
                                        <th class="table-th">Alarm</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($maintenanceStandardCounterRows as $row)
                                        <tr class="table-row">
                                            <td class="table-td"><span class="inline-block h-2.5 w-2.5 rounded-full {{ $row['tone'] === 'green' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span></td>
                                            <td class="table-td font-medium text-gray-900">{{ $row['description'] }}</td>
                                            <td class="table-td">{{ $row['reading_date'] }}</td>
                                            <td class="table-td">{{ $row['obj_value'] }}</td>
                                            <td class="table-td">{{ $row['next_appli'] }}</td>
                                            <td class="table-td">{{ $row['interval'] }}</td>
                                            <td class="table-td">{{ $row['remaining'] }}</td>
                                            <td class="table-td">{{ $row['last_appli'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_reading_date'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_value'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_next_appli'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_remaining'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_last_appli'] }}</td>
                                            <td class="table-td">{{ $row['interval_ori'] }}</td>
                                            <td class="table-td">{{ $row['tolerance'] }}</td>
                                            <td class="table-td">{{ $row['alarm'] }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach (range(count($maintenanceStandardCounterRows) + 1, 4) as $rowNumber)
                                        <tr class="table-row">
                                            @foreach (range(1, 16) as $colNumber)
                                                <td class="table-td"><span class="invisible">.</span></td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-data-table>
                        </div>

                        <div class="space-y-2">
                            <div class="flex flex-wrap items-end justify-between gap-3">
                                <h4 class="text-sm font-semibold text-gray-900">Calendar Counters</h4>
                                <div class="flex items-center gap-3">
                                    <label for="maintenance_calendar_unit" class="text-sm font-medium text-gray-600">Unit of Measure</label>
                                    <x-enterprise.input
                                        id="maintenance_calendar_unit"
                                        name="maintenance_calendar_unit"
                                        value="Days"
                                        readonly
                                        class="input-field-filled w-32"
                                    />
                                </div>
                            </div>
                            <x-data-table>
                                <x-slot name="thead">
                                    <tr>
                                        <th class="table-th">Description</th>
                                        <th class="table-th">Obj Next Appli.</th>
                                        <th class="table-th">Interval</th>
                                        <th class="table-th">Remaining</th>
                                        <th class="table-th">Last Appli.</th>
                                        <th class="table-th">Sub Eq. Next Appli.</th>
                                        <th class="table-th">Sub Eq. Remaining</th>
                                        <th class="table-th">Sub Eq. Last Appli.</th>
                                        <th class="table-th">Interval Ori.</th>
                                        <th class="table-th">Tolerance</th>
                                        <th class="table-th">Alarm</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($maintenanceCalendarCounterRows as $row)
                                        <tr class="table-row">
                                            <td class="table-td font-medium text-gray-900">{{ $row['description'] }}</td>
                                            <td class="table-td">{{ $row['obj_next_appli'] }}</td>
                                            <td class="table-td">{{ $row['interval'] }}</td>
                                            <td class="table-td">{{ $row['remaining'] }}</td>
                                            <td class="table-td">{{ $row['last_appli'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_next_appli'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_remaining'] }}</td>
                                            <td class="table-td">{{ $row['sub_eq_last_appli'] }}</td>
                                            <td class="table-td">{{ $row['interval_ori'] }}</td>
                                            <td class="table-td">{{ $row['tolerance'] }}</td>
                                            <td class="table-td">{{ $row['alarm'] }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach (range(count($maintenanceCalendarCounterRows) + 1, 4) as $rowNumber)
                                        <tr class="table-row">
                                            @foreach (range(1, 11) as $colNumber)
                                                <td class="table-td"><span class="invisible">.</span></td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-data-table>
                        </div>
                    </div>

                    <div x-cloak x-show="activeTab === 'task-list-history'" class="space-y-6">
                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-gray-900">Task Lists Applied</h4>
                            <x-data-table>
                                <x-slot name="thead">
                                    <tr>
                                        <th class="table-th">Reference</th>
                                        <th class="table-th">Short Description</th>
                                        <th class="table-th">Mod. Ref.</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($taskListsAppliedRows as $row)
                                        <tr class="table-row">
                                            <td class="table-td">
                                                <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                        <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                    </span>
                                                    <span>{{ $row['reference'] }}</span>
                                                </span>
                                            </td>
                                            <td class="table-td">{{ $row['short_description'] }}</td>
                                            <td class="table-td">
                                                <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                        <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                    </span>
                                                    <span>{{ $row['mod_ref'] }}</span>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach (range(count($taskListsAppliedRows) + 1, 6) as $rowNumber)
                                        <tr class="table-row">
                                            <td class="table-td"><span class="invisible">.</span></td>
                                            <td class="table-td"><span class="invisible">.</span></td>
                                            <td class="table-td"><span class="invisible">.</span></td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-data-table>
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-gray-900">Task List Application History</h4>
                            <x-data-table>
                                <x-slot name="thead">
                                    <tr>
                                        <th class="table-th">Application Date</th>
                                        <th class="table-th">Work Order</th>
                                        <th class="table-th">Repair ID</th>
                                        <th class="table-th">Comment</th>
                                        <th class="table-th">Maintenance Plan</th>
                                        <th class="table-th">Object Code</th>
                                        <th class="table-th">Object Information</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($taskListApplicationHistoryRows as $row)
                                        <tr class="table-row">
                                            <td class="table-td">{{ $row['application_date'] }}</td>
                                            <td class="table-td">
                                                <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                        <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                    </span>
                                                    <span>{{ $row['work_order'] }}</span>
                                                </span>
                                            </td>
                                            <td class="table-td">{{ $row['repair_id'] }}</td>
                                            <td class="table-td">{{ $row['comment'] }}</td>
                                            <td class="table-td">{{ $row['maintenance_plan'] }}</td>
                                            <td class="table-td">{{ $row['object_code'] }}</td>
                                            <td class="table-td">{{ $row['object_information'] }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach (range(count($taskListApplicationHistoryRows) + 1, 4) as $rowNumber)
                                        <tr class="table-row">
                                            @foreach (range(1, 7) as $colNumber)
                                                <td class="table-td"><span class="invisible">.</span></td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-data-table>
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-gray-900">Scheduling Information recorded during the application</h4>
                            <x-data-table>
                                <x-slot name="thead">
                                    <tr>
                                        <th class="table-th">Description</th>
                                        <th class="table-th">Value (dec.)</th>
                                        <th class="table-th">Value (hh:mm)</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($schedulingInformationRows as $row)
                                        <tr class="table-row">
                                            <td class="table-td font-medium text-gray-900">{{ $row['description'] }}</td>
                                            <td class="table-td">{{ $row['value_dec'] }}</td>
                                            <td class="table-td">{{ $row['value_hhmm'] }}</td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-data-table>
                        </div>
                    </div>
                </div>
        </x-card>
    </div>

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
