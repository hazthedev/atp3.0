@php
    $emptyState = (bool) ($emptyState ?? false);
    $readonly   = (bool) ($readonly ?? true);
    $recordSelected = ! $emptyState;
    $selectedRecord = array_merge([
        'id' => $recordId ?? 1,
        'code' => '9M-WAA',
        'status' => 'Airworthy',
        'serial_no' => '31324',
        'maintenance_plan' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
        'registration' => 'M104-04',
        'owner_code' => '300028',
        'type' => 'AW139',
        'owner_name' => '*WESTSTAR',
        'mel' => 'Not assigned',
        'operator_code' => '300028',
        'aircraft_class' => 'Medium Twin',
        'operator_name' => '*WESTSTAR',
        'mission_type' => 'Offshore Transport',
        'maint_center_code' => 'WMSZ-01',
        'maint_center_name' => 'Weststar Subang',
        'environment_type' => 'Marine / Coastal',
        'utilization_model' => '9M-WAA',
        'oi_type' => 'Passenger Transport',
        'ac_max_to_weight' => '6,800 kg',
        'ac_empty_weight' => '4,358 kg',
        'address_name' => 'Weststar Aviation Services',
        'street' => 'Jalan Lapangan Terbang',
        'block' => 'Hangar 2',
        'city' => 'Subang',
        'zip_code' => '47200',
        'county' => 'Petaling',
        'state' => 'selangor',
        'country' => 'Malaysia',
        'date_of_purchase' => '18 Sep 2013',
        'purchase_price' => '34,850,000',
        'cum_flight_time' => '5461:58',
        'equipment_reference' => 'EQ-7701',
        'work_package_comment' => '20251101-9M-WAA-AW139',
    ], $record ?? []);
    $clearFieldValues = static function (array $fields): array {
        return array_map(static function (array $field): array {
            $field['value'] = ($field['type'] ?? 'input') === 'select' ? null : '';

            return $field;
        }, $fields);
    };

    $summaryFields = [
        ['name' => 'code',             'label' => 'Code',             'value' => $selectedRecord['code'],             'variant' => 'indicator', 'tone' => 'green'],
        ['name' => 'status',           'label' => 'Status',           'value' => $selectedRecord['status'],           'type' => 'select', 'options' => ['-0000007' => '-0000007 - Airworthy', '-0000008' => '-0000008 - In Repair', 'OTS' => 'OTS - Out of Service']],
        ['name' => 'serial_no',        'label' => 'Serial No.',       'value' => $selectedRecord['serial_no'],        'variant' => 'tree'],
        ['name' => 'maintenance_plan', 'label' => 'Maintenance Plan', 'value' => $selectedRecord['maintenance_plan'], 'variant' => 'arrow-indicator', 'tone' => 'green'],
        ['name' => 'registration',     'label' => 'Registration',     'value' => $selectedRecord['registration']],
        ['name' => 'owner_code',       'label' => 'Owner Code',       'value' => $selectedRecord['owner_code'],       'variant' => 'arrow-lookup'],
        ['name' => 'type',             'label' => 'Type',             'value' => $selectedRecord['type'],             'variant' => 'arrow-lookup'],
        ['name' => 'owner_name',       'label' => 'Owner Name',       'value' => $selectedRecord['owner_name']],
        ['name' => 'mel',              'label' => 'MEL',              'value' => $selectedRecord['mel'],              'variant' => 'indicator', 'tone' => 'green'],
        ['name' => 'operator_code',    'label' => 'Operator Code',    'value' => $selectedRecord['operator_code'],    'variant' => 'arrow-lookup'],
        ['name' => 'operator_name',    'label' => 'Operator Name',    'value' => $selectedRecord['operator_name']],
    ];

    $tabs = [
        ['id' => 'general', 'label' => 'General', 'icon' => 'information-circle'],
        ['id' => 'counters', 'label' => 'Counters', 'icon' => 'chart-bar'],
        ['id' => 'equipment', 'label' => 'Equipment', 'icon' => 'cube'],
        ['id' => 'modifications', 'label' => 'Modifications', 'icon' => 'adjustments-horizontal'],
        ['id' => 'properties', 'label' => 'Properties', 'icon' => 'sliders'],
        ['id' => 'events', 'label' => 'Events', 'icon' => 'bell'],
        ['id' => 'attachments', 'label' => 'Attachments', 'icon' => 'paperclip'],
    ];

    $generalFields = [
        ['name' => 'monthly_average_hours', 'label' => 'Monthly Average Hours', 'value' => '42.5'],
        ['name' => 'first_date_of_using',   'label' => 'First Date of Using',   'value' => '14 Mar 2017'],
        ['name' => 'mission_type',          'label' => 'Mission Type',          'value' => $selectedRecord['mission_type'],       'variant' => 'lookup'],
        ['name' => 'maint_center_code',     'label' => 'Maint. Center Code',    'value' => $selectedRecord['maint_center_code'],  'variant' => 'lookup'],
        ['name' => 'maint_center_name',     'label' => 'Maint. Center Name',    'value' => $selectedRecord['maint_center_name']],
        ['name' => 'environment_type',      'label' => 'Environment Type',      'value' => $selectedRecord['environment_type'],   'variant' => 'lookup'],
        ['name' => 'utilization_model',     'label' => 'Utilization Model',     'value' => $selectedRecord['utilization_model'],  'variant' => 'arrow-lookup'],
        ['name' => 'oi_type',               'label' => 'Oil Type',               'value' => $selectedRecord['oi_type'],            'variant' => 'lookup'],
        ['name' => 'ac_max_to_weight',      'label' => 'A/C Max TO Weight',     'value' => $selectedRecord['ac_max_to_weight']],
        ['name' => 'ac_empty_weight',       'label' => 'A/C Empty Weight',      'value' => $selectedRecord['ac_empty_weight']],
    ];

    $addressFields = [
        ['name' => 'address_name', 'label' => 'Name',     'value' => $selectedRecord['address_name'], 'disabled_when' => 'always'],
        ['name' => 'street',       'label' => 'Street',   'value' => $selectedRecord['street'],       'disabled_when' => 'owner'],
        ['name' => 'block',        'label' => 'Block',    'value' => $selectedRecord['block'],        'disabled_when' => 'owner'],
        ['name' => 'city',         'label' => 'City',     'value' => $selectedRecord['city'],         'disabled_when' => 'owner'],
        ['name' => 'zip_code',     'label' => 'Zip Code', 'value' => $selectedRecord['zip_code'],     'disabled_when' => 'owner'],
        ['name' => 'county',       'label' => 'County',   'value' => $selectedRecord['county'],       'disabled_when' => 'owner'],
        ['name' => 'state',        'label' => 'State',    'value' => $selectedRecord['state'],        'disabled_when' => 'owner', 'type' => 'select', 'options' => ['selangor' => 'Selangor', 'sarawak' => 'Sarawak', 'sabah' => 'Sabah']],
        ['name' => 'country',      'label' => 'Country',  'value' => $selectedRecord['country'],      'disabled_when' => 'owner', 'variant' => 'lookup'],
    ];

    $dbFlCounters = $dbFlCounters ?? collect();
    $dbFlCalendarCounter = $dbFlCalendarCounter ?? null;
    $flModel = $flModel ?? null;

    if ($dbFlCounters->isNotEmpty()) {
        $counterRows = $dbFlCounters->map(function ($c): array {
            $value = $c->value_hhmm ?: ($c->value_dec !== null ? (string) (float) $c->value_dec : '');
            $max = $c->max_hhmm ?: ($c->max_dec !== null ? (string) (float) $c->max_dec : '');
            return [
                'counter_desc' => $c->counterRef?->name ?? '',
                'value' => $value,
                'tone' => $c->tone ?: ($c->is_used ? 'green' : 'grey'),
                'unit' => $c->counterRef?->measure_unit ?? '',
                'reading_date' => optional($c->reading_date)->format('d.m.y') ?? '',
                'max' => $max,
                'remaining' => $c->remaining ?? '',
                'residual' => $c->residual ?? '',
                'equipment_id' => $c->linked_equi_id ?? '',
                'info_source' => $c->info_source ?? '',
            ];
        })->all();
    } else {
        $counterRows = [
            ['counter_desc' => 'TSN', 'value' => '13193:44', 'tone' => 'amber', 'unit' => 'Min', 'reading_date' => '15.12.25', 'max' => '', 'remaining' => '', 'residual' => '142:01', 'equipment_id' => '47899', 'info_source' => 'Planning sheet'],
            ['counter_desc' => 'CSN', 'value' => '20608', 'tone' => 'amber', 'unit' => 'Cycle', 'reading_date' => '15.12.25', 'max' => '', 'remaining' => '', 'residual' => '11392', 'equipment_id' => '290', 'info_source' => 'Planning sheet'],
            ['counter_desc' => 'START', 'value' => '3722', 'tone' => 'green', 'unit' => 'Nb of starting up', 'reading_date' => '15.12.25', 'max' => '', 'remaining' => '', 'residual' => '', 'equipment_id' => '', 'info_source' => 'Planning sheet'],
            ['counter_desc' => 'E#1CC', 'value' => '1275.25', 'tone' => 'amber', 'unit' => 'Cycle', 'reading_date' => '15.12.25', 'max' => '', 'remaining' => '', 'residual' => '7248.75', 'equipment_id' => '6108', 'info_source' => 'Engine import'],
            ['counter_desc' => 'E#1CTC', 'value' => '8607.21', 'tone' => 'green', 'unit' => 'Cycle', 'reading_date' => '15.12.25', 'max' => '', 'remaining' => '', 'residual' => '3392.79', 'equipment_id' => '6112', 'info_source' => 'Engine import'],
            ['counter_desc' => 'E#1PTC', 'value' => '10083.17', 'tone' => 'amber', 'unit' => 'Cycle', 'reading_date' => '15.12.25', 'max' => '', 'remaining' => '', 'residual' => '1916.83', 'equipment_id' => '6116', 'info_source' => 'Engine import'],
        ];
    }

    $equipmentRows = [
        ['position' => 'Airframe', 'id' => (string) $selectedRecord['id'], 'serial_no' => $selectedRecord['serial_no'], 'item' => $selectedRecord['type'], 'item_desc' => $selectedRecord['type'], 'variant' => $selectedRecord['type'], 'category_part' => 'Airframe'],
    ];

    $modificationRows = [
        ['type' => 'AW139 EA', 'reference' => '2021-0044 G1 P2', 'revision' => '', 'embodied' => 'X', 'applied_on' => '13.04.22', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2021-0044 GROUP', 'revision' => '', 'embodied' => 'X', 'applied_on' => '20.02.21', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2021-0044 R1G1P2 1', 'revision' => '', 'embodied' => 'X', 'applied_on' => '08.10.25', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2022-0209-E P2', 'revision' => '', 'embodied' => 'X', 'applied_on' => '20.10.22', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2023-0071-E PTI', 'revision' => '', 'embodied' => 'X', 'applied_on' => '04.04.23', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2024-0071-E PTIII', 'revision' => '', 'embodied' => 'X', 'applied_on' => '12.04.23', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2024-0211-E (INIT)', 'revision' => '', 'embodied' => 'X', 'applied_on' => '14.04.25', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2025-0094 (INITIA)', 'revision' => '', 'embodied' => 'X', 'applied_on' => '09.08.25', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
        ['type' => 'AW139 EA', 'reference' => '2025-0094 (REPE)', 'revision' => '', 'embodied' => 'X', 'applied_on' => '08.10.25', 'deleted' => '', 'removed_on' => '', 'status' => '', 'comment' => 'Workpackage'],
    ];

    if ($dbFlCalendarCounter) {
        $counterSummaryRows = [[
            'counter_desc' => $dbFlCalendarCounter->label,
            'value' => optional($dbFlCalendarCounter->value_date)->format('d.m.y') ?? '',
            'alert' => $dbFlCalendarCounter->is_used ? 'green' : 'x',
            'unit' => 'Days',
            'limit' => $dbFlCalendarCounter->limit ?? '',
            'remaining' => $dbFlCalendarCounter->remaining ?? '0.0000',
            'residual' => $dbFlCalendarCounter->residual ?? '',
            'equipment_id' => '',
            'info_source' => $dbFlCalendarCounter->info_source ?? '',
        ]];
    } else {
        $counterSummaryRows = [
            ['counter_desc' => '', 'value' => '', 'alert' => '', 'unit' => '', 'limit' => '', 'remaining' => '0.0000', 'residual' => '', 'equipment_id' => '', 'info_source' => ''],
        ];
    }

    $propertyMetaFields = [
        ['name' => 'date_of_purchase', 'label' => 'Date of Purchase', 'value' => $selectedRecord['date_of_purchase']],
        ['name' => 'purchase_price', 'label' => 'Purchase Price (in MYR)', 'value' => $selectedRecord['purchase_price']],
        ['name' => 'cum_flight_time', 'label' => 'Cum. Flight Time > MTOW 6400kg (30/04/2019)', 'value' => $selectedRecord['cum_flight_time']],
    ];

    $attachmentRows = [
        ['index' => '1', 'path' => '\\\\10.3.5.213\\SAP Attachment', 'file_name' => 'note', 'attachment_date' => '20.10.17'],
        ['index' => '2', 'path' => '\\\\10.3.5.213\\SAP Attachment', 'file_name' => 'test by mdnur pls delete', 'attachment_date' => '08.12.21'],
    ];

    $eventTabs = [
        ['id' => 'workpackages', 'label' => 'Workpackages', 'icon' => 'briefcase'],
        ['id' => 'repairs', 'label' => 'Repairs', 'icon' => 'wrench-screwdriver'],
        ['id' => 'installed-base', 'label' => 'Installed Base', 'icon' => 'cube'],
        ['id' => 'technical-log', 'label' => 'Technical Log', 'icon' => 'document-text'],
        ['id' => 'others', 'label' => 'Others', 'icon' => 'ellipsis-horizontal-circle'],
        ['id' => 'work-orders', 'label' => 'Work Orders', 'icon' => 'clipboard-document-list'],
    ];

    $eventWorkpackageRows = [
        ['code' => '000018DL', 'status' => 'Closed', 'simulation_date' => '27.11.25', 'planned_date' => '', 'release_date' => '15.12.25', 'close_date' => '15.12.25', 'comment' => $selectedRecord['work_package_comment']],
        ['code' => '0000182C', 'status' => 'Closed', 'simulation_date' => '13.11.25', 'planned_date' => '', 'release_date' => '15.12.25', 'close_date' => '15.12.25', 'comment' => $selectedRecord['work_package_comment']],
        ['code' => '000017M1', 'status' => 'Closed', 'simulation_date' => '24.10.25', 'planned_date' => '', 'release_date' => '11.12.25', 'close_date' => '11.12.25', 'comment' => $selectedRecord['work_package_comment']],
        ['code' => '000018HH', 'status' => 'Closed', 'simulation_date' => '01.12.25', 'planned_date' => '', 'release_date' => '08.12.25', 'close_date' => '08.12.25', 'comment' => $selectedRecord['work_package_comment']],
        ['code' => '000018HG', 'status' => 'Closed', 'simulation_date' => '01.12.25', 'planned_date' => '', 'release_date' => '08.12.25', 'close_date' => '08.12.25', 'comment' => $selectedRecord['work_package_comment']],
        ['code' => '000018DG', 'status' => 'Closed', 'simulation_date' => '27.11.25', 'planned_date' => '', 'release_date' => '08.12.25', 'close_date' => '08.12.25', 'comment' => $selectedRecord['work_package_comment']],
        ['code' => '000017VO', 'status' => 'Closed', 'simulation_date' => '05.11.25', 'planned_date' => '', 'release_date' => '08.12.25', 'close_date' => '08.12.25', 'comment' => $selectedRecord['work_package_comment']],
    ];

    $eventRepairRows = [
        ['code' => '131008', 'subject' => 'WASSB/31324/1844 - ACCP 1 MONTH', 'status' => 'Closed', 'date_in' => '13.12.25', 'intervention_type' => 'Maintenance', 'date_out' => '13.12.25', 'return_reason' => 'Completed'],
        ['code' => '131605', 'subject' => 'WASSB/31324/1851 - SYSTEM INTERFACE', 'status' => 'Open', 'date_in' => '12.12.25', 'intervention_type' => 'Maintenance', 'date_out' => '', 'return_reason' => 'Awaiting parts'],
        ['code' => '131603', 'subject' => 'WASSB/31324/1850 - 50HRS + AD2020-0271', 'status' => 'Open', 'date_in' => '12.12.25', 'intervention_type' => 'Maintenance', 'date_out' => '', 'return_reason' => 'Inspection pending'],
        ['code' => '131602', 'subject' => 'WASSB/31324/1849 - 25HRS INSPECTION', 'status' => 'Open', 'date_in' => '12.12.25', 'intervention_type' => 'Maintenance', 'date_out' => '', 'return_reason' => 'Review'],
        ['code' => '131600', 'subject' => 'WASSB/31324/1848 - ACCP 2 WEEK', 'status' => 'Open', 'date_in' => '12.12.25', 'intervention_type' => 'Maintenance', 'date_out' => '', 'return_reason' => 'Review'],
        ['code' => '130325', 'subject' => 'WASSB/31324/1841 - PORTABLE FIRE EXTI', 'status' => 'Closed', 'date_in' => '12.12.25', 'intervention_type' => 'Maintenance', 'date_out' => '12.12.25', 'return_reason' => 'Completed'],
    ];

    $eventInstalledBaseRows = [
        ['code' => '661', 'creation_date' => '07.06.17', 'date_event' => '10.11.10', 'time_event' => '', 'type' => 'Attach on FL', 'subject' => 'Equipment attached to functional location'],
    ];

    $eventTechnicalLogRows = [
        ['log_number' => '0000026', 'description' => 'DATE: 02.05.19 AF HRS: 5', 'status' => 'Closed', 'ata' => '', 'mel_item_reference' => '', 'mel_item_name' => '', 'fl_reference' => $selectedRecord['code'], 'task_number' => 'TL-000026'],
        ['log_number' => '000002L', 'description' => '05/05/19, 9232:34, AW002', 'status' => 'Closed', 'ata' => '', 'mel_item_reference' => '', 'mel_item_name' => '', 'fl_reference' => $selectedRecord['code'], 'task_number' => 'TL-00002L'],
        ['log_number' => '000002M', 'description' => '05.05.19, 9232:34, AW001', 'status' => 'Closed', 'ata' => '', 'mel_item_reference' => '', 'mel_item_name' => '', 'fl_reference' => $selectedRecord['code'], 'task_number' => 'TL-00002M'],
        ['log_number' => '000003Y', 'description' => 'DATE: 07/05/2019 A/F HRS', 'status' => 'Closed', 'ata' => '', 'mel_item_reference' => '', 'mel_item_name' => '', 'fl_reference' => $selectedRecord['code'], 'task_number' => 'TL-00003Y'],
    ];

    $eventOtherRows = [
        ['code' => '', 'creation_date' => '', 'date_event' => '', 'type' => '', 'subject' => ''],
    ];

    $eventWorkOrderRows = [
        ['code' => 'WOA09110', 'title' => 'Main rotor inspection', 'intervention_type' => 'Maintenance', 'status' => 'Planned', 'start_date' => '', 'close_date' => '', 'work_center' => 'Structures'],
        ['code' => 'WOA09109', 'title' => 'Cabin interior clean-up', 'intervention_type' => 'Maintenance', 'status' => 'Planned', 'start_date' => '', 'close_date' => '', 'work_center' => 'Repair'],
        ['code' => 'WOA09106', 'title' => 'Inspection preparation', 'intervention_type' => 'Maintenance', 'status' => 'Planned', 'start_date' => '', 'close_date' => '', 'work_center' => 'Avionics'],
        ['code' => 'WOA08455', 'title' => 'Deferred item review', 'intervention_type' => 'Maintenance', 'status' => 'Planned', 'start_date' => '', 'close_date' => '', 'work_center' => 'Component'],
    ];

    $metadata = [
        ['label' => 'Updated By', 'value' => 'Muhd Nur Yaakob'],
        ['label' => 'Update Date', 'value' => '03.02.26'],
    ];

    if ($emptyState) {
        $summaryFields = $clearFieldValues($summaryFields);
        $generalFields = $clearFieldValues($generalFields);
        $addressFields = $clearFieldValues($addressFields);
        $propertyMetaFields = $clearFieldValues($propertyMetaFields);

        $counterRows = [];
        $counterSummaryRows = [];
        $equipmentRows = [];
        $modificationRows = [];
        $attachmentRows = [];
        $eventWorkpackageRows = [];
        $eventRepairRows = [];
        $eventInstalledBaseRows = [];
        $eventTechnicalLogRows = [];
        $eventOtherRows = [];
        $eventWorkOrderRows = [];
        $metadata = [
            ['label' => 'Updated By', 'value' => 'Not available'],
            ['label' => 'Update Date', 'value' => 'Not available'],
        ];
    }
@endphp

<div class="space-y-6" x-data="tabs('general')">
    <x-page-header
        :title="$title"
        :description="$recordSelected
            ? 'Dense functional-location workspace using populated form controls and a stronger secondary tab pattern.'
            : 'Empty customer functional location workspace. Select a record from Search Functional Locations to load aircraft data.'"
    >
        <x-slot name="actions">
            @if ($recordSelected)
                @if ($readonly)
                    <a href="{{ route('fleet.technical-logs.index') }}" class="btn-secondary">
                        <x-icon name="document" class="h-4 w-4" />
                        Technical Log
                    </a>
                    <a href="{{ route('fleet.functional-location.edit', ['id' => $selectedRecord['id']]) }}" class="btn-primary">Edit Record</a>
                @else
                    <a href="{{ route('fleet.functional-location.show', ['id' => $selectedRecord['id']]) }}" class="btn-secondary">Cancel</a>
                    <button type="button" class="btn-primary">Save</button>
                @endif
            @else
                <a href="{{ route('fleet.functional-location.customer') }}" class="btn-primary">Customer Functional Location</a>
            @endif
        </x-slot>
    </x-page-header>

    @unless ($recordSelected)
        <x-empty-state
            icon="magnifying-glass"
            label="No functional location selected"
            description="Open Customer Functional Location and click an aircraft ID row to populate this workspace with customer, equipment, counter, and event data."
        >
            <a href="{{ route('fleet.functional-location.customer') }}" class="btn-primary">Go to Customer Functional Location</a>
        </x-empty-state>
    @endunless

    <x-card title="Customer Functional Location" description="Key aircraft identity, ownership, and maintenance reference fields." padding="p-6">
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($summaryFields as $field)
                <div class="space-y-1.5">
                    <x-form.label :for="$field['name']">{{ $field['label'] }}</x-form.label>
                    @if (($field['type'] ?? 'input') === 'select')
                        <x-form.select
                            :id="$field['name']"
                            :name="$field['name']"
                            :value="$field['value']"
                            :options="$field['options']"
                            :disabled="$readonly"
                        />
                    @else
                        <x-enterprise.input
                            :id="$field['name']"
                            :name="$field['name']"
                            :value="$field['value']"
                            :variant="$readonly ? 'disabled' : ($field['variant'] ?? null)"
                            :tone="$field['tone'] ?? null"
                        />
                    @endif
                </div>
            @endforeach
        </div>
    </x-card>

    <x-enterprise.subtab :tabs="$tabs" class="bg-white px-5 pt-4 shadow-sm" />

    <div x-cloak x-show="activeTab === 'general'" class="space-y-6">
        <x-card title="General" description="Operational, utilization, and maintenance-center details arranged as a dense two-column form." padding="p-6">
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($generalFields as $field)
                    <div class="space-y-1.5">
                        <x-form.label :for="$field['name']">{{ $field['label'] }}</x-form.label>
                        <x-enterprise.input
                            :id="$field['name']"
                            :name="$field['name']"
                            :value="$field['value']"
                            :variant="$readonly ? 'disabled' : ($field['variant'] ?? null)"
                        />
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card title="Address" description="Source selector and normalized address details for the selected functional location." padding="p-6">
            <div class="space-y-5" x-data="{ addressSource: 'free', recordSelected: {{ $recordSelected ? 'true' : 'false' }} }">
                <label class="flex items-center gap-3 text-sm font-medium text-gray-700">
                    <input
                        type="radio"
                        name="address_source"
                        value="free"
                        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                        x-model="addressSource"
                        @disabled($readonly)
                    >
                    <span>Free address</span>
                </label>

                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($addressFields as $field)
                        @php
                            $disabledWhen = $field['disabled_when'];
                            $alwaysDisabled = $disabledWhen === 'always';
                            $alpineDisabled = $alwaysDisabled ? null : (
                                $disabledWhen === 'free'
                                    ? "addressSource === 'free'"
                                    : "addressSource !== 'free'"
                            );
                        @endphp
                        @if (($field['type'] ?? 'input') === 'select')
                            <div class="space-y-1.5">
                                <x-form.label :for="$field['name']">{{ $field['label'] }}</x-form.label>
                                @if ($alwaysDisabled || $readonly)
                                    <x-form.select
                                        :id="$field['name']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        :options="$field['options']"
                                        disabled
                                    />
                                @else
                                    <x-form.select
                                        :id="$field['name']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        :options="$field['options']"
                                        x-bind:disabled="{{ $alpineDisabled }}"
                                    />
                                @endif
                            </div>
                        @else
                            <div class="space-y-1.5">
                                <x-form.label :for="$field['name']">{{ $field['label'] }}</x-form.label>
                                @if ($alwaysDisabled || $readonly)
                                    <x-enterprise.input
                                        :id="$field['name']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        variant="disabled"
                                    />
                                @else
                                    <x-enterprise.input
                                        :id="$field['name']"
                                        :name="$field['name']"
                                        :value="$field['value']"
                                        :variant="$field['variant'] ?? null"
                                        x-bind:disabled="{{ $alpineDisabled }}"
                                    />
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="grid gap-4 border-t border-gray-200 pt-4 md:grid-cols-[minmax(0,1fr)_auto] md:items-end">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700">Obtain address from</p>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 text-sm text-gray-700">
                                <input
                                    type="radio"
                                    name="address_source"
                                    value="owner"
                                    class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                                    x-model="addressSource"
                                    @disabled($readonly)
                                >
                                <span>Owner</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-gray-700">
                                <input
                                    type="radio"
                                    name="address_source"
                                    value="operator"
                                    class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                                    x-model="addressSource"
                                    @disabled($readonly)
                                >
                                <span>Operator</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-start md:justify-end">
                        <button type="button" class="btn-secondary min-w-32" :disabled="!recordSelected || addressSource === 'free'" @disabled($readonly)>Obtain</button>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'counters'" class="space-y-6">
        <x-card title="Counters" description="Counter grid, summary row, and operator actions adapted from the legacy layout." padding="p-6">
            <div class="space-y-5">
                <x-data-table :min-rows="10" :row-count="count($counterRows)">
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
                        @foreach ($counterRows as $row)
                            <tr class="table-row">
                                <td class="table-td font-medium text-gray-900">{{ $row['counter_desc'] }}</td>
                                <td class="table-td">{{ $row['value'] }}</td>
                                <td class="table-td">
                                    <span class="inline-flex h-3.5 w-3.5 rounded-full {{ $row['tone'] === 'green' ? 'bg-emerald-500 ring-4 ring-emerald-100' : 'bg-amber-500 ring-4 ring-amber-100' }}"></span>
                                </td>
                                <td class="table-td">{{ $row['unit'] }}</td>
                                <td class="table-td">{{ $row['reading_date'] }}</td>
                                <td class="table-td">{{ $row['max'] }}</td>
                                <td class="table-td">{{ $row['remaining'] }}</td>
                                <td class="table-td">{{ $row['residual'] }}</td>
                                <td class="table-td">
                                    @if ($row['equipment_id'] !== '')
                                        <x-enterprise.table-cell variant="arrow" :href="route('fleet.equipment.show', ['id' => 1])">{{ $row['equipment_id'] }}</x-enterprise.table-cell>
                                    @endif
                                </td>
                                <td class="table-td">{{ $row['info_source'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>

                <x-data-table :min-rows="10" :row-count="count($counterSummaryRows)">
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
                        @foreach ($counterSummaryRows as $row)
                            <tr class="table-row">
                                <td class="table-td">{{ $row['counter_desc'] }}</td>
                                <td class="table-td">{{ $row['value'] }}</td>
                                <td class="table-td">{{ $row['alert'] }}</td>
                                <td class="table-td">{{ $row['unit'] }}</td>
                                <td class="table-td">{{ $row['limit'] }}</td>
                                <td class="table-td font-semibold text-gray-900">{{ $row['remaining'] }}</td>
                                <td class="table-td">{{ $row['residual'] }}</td>
                                <td class="table-td">{{ $row['equipment_id'] }}</td>
                                <td class="table-td">{{ $row['info_source'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>

                @if ($recordSelected)
                    <div class="grid gap-3 sm:grid-cols-2 lg:ml-auto lg:max-w-xl">
                        <button type="button" class="btn-primary justify-center"
                                @disabled(! $flModel)
                                @if ($flModel) @click="$dispatch('open-fl-counters', { flId: {{ $flModel->id }} })" @endif>
                            Update Counters
                        </button>
                        <button type="button" class="btn-secondary justify-center">Counter Reading</button>
                        <button type="button" class="btn-secondary justify-center">Counter History</button>
                        <button type="button" class="btn-secondary justify-center">Counter Hierarchy</button>
                    </div>
                @endif
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'equipment'" class="space-y-6">
        <x-card title="Equipment" description="Primary equipment roster with quick actions for cockpit access and history review." padding="p-6">
            <div class="space-y-5">
                <x-data-table :min-rows="10" :row-count="count($equipmentRows)">
                    <x-slot name="thead">
                        <tr>
                            <th class="table-th">Position</th>
                            <th class="table-th">ID</th>
                            <th class="table-th">Serial no</th>
                            <th class="table-th">Item</th>
                            <th class="table-th">Item Desc</th>
                            <th class="table-th">Variant</th>
                            <th class="table-th">Category part</th>
                        </tr>
                    </x-slot>
                    <x-slot name="tbody">
                        @foreach ($equipmentRows as $row)
                            <tr class="table-row">
                                <td class="table-td">{{ $row['position'] }}</td>
                                <td class="table-td"><x-enterprise.table-cell variant="arrow" :href="route('fleet.equipment.show', ['id' => 1])">{{ $row['id'] }}</x-enterprise.table-cell></td>
                                <td class="table-td">{{ $row['serial_no'] }}</td>
                                <td class="table-td">{{ $row['item'] }}</td>
                                <td class="table-td">{{ $row['item_desc'] }}</td>
                                <td class="table-td">{{ $row['variant'] }}</td>
                                <td class="table-td">{{ $row['category_part'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>

                @if ($recordSelected)
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('fleet.fleet-management-cockpit') }}" class="btn-secondary">Fleet Mngt Cockpit</a>
                        <button type="button" class="btn-secondary">View History</button>
                    </div>
                @endif
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'modifications'" class="space-y-6">
        <x-card title="Modifications" description="Applicable modifications with status and action buttons aligned to the legacy workflow." padding="p-6">
            <div class="space-y-5">
                <x-data-table :min-rows="10" :row-count="count($modificationRows)">
                    <x-slot name="thead">
                        <tr>
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
                        @foreach ($modificationRows as $row)
                            <tr class="table-row">
                                <td class="table-td">{{ $row['type'] }}</td>
                                <td class="table-td"><x-enterprise.table-cell variant="arrow" :href="route('fleet.modification.show', ['id' => 1])">{{ $row['reference'] }}</x-enterprise.table-cell></td>
                                <td class="table-td">{{ $row['revision'] }}</td>
                                <td class="table-td">{{ $row['embodied'] }}</td>
                                <td class="table-td">{{ $row['applied_on'] }}</td>
                                <td class="table-td">{{ $row['deleted'] }}</td>
                                <td class="table-td">{{ $row['removed_on'] }}</td>
                                <td class="table-td">{{ $row['status'] }}</td>
                                <td class="table-td">{{ $row['comment'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>

                @if ($recordSelected)
                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="btn-secondary">View modification on all equipment</button>
                        <button type="button" class="btn-secondary">Apply modification</button>
                        <button type="button" class="btn-secondary">Remove modification</button>
                    </div>
                @endif
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'properties'" class="space-y-6">
        <x-card title="Properties" description="Aircraft commercial data plus installed-base anomaly controls." padding="p-6">
            <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-5" x-data="{ anomaly: {{ $recordSelected ? 'true' : 'false' }} }">
                    <h4 class="text-sm font-semibold text-gray-900">Installed Base Data Anomaly</h4>
                    <div class="mt-4 space-y-4">
                        <label class="flex items-center gap-3 text-sm text-gray-700">
                            <input type="checkbox" x-model="anomaly" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span>Anomaly on Data</span>
                        </label>
                        <label class="flex items-center gap-3 text-sm" :class="anomaly ? 'text-gray-700' : 'text-gray-400'">
                            <input type="checkbox" :disabled="!anomaly" class="h-4 w-4 rounded border-gray-300 text-blue-600 disabled:opacity-50">
                            <span>Lock</span>
                        </label>

                        <div class="grid gap-4 md:grid-cols-2">
                            <x-form.input label="Updated By" name="anomaly_updated_by" :value="$recordSelected ? 'Muhd Nur Yaakob' : ''" class="input-field-filled" />
                            <x-form.input label="Date" name="anomaly_date" :value="$recordSelected ? '27 Mar 2026' : ''" class="input-field-filled" />
                        </div>

                        @if ($recordSelected)
                            <button type="button" class="btn-secondary px-3 py-2 text-xs" :disabled="!anomaly">Comment</button>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($propertyMetaFields as $field)
                        <x-form.input
                            :label="$field['label']"
                            :name="$field['name']"
                            :value="$field['value']"
                            class="input-field-filled"
                        />
                    @endforeach
                </div>
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'events'" class="space-y-6">
        <x-card title="Events" description="Operational history grouped into nested subtabs that mirror the legacy workspace." padding="p-6">
            <div class="space-y-5" x-data="tabs('workpackages')">
                <x-enterprise.subtab :tabs="$eventTabs" class="px-4 pt-3" />

                <div x-cloak x-show="activeTab === 'workpackages'">
                    <x-data-table :min-rows="10" :row-count="count($eventWorkpackageRows)">
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">Code</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">Simulation Date</th>
                                <th class="table-th">Planned Date</th>
                                <th class="table-th">Release Date</th>
                                <th class="table-th">Close Date</th>
                                <th class="table-th">Comment</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($eventWorkpackageRows as $row)
                                <tr class="table-row">
                                    <td class="table-td"><x-enterprise.table-cell variant="arrow">{{ $row['code'] }}</x-enterprise.table-cell></td>
                                    <td class="table-td">{{ $row['status'] }}</td>
                                    <td class="table-td">{{ $row['simulation_date'] }}</td>
                                    <td class="table-td">{{ $row['planned_date'] }}</td>
                                    <td class="table-td">{{ $row['release_date'] }}</td>
                                    <td class="table-td">{{ $row['close_date'] }}</td>
                                    <td class="table-td">{{ $row['comment'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>
                </div>

                <div x-cloak x-show="activeTab === 'repairs'">
                    <x-data-table :min-rows="10" :row-count="count($eventRepairRows)">
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">Code</th>
                                <th class="table-th">Subject</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">Date In</th>
                                <th class="table-th">Intervention Type</th>
                                <th class="table-th">Date Out</th>
                                <th class="table-th">Return Reason</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($eventRepairRows as $row)
                                <tr class="table-row">
                                    <td class="table-td"><x-enterprise.table-cell variant="arrow">{{ $row['code'] }}</x-enterprise.table-cell></td>
                                    <td class="table-td">{{ $row['subject'] }}</td>
                                    <td class="table-td">{{ $row['status'] }}</td>
                                    <td class="table-td">{{ $row['date_in'] }}</td>
                                    <td class="table-td">{{ $row['intervention_type'] }}</td>
                                    <td class="table-td">{{ $row['date_out'] }}</td>
                                    <td class="table-td">{{ $row['return_reason'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>
                </div>

                <div x-cloak x-show="activeTab === 'installed-base'">
                    <x-data-table :min-rows="10" :row-count="count($eventInstalledBaseRows)">
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">Code</th>
                                <th class="table-th">Creation date</th>
                                <th class="table-th">Date Event</th>
                                <th class="table-th">Time Event</th>
                                <th class="table-th">Type</th>
                                <th class="table-th">Subject</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($eventInstalledBaseRows as $row)
                                <tr class="table-row">
                                    <td class="table-td"><x-enterprise.table-cell variant="arrow">{{ $row['code'] }}</x-enterprise.table-cell></td>
                                    <td class="table-td">{{ $row['creation_date'] }}</td>
                                    <td class="table-td">{{ $row['date_event'] }}</td>
                                    <td class="table-td">{{ $row['time_event'] }}</td>
                                    <td class="table-td">{{ $row['type'] }}</td>
                                    <td class="table-td">{{ $row['subject'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>
                </div>

                <div x-cloak x-show="activeTab === 'technical-log'">
                    <x-data-table :min-rows="10" :row-count="count($eventTechnicalLogRows)">
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">!</th>
                                <th class="table-th">Log Number</th>
                                <th class="table-th">Description</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">ATA</th>
                                <th class="table-th">MEL Item Reference</th>
                                <th class="table-th">MEL Item Name</th>
                                <th class="table-th">FL Reference</th>
                                <th class="table-th">Task Number</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($eventTechnicalLogRows as $row)
                                <tr class="table-row">
                                    <td class="table-td">
                                        <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-gray-100 text-gray-500 ring-1 ring-inset ring-gray-200">
                                            <x-icon name="x-circle" class="h-3.5 w-3.5" />
                                        </span>
                                    </td>
                                    <td class="table-td"><x-enterprise.table-cell variant="arrow">{{ $row['log_number'] }}</x-enterprise.table-cell></td>
                                    <td class="table-td">{{ $row['description'] }}</td>
                                    <td class="table-td">{{ $row['status'] }}</td>
                                    <td class="table-td">{{ $row['ata'] }}</td>
                                    <td class="table-td">{{ $row['mel_item_reference'] }}</td>
                                    <td class="table-td">{{ $row['mel_item_name'] }}</td>
                                    <td class="table-td">{{ $row['fl_reference'] }}</td>
                                    <td class="table-td">{{ $row['task_number'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>
                </div>

                <div x-cloak x-show="activeTab === 'others'">
                    <x-data-table :min-rows="10" :row-count="count($eventOtherRows)">
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
                            @foreach ($eventOtherRows as $row)
                                <tr class="table-row">
                                    <td class="table-td">{{ $row['code'] }}</td>
                                    <td class="table-td">{{ $row['creation_date'] }}</td>
                                    <td class="table-td">{{ $row['date_event'] }}</td>
                                    <td class="table-td">{{ $row['type'] }}</td>
                                    <td class="table-td">{{ $row['subject'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>
                </div>

                <div x-cloak x-show="activeTab === 'work-orders'">
                    <x-data-table :min-rows="10" :row-count="count($eventWorkOrderRows)">
                        <x-slot name="thead">
                            <tr>
                                <th class="table-th">Code</th>
                                <th class="table-th">Title</th>
                                <th class="table-th">Intervention Type</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">Start Date</th>
                                <th class="table-th">Close Date</th>
                                <th class="table-th">Work Center</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($eventWorkOrderRows as $row)
                                <tr class="table-row">
                                    <td class="table-td"><x-enterprise.table-cell variant="arrow">{{ $row['code'] }}</x-enterprise.table-cell></td>
                                    <td class="table-td">{{ $row['title'] }}</td>
                                    <td class="table-td">{{ $row['intervention_type'] }}</td>
                                    <td class="table-td">{{ $row['status'] }}</td>
                                    <td class="table-td">{{ $row['start_date'] }}</td>
                                    <td class="table-td">{{ $row['close_date'] }}</td>
                                    <td class="table-td">{{ $row['work_center'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-data-table>
                </div>
            </div>
        </x-card>
    </div>

    <div x-cloak x-show="activeTab === 'attachments'" class="space-y-6">
        <x-card title="Attachments" description="Attachment register with side actions for browsing, viewing, and deleting files." padding="p-6">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_180px]">
                <x-data-table :min-rows="10" :row-count="count($attachmentRows)">
                    <x-slot name="thead">
                        <tr>
                            <th class="table-th">#</th>
                            <th class="table-th">Path</th>
                            <th class="table-th">File Name</th>
                            <th class="table-th">Attachment Date</th>
                        </tr>
                    </x-slot>
                    <x-slot name="tbody">
                        @foreach ($attachmentRows as $row)
                            <tr class="table-row">
                                <td class="table-td">{{ $row['index'] }}</td>
                                <td class="table-td">{{ $row['path'] }}</td>
                                <td class="table-td">{{ $row['file_name'] }}</td>
                                <td class="table-td">{{ $row['attachment_date'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>

                <div class="flex flex-col gap-3 xl:items-stretch">
                    @if ($recordSelected)
                        <button type="button" class="btn-secondary justify-center">Browse</button>
                        <button type="button" class="btn-secondary justify-center">Display</button>
                        <div class="hidden flex-1 xl:block"></div>
                        <button type="button" class="btn-secondary justify-center">Delete</button>
                    @endif
                </div>
            </div>
        </x-card>
    </div>

    <div class="sticky-form-actions">
        <div class="mr-auto">
            <x-record-meta :items="$metadata" />
        </div>
        <button type="button" class="btn-secondary">Cancel</button>
        <button type="button" class="btn-primary">OK</button>
    </div>
</div>
