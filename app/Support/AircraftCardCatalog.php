<?php

declare(strict_types=1);

namespace App\Support;

class AircraftCardCatalog
{
    public static function default(): string
    {
        return 'A6-ATP';
    }

    /**
     * @return array<int, array{registration: string, msn: string, type: string, status: string}>
     */
    public static function all(): array
    {
        return [
            ['registration' => 'A6-ATP', 'msn' => '1234', 'type' => 'A320-214', 'status' => 'Active'],
            ['registration' => 'A6-EAS', 'msn' => '5678', 'type' => 'A320-251N', 'status' => 'Active'],
            ['registration' => 'A6-WSA', 'msn' => '9012', 'type' => 'A321-271N', 'status' => 'MEL'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function find(string $registration): array
    {
        return match ($registration) {
            'A6-EAS' => self::a6Eas(),
            'A6-WSA' => self::a6Wsa(),
            default  => self::a6Atp(),
        };
    }

    public static function exists(string $registration): bool
    {
        return in_array($registration, ['A6-ATP', 'A6-EAS', 'A6-WSA'], true);
    }

    /**
     * @return array<string, mixed>
     */
    private static function a6Atp(): array
    {
        return [
            'registration' => 'A6-ATP',
            'msn'          => '1234',
            'status'       => 'Active',
            'last_updated' => '22 May 2025 10:35 UTC',

            'identity' => [
                'aircraft_type'    => 'A320-214',
                'delivery_date'    => '15 Jan 2012',
                'configuration'    => 'C16 Y150',
                'base'             => 'AUH',
                'maintenance_plan' => 'A320 AMM ISS 7 REV 5',
                'owner'            => 'Eastmoon Aviation',
                'operator'         => 'Eastmoon Aviation Services Sdn Bhd',
            ],

            'utilization' => [
                'avg_fh_per_day' => 7.28,
                'avg_fc_per_day' => 4.12,
                'fh_series'      => [6.1, 6.3, 6.8, 7.0, 6.5, 6.9, 7.2, 7.4, 7.1, 6.8, 7.0, 7.3, 7.5, 7.2, 7.4, 7.6, 7.3, 7.1, 7.4, 7.7, 7.5, 7.2, 7.4, 7.6, 7.8, 7.5, 7.3, 7.6, 7.4, 7.28],
                'fc_series'      => [3.4, 3.6, 3.8, 4.0, 3.7, 3.9, 4.1, 4.2, 4.0, 3.8, 4.0, 4.1, 4.3, 4.0, 4.2, 4.3, 4.1, 3.9, 4.1, 4.4, 4.2, 4.0, 4.1, 4.3, 4.4, 4.2, 4.0, 4.3, 4.1, 4.12],
            ],

            'overview' => [
                'status_summary' => [
                    ['group' => 'Configuration Status',         'icon' => 'exclamation-triangle', 'tone' => 'red',    'count' => 12, 'label' => 'Uninstalled Component'],
                    ['group' => 'Maintenance Status',           'icon' => 'calendar-days',        'tone' => 'amber',  'count' => 8,  'label' => 'Overdue'],
                    ['group' => 'Maintenance Planning Status',  'icon' => 'check-circle',         'tone' => 'green',  'count' => 0,  'label' => 'Due Within Alarm'],
                    ['group' => 'Maintenance Planning Status',  'icon' => 'bell',                 'tone' => 'amber',  'count' => 3,  'label' => 'Overdue Without Work Package'],
                    ['group' => 'Technical Publications Status','icon' => 'document',             'tone' => 'amber',  'count' => 2,  'label' => 'Due Within Alarm Without Work Package'],
                    ['group' => 'Technical Publications Status','icon' => 'document',             'tone' => 'red',    'count' => 0,  'label' => 'Overdue Technical Publication Compliance'],
                    ['group' => 'Defects Status',               'icon' => 'document',             'tone' => 'amber',  'count' => 1,  'label' => 'Open Defects (1 of 5)'],
                    ['group' => 'Defects Status',               'icon' => 'document',             'tone' => 'red',    'count' => 2,  'label' => 'Overdue Deferred Defects (MEL / CFD)'],
                ],
                'top_counters' => [
                    ['code' => 'TSN',     'value' => '24,567.30', 'unit' => 'HH:MM',    'reading_date' => '23.04.26', 'source' => 'Flight XXOXX'],
                    ['code' => 'CSN',     'value' => '14,256',    'unit' => 'Cycles',   'reading_date' => '23.04.26', 'source' => 'Flight XXOXX'],
                    ['code' => 'LAND',    'value' => '14,112',    'unit' => 'Landings', 'reading_date' => '23.04.26', 'source' => 'Flight XXOXX'],
                    ['code' => 'DI-EIS',  'value' => '4,876',     'unit' => 'Days',     'reading_date' => '23.04.26', 'source' => 'Engine Data (DCU)'],
                    ['code' => 'MS-EIS',  'value' => '160',       'unit' => 'Months',   'reading_date' => '23.04.26', 'source' => 'Independent'],
                ],
                'critical_due' => [
                    ['type' => 'Visit',                 'reference' => 'A320-22-00',    'description' => 'A Check',                     'component' => 'A/C A6-ATP',         'last_done' => '20.03.26 WO: WOA11665',   'threshold' => '600:00HRS/1Y',  'interval' => '600:00HRS/1Y',  'next_due' => '21.04.26', 'remaining' => '2 Days',  'tone' => 'red'],
                    ['type' => 'Technical Publication (AD)', 'reference' => 'AD 2023-10-05', 'description' => 'AD - Cabin door inspection', 'component' => 'PN: ABC123 SN: DEF456', 'last_done' => '-',                       'threshold' => '1000:00HRS',    'interval' => '1000:00HRS',    'next_due' => '19.04.26', 'remaining' => '4 Days',  'tone' => 'amber'],
                    ['type' => 'Task (Kardex)',         'reference' => '72-30-00',      'description' => 'Hot Section Inspection (ENG 1)', 'component' => 'PN: ABC124 SN: DEF457', 'last_done' => '13.01.24 WO: WO-12345',   'threshold' => '6M',           'interval' => '3M',            'next_due' => '17.04.26', 'remaining' => '4 Days',  'tone' => 'amber'],
                    ['type' => 'Defect (MEL)',          'reference' => '79-10-00',      'description' => 'Oil Change (APU)',            'component' => 'PN: ABC125 SN: DEF458', 'last_done' => '07.07.22 WO: WO-67890',   'threshold' => '50:00HRS',     'interval' => '50:00HRS',      'next_due' => '05.04.26', 'remaining' => '7 Days',  'tone' => 'amber'],
                    ['type' => 'Unscheduled',           'reference' => '72-00-00',      'description' => 'LLP Inspection (CSN)',         'component' => 'A/C A320-214',         'last_done' => '-',                       'threshold' => '50CYCLES',     'interval' => '50CYCLES',      'next_due' => '03.05.26', 'remaining' => '10 Days', 'tone' => 'amber'],
                ],
                'work_packages' => [
                    ['no' => 'WABCD/1234/0108', 'description' => 'DT31-01 CPLT DIGITAL CLOCK BATTERY (24M)', 'status' => 'OPEN',    'prepared_by' => 'JENNY DEPP',   'date' => '01.01.26'],
                    ['no' => 'WABCD/1234/0101', 'description' => 'CENTRAL MAINTENANCE SYSTEM (CMS)',         'status' => 'OPEN',    'prepared_by' => 'LOUIS BUTTON', 'date' => '12.12.25'],
                    ['no' => 'WABCD/1234/0104', 'description' => 'AW139 ACCP 1 WEEK',                        'status' => 'OPEN',    'prepared_by' => 'MO SALAM',     'date' => '01.11.25'],
                    ['no' => 'WABCD/1234/0103', 'description' => 'BIOBOR JF TREATMENT',                      'status' => 'PLANNED', 'prepared_by' => 'PIERRE',       'date' => '23.10.25'],
                    ['no' => 'WABCD/1234/0099', 'description' => 'ENGINE WASH - CFM56',                      'status' => 'PLANNED', 'prepared_by' => 'JANE DOE',     'date' => '18.10.25'],
                ],
                'work_orders' => [
                    ['no' => 'WO-12349', 'type' => 'AD',          'description' => 'EASA AD 2019-0121 PARA A.2',          'status' => 'OPEN',    'next_due' => '21.04.26', 'wp_no' => 'WABCD/1234/0108'],
                    ['no' => 'WO-12348', 'type' => 'EOAS',        'description' => 'EOAS 366 - AW139 HYDRAULIC FLUID SERVICE', 'status' => 'PLANNED', 'next_due' => '19.04.26', 'wp_no' => 'WABCD/1234/0108'],
                    ['no' => 'WO-12347', 'type' => 'Repair Order','description' => 'COMPONENT RECERTIFICATION PROCESS',    'status' => 'OPEN',    'next_due' => '17.04.26', 'wp_no' => 'WABCD/1234/0108'],
                    ['no' => 'WO-12346', 'type' => 'Check',       'description' => '150HRS',                              'status' => 'PLANNED', 'next_due' => '30.04.26', 'wp_no' => 'WABCD/1234/0108'],
                    ['no' => 'WO-12345', 'type' => 'OOP',         'description' => '25 Hrs or 7 Days ACCP',               'status' => 'OPEN',    'next_due' => '03.05.26', 'wp_no' => 'WABCD/1234/0108'],
                ],
                'journey_logs' => [
                    ['no' => 'A046390', 'status' => 'OPEN',   'date' => '25.04.26', 'total_fh' => '+02:15', 'total_fc' => '+1', 'total_apu_hours' => '+02:15', 'sectors' => 2],
                    ['no' => 'A046389', 'status' => 'OPEN',   'date' => '24.04.26', 'total_fh' => '+02:25', 'total_fc' => '+1', 'total_apu_hours' => '+02:25', 'sectors' => 2],
                    ['no' => 'A046363', 'status' => 'CLOSED', 'date' => '20.04.26', 'total_fh' => '+02:30', 'total_fc' => '+1', 'total_apu_hours' => '+02:30', 'sectors' => 3],
                    ['no' => 'A046360', 'status' => 'CLOSED', 'date' => '19.04.26', 'total_fh' => '+03:40', 'total_fc' => '+1', 'total_apu_hours' => '+03:40', 'sectors' => 1],
                    ['no' => 'A046347', 'status' => 'CLOSED', 'date' => '17.04.26', 'total_fh' => '+03:45', 'total_fc' => '+1', 'total_apu_hours' => '+03:45', 'sectors' => 3],
                ],
                'events' => [
                    ['id' => 'XXXXXX', 'type' => 'Component Installation',     'category' => 'Technical',   'date' => '25.04.26', 'time' => '10:15', 'description' => 'Installation of Engine 1'],
                    ['id' => 'XXXXX7', 'type' => 'Applied Configuration Update','category' => 'Technical',   'date' => '24.04.26', 'time' => '14:30', 'description' => 'Config update to STD 3.2'],
                    ['id' => 'XXXX76', 'type' => 'Visit Application',          'category' => 'Maintenance', 'date' => '20.04.26', 'time' => '09:45', 'description' => 'A Check Visit Applied'],
                    ['id' => 'XXXX55', 'type' => 'Technical Publication Embodiment','category' => 'Technical', 'date' => '19.04.26', 'time' => '11:20', 'description' => 'AD 2023-10-05 Embodiment'],
                    ['id' => 'XXXX54', 'type' => 'Defect Creation (Closed)',   'category' => 'Defect',      'date' => '17.04.26', 'time' => '16:05', 'description' => 'Defect reported'],
                ],
            ],

            'general' => [
                'lifecycle' => [
                    'date_of_manufacture' => '15 Jan 2012',
                    'entry_into_service'  => '15 Jan 2012',
                    'date_of_acquisition' => '10 Jan 2012',
                    'acquisition_cost'    => '45,600,000.00',
                    'currency'            => 'USD',
                ],
                'operator_org' => [
                    'operator'         => 'Eastmoon Aviation Services Sdn Bhd',
                    'owner_lessor'     => 'Eastmoon Aviation',
                    'mro'              => 'Emirates Engineering Centre',
                    'home_base'        => 'AUH - Abu Dhabi International Airport',
                ],
                'mass_limits' => [
                    'mtow'  => '77,500',  'mtow_unit'  => 'KG',
                    'mlw'   => '66,000',  'mlw_unit'   => 'KG',
                    'mzfw'  => '61,500',  'mzfw_unit'  => 'KG',
                    'oew'   => '42,650',  'oew_unit'   => 'KG',
                ],
                'registration' => [
                    'aircraft_registration' => 'A6-ATP',
                    'state_of_registry'     => 'United Arab Emirates',
                    'coa_issue_date'        => '15 Jan 2012',
                    'coa_expiry_date'       => '14 Jan 2026',
                    'airworthiness_authority' => 'GCAA - General Civil Aviation Authority',
                ],
                'manufacturer' => [
                    'manufacturer'             => 'AIRBUS',
                    'aircraft_model'           => 'A320-214',
                    'manufacturer_serial_number' => '1234',
                    'line_number'              => '0256',
                ],
                'powerplant' => [
                    'engine_type'         => 'CFM56-5B4/3',
                    'engine_manufacturer' => 'CFM International',
                    'number_of_engines'   => 2,
                    'apu_installed'       => true,
                ],
                'owner_address' => [
                    'address_line_1' => 'Emirates Engineering Centre',
                    'address_line_2' => 'PO Box 77',
                    'city'           => 'Dubai',
                    'state_province' => '',
                    'country'        => 'United Arab Emirates',
                    'postal_code'    => '3456',
                ],
                'commercial' => [
                    'lease_type'      => 'Owned',
                    'lessor_name'     => 'N/A',
                    'lease_start_date'=> 'N/A',
                    'lease_end_date'  => 'N/A',
                    'remarks'         => '',
                ],
            ],

            'configuration' => [
                'status_pill' => 'Complete',
                'status_note' => 'All mandatory positions installed',
                'summary' => [
                    ['label' => 'Total Positions',         'value' => '1,248'],
                    ['label' => 'Installed Positions',     'value' => '1,186'],
                    ['label' => 'Missing Positions',       'value' => '62',  'tone' => 'red'],
                    ['label' => 'Unconfirmed Positions',   'value' => '0'],
                    ['label' => 'Pending Inspection',      'value' => '3',   'tone' => 'amber'],
                ],
                'effective' => [
                    'effective_date_time' => '21 May 2025 08:45 UTC',
                    'source'              => 'SYSTEM',
                ],
                'tree' => [
                    [
                        'chapter' => '21 - Air Conditioning',
                        'installation_status' => 'OK',
                        'config_status' => 'OK',
                        'missing' => 2,
                        'children' => [
                            [
                                'chapter' => '21-10-00 - Air Conditioning System',
                                'installation_status' => 'OK',
                                'config_status' => 'OK',
                                'missing' => 2,
                                'children' => [
                                    ['chapter' => '21-10-00-00 - Air Conditioning Pack 1', 'installation_status' => 'OK', 'config_status' => 'Installed', 'missing' => 0, 'selected' => true],
                                    ['chapter' => '21-10-00-10 - Air Cycle Machine',       'installation_status' => 'OK', 'config_status' => 'Installed', 'missing' => 0],
                                    ['chapter' => '21-10-00-20 - Condenser',                'installation_status' => 'OK', 'config_status' => 'Installed', 'missing' => 0],
                                    ['chapter' => '21-10-00-30 - Pack Controller',          'installation_status' => 'OK', 'config_status' => 'Installed', 'missing' => 0],
                                    ['chapter' => '21-10-00-40 - Valve Assembly',           'installation_status' => 'NOK', 'config_status' => 'Missing',   'missing' => 1, 'tone' => 'red'],
                                    ['chapter' => '21-10-00-50 - Temperature Sensor',       'installation_status' => 'NOK', 'config_status' => 'Missing',   'missing' => 1, 'tone' => 'red'],
                                    ['chapter' => '21-20-00-00 - Air Conditioning Pack 2',  'installation_status' => 'NOK', 'config_status' => 'Missing',   'missing' => 1, 'tone' => 'red'],
                                ],
                            ],
                        ],
                    ],
                    ['chapter' => '22 - Auto Flight',         'installation_status' => 'OK',   'config_status' => 'OK',   'missing' => 0],
                    ['chapter' => '23 - Communications',      'installation_status' => 'OK',   'config_status' => 'OK',   'missing' => 0],
                    ['chapter' => '24 - Electrical Power',    'installation_status' => 'NOK',  'config_status' => 'NOK',  'missing' => 0, 'tone' => 'red'],
                    ['chapter' => '25 - Equipment / Furnishings', 'installation_status' => 'OK', 'config_status' => 'OK', 'missing' => 0],
                    ['chapter' => '26 - Fire Protection',     'installation_status' => 'OK',   'config_status' => 'OK',   'missing' => 0],
                ],
                'selected_node' => [
                    'breadcrumbs' => 'A/C > 21 - Air Conditioning > 21-10-00 - Air Conditioning System > 2110-00-00 - Air Conditioning Pack 1',
                    'chapter'     => '2110-00-00 - Air Conditioning Pack 1',
                    'status'      => 'INSTALLED',
                    'header' => [
                        'part_number'       => 'CML-2110-001',
                        'serial_number'     => 'P-12345',
                        'manufacturer'      => 'LIEBHERR',
                        'manufacturer_part_no' => 'LH-APACK1',
                        'position'          => 'FWD Equipment Bay',
                        'installed_on'      => 'A6-ATP (MSN 1234)',
                        'installed_date'    => '15 Jan 2012',
                    ],
                    'installation_status' => [
                        ['label' => 'Installation Status',  'value' => 'Installed'],
                        ['label' => 'Configuration Status', 'value' => 'OK'],
                        ['label' => 'Airworthiness Status', 'value' => 'Airworthy'],
                        ['label' => 'Serviceability',       'value' => 'Serviceable'],
                        ['label' => 'Last Verified',        'value' => '20 May 2025'],
                        ['label' => 'Verified By',          'value' => 'TECH01'],
                    ],
                    'counters' => [
                        ['code' => 'FH (Flight Hours)',  'value' => '8,425', 'uom' => 'FH', 'reading_date' => '20 May 2025'],
                        ['code' => 'FC (Flight Cycles)', 'value' => '4,210', 'uom' => 'FC', 'reading_date' => '20 May 2025'],
                        ['code' => 'TSN (Time Since New)','value' => '8,425', 'uom' => 'FH', 'reading_date' => '20 May 2025'],
                        ['code' => 'CSN (Cycles Since New)','value' => '4,210', 'uom' => 'FC', 'reading_date' => '20 May 2025'],
                    ],
                    'maintenance_due' => [
                        ['item' => 'Task (Kardex)',  'reference' => '72-30-00',    'description' => 'Hot Section Inspection', 'last_done' => '13 Jan 2024 (WO-12345 / WP-7878)',  'threshold' => '6,000 FH', 'interval' => '6,000 FH', 'next_due' => '17 Apr 2026', 'remaining' => '224 Days', 'tone' => 'amber'],
                        ['item' => 'Defect (MEL)',   'reference' => '79-10-00',    'description' => 'Oil Change (APU)',        'last_done' => '07 Jul 2024 (WO-67890 / WP-7878)',  'threshold' => '50 FH',    'interval' => '50 FH',    'next_due' => '30 Apr 2026', 'remaining' => '06 Jul 2025', 'tone' => 'red'],
                        ['item' => 'Technical Publication (AD)', 'reference' => 'AD 2023-10-05', 'description' => 'AD - Cabin door inspection', 'last_done' => '-', 'threshold' => '1,000 FH', 'interval' => '1,000 FH', 'next_due' => '19 Apr 2026', 'remaining' => '226 Days', 'tone' => 'red'],
                    ],
                    'history' => [
                        ['date' => '20 May 2025', 'action' => 'Counters Updated', 'part_number' => 'CML-2110-001', 'serial_number' => 'P-12345', 'status' => 'Serviceable', 'performed_by' => 'TECH01', 'remarks' => 'Routine counter update'],
                        ['date' => '15 May 2025', 'action' => 'Inspected',        'part_number' => 'CML-2110-001', 'serial_number' => 'P-12345', 'status' => 'Serviceable', 'performed_by' => 'TECH01', 'remarks' => 'Routine inspection'],
                        ['date' => '21 Jan 2025', 'action' => 'Shop Visit',       'part_number' => 'CML-2110-001', 'serial_number' => 'P-12345', 'status' => 'Completed',  'performed_by' => 'TECH08', 'remarks' => 'Routine check'],
                        ['date' => '08 Sep 2018', 'action' => 'Installed',        'part_number' => 'CML-2110-001', 'serial_number' => 'P-12345', 'status' => 'Installed',  'performed_by' => 'TECH12', 'remarks' => 'Initial installation'],
                        ['date' => '15 Jan 2012', 'action' => 'Installed',        'part_number' => 'CML-2110-001', 'serial_number' => 'P-12345', 'status' => 'Installed',  'performed_by' => 'TECH12', 'remarks' => 'Initial installation'],
                    ],
                    'config_control' => [
                        ['label' => 'IPC Reference',  'value' => 'A320 IPC Rev 54'],
                        ['label' => 'Effectivity',    'value' => '004001-999999'],
                        ['label' => 'Config Revision','value' => 'C16 Y150 Rev 03'],
                        ['label' => 'Last Audit Date','value' => '21 May 2025'],
                    ],
                    'compliance' => [
                        ['label' => 'AD Compliance',     'value' => 'Compliant',      'tone' => 'green'],
                        ['label' => 'SB Compliance',     'value' => 'Compliant',      'tone' => 'green'],
                        ['label' => 'Position Valid',    'value' => 'Yes',            'tone' => 'green'],
                        ['label' => 'Duplicate Installed','value' => 'No',            'tone' => 'green'],
                    ],
                ],
            ],

            'counters' => [
                'summary' => [
                    ['label' => 'Total Counters',     'value' => '12', 'icon' => 'chart-bar'],
                    ['label' => 'Initialized',         'value' => '10', 'icon' => 'check-circle',         'tone' => 'green'],
                    ['label' => 'Not Initialized',     'value' => '0',  'icon' => 'exclamation-triangle', 'tone' => 'amber'],
                    ['label' => 'Suspended',           'value' => '0',  'icon' => 'x-circle'],
                ],
                'reading_checks' => [
                    ['label' => 'Aircraft Counters',     'description' => 'All aircraft counters have the same reading date.', 'tone' => 'green'],
                    ['label' => 'Aircraft vs Structure', 'description' => 'All structure counters match aircraft reading date.','tone' => 'green'],
                    ['label' => 'Not Initialized Counters','description' => 'No counters found uninitialized.',                'tone' => 'green'],
                ],
                'last_update' => [
                    'date'   => '20 May 2025',
                    'time'   => '08:45 UTC',
                    'by'     => 'SYSTEM',
                ],
                'rows' => [
                    ['code' => 'TT',       'name' => 'Total Time (Since New)',       'value' => '8,425', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'TC',       'name' => 'Total Cycles (Since New)',     'value' => '4,210', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'TSO',      'name' => 'Time Since Overhaul',          'value' => '5,120', 'reading_date' => '20 May 2025', 'source' => 'Flight XXXX',       'status' => 'ACTIVE'],
                    ['code' => 'CSO',      'name' => 'Cycles Since Overhaul',        'value' => '2,560', 'reading_date' => '20 May 2025', 'source' => 'Flight XXXX',       'status' => 'ACTIVE'],
                    ['code' => 'TSV',      'name' => 'Time Since Shop Visit',        'value' => '2,105', 'reading_date' => '15 May 2025', 'source' => 'Independent',        'status' => 'ACTIVE'],
                    ['code' => 'CSV',      'name' => 'Cycles Since Shop Visit',      'value' => '1,020', 'reading_date' => '15 May 2025', 'source' => 'Independent',        'status' => 'ACTIVE'],
                    ['code' => 'LDG',      'name' => 'Landings (Since New)',         'value' => '3,987', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'APU TT',   'name' => 'APU Total Time (Since New)',   'value' => '1,245', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'APU TC',   'name' => 'APU Cycles (Since New)',       'value' => '820',   'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'ENG1 TSO', 'name' => 'Engine #1 Time Since Overhaul','value' => '1,980', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'ENG1 CSO', 'name' => 'Engine #1 Cycles Since Overhaul','value' => '980', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                    ['code' => 'ENG2 TSO', 'name' => 'Engine #2 Time Since Overhaul','value' => '2,010', 'reading_date' => '20 May 2025', 'source' => 'Engine Data (DCU)', 'status' => 'ACTIVE'],
                ],
                'by_type_donut' => [
                    'total' => 12,
                    'segments' => [
                        ['label' => 'Time',     'value' => 6, 'pct' => 50, 'color' => '#3b82f6'],
                        ['label' => 'Cycles',   'value' => 4, 'pct' => 33, 'color' => '#f97316'],
                        ['label' => 'Landings', 'value' => 1, 'pct' => 8,  'color' => '#22c55e'],
                        ['label' => 'APU',      'value' => 1, 'pct' => 8,  'color' => '#a855f7'],
                    ],
                ],
                'by_source_donut' => [
                    'total' => 12,
                    'segments' => [
                        ['label' => 'Engine Data (DCU)', 'value' => 7, 'pct' => 58, 'color' => '#22c55e'],
                        ['label' => 'Flight XXXX',       'value' => 3, 'pct' => 25, 'color' => '#3b82f6'],
                        ['label' => 'Independent',       'value' => 2, 'pct' => 17, 'color' => '#f97316'],
                    ],
                ],
            ],

            'maintenance' => [
                'summary' => [
                    ['label' => 'Total Items',      'value' => '156', 'icon' => 'clipboard-document-list'],
                    ['label' => 'Compliant',        'value' => '112', 'icon' => 'check-circle',         'tone' => 'green'],
                    ['label' => 'Due Within Alarm', 'value' => '18',  'icon' => 'clock',                'tone' => 'amber'],
                    ['label' => 'Overdue',          'value' => '12',  'icon' => 'exclamation-triangle', 'tone' => 'red'],
                    ['label' => 'Not Due',          'value' => '14',  'icon' => 'x-circle'],
                ],
                'donut' => [
                    'pct_compliant' => 72,
                    'segments' => [
                        ['label' => 'Compliant',        'value' => 112, 'color' => '#22c55e'],
                        ['label' => 'Due Within Alarm', 'value' => 18,  'color' => '#f59e0b'],
                        ['label' => 'Overdue',          'value' => 12,  'color' => '#ef4444'],
                        ['label' => 'Not Due',          'value' => 14,  'color' => '#9ca3af'],
                    ],
                ],
                'utilization' => [
                    'fh'        => '8,425',
                    'fc'        => '4,210',
                    'cal_days'  => '2,150',
                ],
                'rows' => [
                    ['type' => 'Visit',                 'reference' => 'A320-22-00',    'description' => 'A Check',                       'component' => 'A/C A6-ATP',  'last_date' => '20 Mar 2026', 'last_fh_fc' => '8,012 FH',  'work_order' => 'WOA11665', 'work_package' => 'W001/1234/001', 'threshold' => '600:00HRS', 'interval' => '12M', 'next_date' => '20 Mar 2027', 'next_fh_fc' => '16,012 FH', 'remaining_fh_fc' => '8,000 FH', 'remaining_days' => 330, 'status' => 'Compliant',          'tone' => 'green'],
                    ['type' => 'Task (Kardex)',         'reference' => '72-30-00',      'description' => 'Hot Section Inspection (ENG 1)', 'component' => 'ENG 1',     'last_date' => '13 Jan 2024', 'last_fh_fc' => '5,420 FH',  'work_order' => 'WO-12345', 'work_package' => 'W001/5678/002', 'threshold' => '6,000 FH',  'interval' => '-',   'next_date' => '11 Jan 2026', 'next_fh_fc' => '11,420 FH', 'remaining_fh_fc' => '6,000 FH', 'remaining_days' => 224, 'status' => 'Due Within Alarm',   'tone' => 'amber'],
                    ['type' => 'Technical Publication (AD)', 'reference' => 'AD 2023-10-05', 'description' => 'AD - Cabin door inspection', 'component' => 'Cabin Door L/R', 'last_date' => '-', 'last_fh_fc' => '-',         'work_order' => '-',         'work_package' => '-',             'threshold' => '1,000:00HRS','interval' => '-',  'next_date' => '19 Apr 2026', 'next_fh_fc' => '9,580 FH',  'remaining_fh_fc' => '9,580 FH', 'remaining_days' => 331, 'status' => 'Due Within Alarm',   'tone' => 'amber'],
                    ['type' => 'Task',                  'reference' => '27-31-00-005',  'description' => 'Spoiler Actuator Inspection',    'component' => 'Flight Controls','last_date' => '12 Mar 2025', 'last_fh_fc' => '7,950 FH',  'work_order' => 'WO-66881', 'work_package' => 'W001/2345/003', 'threshold' => '3,000 FH',  'interval' => '-',  'next_date' => '12 Mar 2026', 'next_fh_fc' => '10,950 FH', 'remaining_fh_fc' => '3,000 FH', 'remaining_days' => 294, 'status' => 'Due Within Alarm',  'tone' => 'amber'],
                    ['type' => 'Visit',                 'reference' => 'A320-49-21-00', 'description' => 'APU',                            'component' => 'APU',       'last_date' => '05 Jan 2025', 'last_fh_fc' => '7,215 FH',  'work_order' => 'WO-66451', 'work_package' => 'W001/1011/001', 'threshold' => 'C Check (24 Months)', 'interval' => '24H', 'next_date' => '05 Jan 2026', 'next_fh_fc' => '13,215 FH', 'remaining_fh_fc' => '5,990 FH', 'remaining_days' => 228, 'status' => 'Due Within Alarm', 'tone' => 'amber'],
                    ['type' => 'Defect (MEL)',          'reference' => '79-00-00',      'description' => 'Oil Change (APU)',                'component' => 'APU',       'last_date' => '07 Jul 2022', 'last_fh_fc' => '3,110 FH',  'work_order' => 'WO-47890', 'work_package' => 'W001/7777/001', 'threshold' => '50:00HRS',  'interval' => '-',  'next_date' => '30 Apr 2026', 'next_fh_fc' => '8,110 FH',  'remaining_fh_fc' => '5,000 FH', 'remaining_days' => 338, 'status' => 'Overdue',           'tone' => 'red'],
                    ['type' => 'Task',                  'reference' => '32-11-00-001',  'description' => 'Landing Gear - General Inspection','component' => 'Landing Gear','last_date' => '20 May 2025', 'last_fh_fc' => '8,425 FH',  'work_order' => 'WO-66881', 'work_package' => 'W001/1990/001', 'threshold' => '6,000 FH',  'interval' => '-',  'next_date' => '20 May 2026', 'next_fh_fc' => '14,425 FH', 'remaining_fh_fc' => '6,000 FH', 'remaining_days' => 397, 'status' => 'Due Within Alarm','tone' => 'amber'],
                    ['type' => 'Visit',                 'reference' => 'A320-21-00',    'description' => 'AD',                              'component' => 'Airframe',  'last_date' => '10 Jan 2024', 'last_fh_fc' => '5,110 FH',  'work_order' => 'WO-66451', 'work_package' => 'W001/3301/001', 'threshold' => 'C Check (24 Months)','interval' => '24H','next_date' => '10 Jan 2026', 'next_fh_fc' => '11,210 FH', 'remaining_fh_fc' => '2,700 FH', 'remaining_days' => 232, 'status' => 'Overdue',           'tone' => 'red'],
                    ['type' => 'Task',                  'reference' => '49-21-00-002',  'description' => 'APU - Oil Change',                'component' => 'APU',       'last_date' => '18 Apr 2025', 'last_fh_fc' => '8,510 FH',  'work_order' => 'WO-66899', 'work_package' => 'W001/5533/004', 'threshold' => '500 FH',    'interval' => '-',  'next_date' => '18 Apr 2026', 'next_fh_fc' => '9,010 FH',  'remaining_fh_fc' => '500 FH',   'remaining_days' => 331, 'status' => 'Overdue',           'tone' => 'red'],
                    ['type' => 'Visit',                 'reference' => 'A320-51-21-00', 'description' => 'WDM - Standard Practices',        'component' => 'A/C Systems','last_date' => '01 Jan 2025', 'last_fh_fc' => '4,900 FH',  'work_order' => 'WO-05980', 'work_package' => 'W001/0101/001', 'threshold' => '12 Months','interval' => '12M', 'next_date' => '01 Jan 2026', 'next_fh_fc' => '6,900 FH',  'remaining_fh_fc' => '-',         'remaining_days' => 224, 'status' => 'Compliant',         'tone' => 'green'],
                ],
            ],

            'technical_publications' => [
                'summary' => [
                    ['label' => 'Total Publications',  'value' => '142', 'icon' => 'document-text'],
                    ['label' => 'Compliant',           'value' => '118', 'icon' => 'check-circle',         'tone' => 'green'],
                    ['label' => 'Due Within 30 Days',  'value' => '18',  'icon' => 'clock',                'tone' => 'amber'],
                    ['label' => 'Overdue',             'value' => '6',   'icon' => 'exclamation-triangle', 'tone' => 'red'],
                ],
                'donut' => [
                    'pct_compliant' => 83,
                    'segments' => [
                        ['label' => 'Compliant',         'value' => 118, 'color' => '#22c55e'],
                        ['label' => 'Due Within 30 Days','value' => 18,  'color' => '#f59e0b'],
                        ['label' => 'Overdue',           'value' => 6,   'color' => '#ef4444'],
                    ],
                ],
                'coverage' => [
                    ['label' => 'Mandatory',     'value' => '124 (100%)'],
                    ['label' => 'Recommended',   'value' => '12 (75%)'],
                    ['label' => 'Informational', 'value' => '6 (60%)'],
                ],
                'rows' => [
                    ['reference' => 'A320-21-01-00', 'type' => 'AMM',  'title' => 'Air Conditioning',           'subtitle' => 'General',                          'ata_chapter' => '21', 'threshold' => 'C Check (24 Months)', 'last_date' => '15 Apr 2025', 'last_fh_fc' => '8,012 FH', 'wp_no' => 'W00007914 / W001/1234/001', 'next_date' => '15 Apr 2027', 'next_fh_fc' => '16,012 FH', 'method' => 'Inspection',     'status' => 'Compliant',           'tone' => 'green', 'source' => 'Airbus',  'revision' => 'REV 31', 'er_date' => '01 Jan 2024'],
                    ['reference' => 'A320-27-10-00', 'type' => 'AMM',  'title' => 'Flight Controls',            'subtitle' => 'General',                          'ata_chapter' => '27', 'threshold' => 'C Check (24 Months)', 'last_date' => '10 Feb 2025', 'last_fh_fc' => '7,812 FH', 'wp_no' => 'W00007421 / W001/1233/001', 'next_date' => '10 Feb 2027', 'next_fh_fc' => '15,812 FH', 'method' => 'Inspection',     'status' => 'Compliant',           'tone' => 'green', 'source' => 'Airbus',  'revision' => 'REV 27', 'er_date' => '01 Jan 2024'],
                    ['reference' => 'A320-32-11-00', 'type' => 'AMM',  'title' => 'Landing Gear',               'subtitle' => 'General',                          'ata_chapter' => '32', 'threshold' => '6000 FH',             'last_date' => '20 May 2025', 'last_fh_fc' => '8,425 FH', 'wp_no' => 'W00007550 / W001/1245/002', 'next_date' => '-',           'next_fh_fc' => '8,425 / 14,425 FH', 'method' => 'Inspection', 'status' => 'Compliant',  'tone' => 'green', 'source' => 'Airbus',  'revision' => 'REV 27', 'er_date' => '01 Jan 2024'],
                    ['reference' => 'A320-49-21-00', 'type' => 'AMM',  'title' => 'APU',                        'subtitle' => 'General',                          'ata_chapter' => '49', 'threshold' => 'C Check (24 Months)', 'last_date' => '05 Jan 2025', 'last_fh_fc' => '7,215 FH', 'wp_no' => 'W00007211 / W001/1321/001', 'next_date' => '05 Jan 2026', 'next_fh_fc' => '13,215 FH', 'method' => 'Inspection',     'status' => 'Due Within 30 Days', 'tone' => 'amber','source' => 'Airbus',  'revision' => 'REV 31', 'er_date' => '01 Jan 2024'],
                    ['reference' => 'A320-SL-27-123','type' => 'SL',   'title' => 'Flight Control Elevator Control Computer - Software Standard', 'subtitle' => 'Improved Plain Protection Logic', 'ata_chapter' => '27', 'threshold' => 'At Next Drop Visit', 'last_date' => 'At Next Drop Visit', 'last_fh_fc' => '-', 'wp_no' => '-', 'next_date' => 'At Next Drop Visit', 'next_fh_fc' => '-', 'method' => 'Incorporation', 'status' => 'Due Within 30 Days', 'tone' => 'amber', 'source' => 'Airbus', 'revision' => 'REV 03', 'er_date' => '15 Dec 2025'],
                    ['reference' => 'A320-25-32-00', 'type' => 'SB',   'title' => 'Equipment / Furnishings',    'subtitle' => 'Galley Equipment Latch Inspection','ata_chapter' => '25', 'threshold' => '4920 FC',             'last_date' => '15 Dec 2024', 'last_fh_fc' => '4,210 FC', 'wp_no' => '-',                          'next_date' => '-',           'next_fh_fc' => '4,210 / 8,210 FC', 'method' => 'Inspection', 'status' => 'Due Within 30 Days', 'tone' => 'amber','source' => 'Airbus', 'revision' => 'REV 02', 'er_date' => '01 Jul 2024'],
                    ['reference' => 'A320-21-01-00', 'type' => 'AD',   'title' => 'Air Conditioning',           'subtitle' => 'Pack Flow Control Valve',           'ata_chapter' => '21', 'threshold' => 'C Check (24 Months)', 'last_date' => '15 Jan 2024', 'last_fh_fc' => '5,110 FH', 'wp_no' => 'W00006621 / W001/1101/001', 'next_date' => '10 Jan 2026', 'next_fh_fc' => '11,110 FH', 'method' => 'Inspection',     'status' => 'Overdue',             'tone' => 'red',  'source' => 'EASA AD 2025-0152', 'revision' => '-', 'er_date' => '10 Jan 2024'],
                    ['reference' => 'A320-51-01-00', 'type' => 'WDM',  'title' => 'Standard Practices',         'subtitle' => 'General',                           'ata_chapter' => '51', 'threshold' => '-',                   'last_date' => '-',           'last_fh_fc' => '-',         'wp_no' => '-',                          'next_date' => '-',           'next_fh_fc' => '-',         'method' => 'Reference',     'status' => 'Compliant',           'tone' => 'green','source' => 'Airbus',  'revision' => 'REV 16', 'er_date' => '01 Jan 2024'],
                ],
            ],

            'defects' => [
                'rows' => [
                    ['type' => 'MAREP', 'tone' => 'red',   'date' => '12 May 2025', 'time' => '08:15', 'aircraft_hours' => '1,230', 'aircraft_cycles' => '610', 'aa_no' => 'A.A.-25410', 'description' => 'Spoiler actuator leaking hydraulic fluid', 'reported_by_name' => 'EAS Tech Ops', 'reported_by_auth' => 'WAS12345', 'action_taken' => 'Replaced right outboard spoiler actuator',     'performed_by_name' => 'EAS Tech Ops',  'performed_by_auth' => 'WAS12345', 'deferral' => 'Yes', 'mel_ref' => '25-21-01', 'mel_repair_category' => 'C', 'mel_expiry_date' => '-',           'reason_for_deferral' => '-', 'part_number' => 'S60-1234-01', 'qty' => 1, 'description_short' => 'Actuator Assy', 'remarks' => 'R/O Spoiler', 'defect_category' => 'MEL Item - mech action required'],
                    ['type' => 'PIREP', 'tone' => 'amber', 'date' => '20 May 2025', 'time' => '14:00', 'aircraft_hours' => '1,001', 'aircraft_cycles' => '511', 'aa_no' => 'A.A.-25125', 'description' => 'Nose gear torque link shows minor crack near bushing', 'reported_by_name' => 'Flight Crew',     'reported_by_auth' => 'WAS22056', 'action_taken' => 'Replaced nose gear torque link',                'performed_by_name' => 'EAS Tech Ops',  'performed_by_auth' => 'WAS12345', 'deferral' => 'Yes', 'mel_ref' => '32-11-09', 'mel_repair_category' => 'B', 'mel_expiry_date' => '08 May 2025', 'reason_for_deferral' => '-', 'part_number' => '321-1678-01', 'qty' => 1, 'description_short' => 'Torque Link Assy', 'remarks' => 'NLG', 'defect_category' => 'MEL Item - planning required'],
                    ['type' => 'INFO',  'tone' => 'gray',  'date' => '11 May 2025', 'time' => '09:05', 'aircraft_hours' => '1,001', 'aircraft_cycles' => '516', 'aa_no' => 'A.A.-25026', 'description' => 'Air conditioning pack flow slightly reduced',         'reported_by_name' => 'EAS Engineering', 'reported_by_auth' => 'WAS24957', 'action_taken' => 'Monitored system and performed detailed check', 'performed_by_name' => 'EAS Engineering','performed_by_auth' => 'WAS24957', 'deferral' => 'No',  'mel_ref' => '-',         'mel_repair_category' => '-', 'mel_expiry_date' => '-',           'reason_for_deferral' => '-', 'part_number' => '-',           'qty' => '-','description_short' => '-',                'remarks' => '-',          'defect_category' => 'Non-Safety related item'],
                    ['type' => 'MAREP', 'tone' => 'red',   'date' => '14 May 2025', 'time' => '14:30', 'aircraft_hours' => '1,201', 'aircraft_cycles' => '602', 'aa_no' => 'A.A.-25425', 'description' => 'APU oil consumption above normal limits', 'reported_by_name' => 'EAS Tech Ops', 'reported_by_auth' => 'WAS12345', 'action_taken' => 'Performed APU oil change and trend analysis', 'performed_by_name' => 'EAS Tech Ops',  'performed_by_auth' => 'WAS12345', 'deferral' => 'Yes', 'mel_ref' => '49-31-01', 'mel_repair_category' => 'B', 'mel_expiry_date' => '15 Jun 2025', 'reason_for_deferral' => '-', 'part_number' => '360-9876-00', 'qty' => 1, 'description_short' => 'Oil Filter', 'remarks' => 'APU', 'defect_category' => 'MEL Item - non-flight crew/maint action'],
                    ['type' => 'PIREP', 'tone' => 'amber', 'date' => '08 May 2025', 'time' => '11:20', 'aircraft_hours' => '1,108', 'aircraft_cycles' => '551', 'aa_no' => 'A.A.-26929', 'description' => 'Tire tread wear indicator approaching limit',          'reported_by_name' => 'Flight Crew',     'reported_by_auth' => 'WAS23456', 'action_taken' => 'Tire replaced',                                  'performed_by_name' => 'EAS Tech Ops',  'performed_by_auth' => 'WAS12345', 'deferral' => 'Yes', 'mel_ref' => '32-51-08', 'mel_repair_category' => 'C', 'mel_expiry_date' => '-',           'reason_for_deferral' => '-', 'part_number' => '600-1234-05', 'qty' => 1, 'description_short' => 'Tire Assy', 'remarks' => 'NLG #2',  'defect_category' => 'MEL Item - mech action required'],
                ],
            ],

            'work_package' => [
                'packages' => [
                    ['no' => 'WABCD/1234/0108', 'description' => 'DT31-01 CPLT DIGITAL CLOCK BATTERY (24M)', 'status' => 'OPEN',    'prepared_by' => 'JENNY DEPP',   'start_date' => '20 Apr 2026', 'start_time' => '08:00', 'inspector_name' => 'MO SALAH',     'inspector_auth' => 'WAS12345', 'tech_name' => 'ALI KHAN',      'end_date' => '21 Apr 2026', 'end_time' => '17:00'],
                    ['no' => 'WABCD/1234/0105', 'description' => 'CENTRAL MAINTENANCE SYSTEM (CMS)',         'status' => 'OPEN',    'prepared_by' => 'LOUIS BUTTON', 'start_date' => '18 Apr 2026', 'start_time' => '09:00', 'inspector_name' => 'PIERRE',       'inspector_auth' => 'WAS54321', 'tech_name' => 'AHMED RAZI',    'end_date' => '19 Apr 2026', 'end_time' => '16:00'],
                    ['no' => 'WABCD/1234/0104', 'description' => 'AW139 ACCP 1 WEEK',                        'status' => 'OPEN',    'prepared_by' => 'MO SALAH',     'start_date' => '16 Apr 2026', 'start_time' => '08:30', 'inspector_name' => 'LOUIS BUTTON', 'inspector_auth' => 'WAS12345', 'tech_name' => 'RAHUL SINGH',  'end_date' => '17 Apr 2026', 'end_time' => '15:30'],
                    ['no' => 'WABCD/1234/0103', 'description' => 'BIOBOR JF TREATMENT',                      'status' => 'PLANNED', 'prepared_by' => 'PIERRE',       'start_date' => '28 Apr 2026', 'start_time' => '07:00', 'inspector_name' => 'JENNY DEPP',   'inspector_auth' => 'WAS67890', 'tech_name' => 'KUMARAN',      'end_date' => '30 Apr 2026', 'end_time' => '14:00'],
                    ['no' => 'WABCD/1234/0099', 'description' => 'ENGINE WASH - CFM56',                      'status' => 'PLANNED', 'prepared_by' => 'JANE DOE',     'start_date' => '10 May 2026', 'start_time' => '06:30', 'inspector_name' => 'MO SALAH',     'inspector_auth' => 'WAS12345', 'tech_name' => 'IMRAN HAKIM',  'end_date' => '12 May 2026', 'end_time' => '13:00'],
                    ['no' => 'WABCD/1234/0090', 'description' => 'CABIN DEEP CLEANING',                      'status' => 'OPEN',    'prepared_by' => 'JOHN SMITH',   'start_date' => '23 Apr 2026', 'start_time' => '10:00', 'inspector_name' => 'LOUIS BUTTON', 'inspector_auth' => 'WAS54321', 'tech_name' => 'PRIYA NAIR',   'end_date' => '23 Apr 2026', 'end_time' => '18:00'],
                    ['no' => 'WABCD/1234/0085', 'description' => 'APU 100 HRS INSPECTION',                   'status' => 'CLOSED',  'prepared_by' => 'TECH OPS',     'start_date' => '01 Apr 2026', 'start_time' => '07:00', 'inspector_name' => 'PIERRE',       'inspector_auth' => 'WAS67890', 'tech_name' => 'RAVI KUMAR',   'end_date' => '03 Apr 2026', 'end_time' => '14:00'],
                    ['no' => 'WABCD/1234/0072', 'description' => 'HYDRAULIC SYSTEM LEAK CHECK',              'status' => 'CLOSED',  'prepared_by' => 'TECH OPS',     'start_date' => '01 Apr 2026', 'start_time' => '08:00', 'inspector_name' => 'JENNY DEPP',   'inspector_auth' => 'WAS12345', 'tech_name' => 'SURESH',       'end_date' => '01 Apr 2026', 'end_time' => '12:00'],
                ],
                'selected_pkg_no' => 'WABCD/1234/0108',
                'selected_pkg_label' => 'WABCD/1234/0108 - DT31-01 CPLT DIGITAL CLOCK BATTERY (24M)',
                'orders' => [
                    ['no' => 'WO-12349', 'type' => 'AD',          'description' => 'EASA AD 2019-0121 PARA A.2',          'status' => 'OPEN',    'prepared_by' => 'JENNY DEPP',   'start_date' => '21 Apr 2026', 'due' => '21 Apr 2026',          'completed' => '-',           'action_by_name' => 'MO SALAH',    'action_by_auth' => 'WAS12345', 'verified_by_name' => 'LOUIS BUTTON', 'verified_by_auth' => 'WAS54321'],
                    ['no' => 'WO-12348', 'type' => 'EOAS',        'description' => 'EOAS 366 - AW139 HYDRAULIC FLUID SERVICE','status' => 'PLANNED', 'prepared_by' => 'LOUIS BUTTON', 'start_date' => '18 Apr 2026', 'due' => '19 Apr 2026 / 600 FH', 'completed' => '-',           'action_by_name' => 'PIERRE',      'action_by_auth' => 'WAS67890', 'verified_by_name' => 'JENNY DEPP',   'verified_by_auth' => 'WAS12345'],
                    ['no' => 'WO-12347', 'type' => 'Repair Order','description' => 'COMPONENT RECERTIFICATION PROCESS',    'status' => 'OPEN',    'prepared_by' => 'MO SALAH',     'start_date' => '16 Apr 2026', 'due' => '17 Apr 2026',          'completed' => '-',           'action_by_name' => 'MO SALAH',    'action_by_auth' => 'WAS12345', 'verified_by_name' => 'PIERRE',       'verified_by_auth' => 'WAS67890'],
                    ['no' => 'WO-12346', 'type' => 'Check',       'description' => '150HRS',                              'status' => 'PLANNED', 'prepared_by' => 'PIERRE',       'start_date' => '20 Apr 2026', 'due' => '20 Apr 2026 / 150 FH', 'completed' => '-',           'action_by_name' => 'JENNY DEPP',  'action_by_auth' => 'WAS12345', 'verified_by_name' => 'LOUIS BUTTON', 'verified_by_auth' => 'WAS54321'],
                    ['no' => 'WO-12345', 'type' => 'OOP',         'description' => '25 Hrs or 7 Days ACCP',               'status' => 'CLOSED',  'prepared_by' => 'TECH OPS',     'start_date' => '02 May 2026', 'due' => '02 May 2026 / 25 FH',  'completed' => '02 May 2026 / 25 FH','action_by_name' => 'TECH OPS','action_by_auth' => 'WAS99999','verified_by_name' => 'MO SALAH',     'verified_by_auth' => 'WAS12345'],
                ],
            ],

            'journey_logs' => [
                'rows' => [
                    ['no' => '012893', 'date' => '08 Apr 2018', 'time' => '10:13', 'sectors' => 2, 'total_fh_before' => '12,580.54', 'total_fc_before' => '16,453', 'total_fh' => '+1:25', 'total_fc' => '+2', 'total_engine_start' => '+1', 'total_apu_hours' => '+0:25', 'total_fh_after' => '12,581.79', 'total_fc_after' => '16,455', 'status' => 'Closed', 'penalties' => 'Weight > 6.47',     'defect_raised' => 2, 'selected' => true],
                    ['no' => '012892', 'date' => '07 Apr 2018', 'time' => '15:40', 'sectors' => 2, 'total_fh_before' => '12,578.39', 'total_fc_before' => '16,451', 'total_fh' => '+2:15', 'total_fc' => '+2', 'total_engine_start' => '+1', 'total_apu_hours' => '+0:40', 'total_fh_after' => '12,580.54', 'total_fc_after' => '16,453', 'status' => 'Closed', 'penalties' => 'START/STOP 30 < V < 45', 'defect_raised' => 1],
                    ['no' => '012891', 'date' => '06 Apr 2018', 'time' => '09:30', 'sectors' => 3, 'total_fh_before' => '12,576.34', 'total_fc_before' => '16,448', 'total_fh' => '+3:05', 'total_fc' => '+3', 'total_engine_start' => '+2', 'total_apu_hours' => '+1:05', 'total_fh_after' => '12,578.39', 'total_fc_after' => '16,451', 'status' => 'Closed', 'penalties' => 'Weight > 6.47, CAT A TRG', 'defect_raised' => 3],
                    ['no' => '012890', 'date' => '05 Apr 2018', 'time' => '11:05', 'sectors' => 1, 'total_fh_before' => '12,573.74', 'total_fc_before' => '16,447', 'total_fh' => '+1:40', 'total_fc' => '+1', 'total_engine_start' => '+1', 'total_apu_hours' => '+0:30', 'total_fh_after' => '12,575.34', 'total_fc_after' => '16,448', 'status' => 'Closed', 'penalties' => '-',                  'defect_raised' => 0],
                    ['no' => '012889', 'date' => '04 Apr 2018', 'time' => '14:25', 'sectors' => 2, 'total_fh_before' => '12,571.24', 'total_fc_before' => '16,445', 'total_fh' => '+2:50', 'total_fc' => '+2', 'total_engine_start' => '+1', 'total_apu_hours' => '+0:50', 'total_fh_after' => '12,573.74', 'total_fc_after' => '16,447', 'status' => 'Closed', 'penalties' => 'CAT A TRG',          'defect_raised' => 2],
                    ['no' => '012888', 'date' => '03 Apr 2018', 'time' => '16:05', 'sectors' => 2, 'total_fh_before' => '12,568.99', 'total_fc_before' => '16,443', 'total_fh' => '+2:10', 'total_fc' => '+2', 'total_engine_start' => '+1', 'total_apu_hours' => '+0:35', 'total_fh_after' => '12,571.24', 'total_fc_after' => '16,445', 'status' => 'Closed', 'penalties' => '-',                  'defect_raised' => 1],
                    ['no' => '012887', 'date' => '02 Apr 2018', 'time' => '08:20', 'sectors' => 3, 'total_fh_before' => '12,565.68', 'total_fc_before' => '16,441', 'total_fh' => '+2:50', 'total_fc' => '+3', 'total_engine_start' => '+1', 'total_apu_hours' => '+0:40', 'total_fh_after' => '12,568.99', 'total_fc_after' => '16,443', 'status' => 'Closed', 'penalties' => 'Weight > 6.47',     'defect_raised' => 1],
                ],
                'selected_log_no' => '012893',
                'selected_log' => [
                    'flight_details' => [
                        'flight_no'        => 'TKB103',
                        'from'             => 'KCH',
                        'to'               => 'KCH',
                        'rotor_start'      => '10:33',
                        'duration'         => '01:25',
                        'sectors'          => 2,
                        'landing'          => '10:58',
                        'rotor_stop'       => '12:05',
                        'engine_start'     => 1,
                        'landings'         => 1,
                        'arrival_fuel'     => true,
                    ],
                    'pic' => [
                        'rank_name'             => '370 KG',
                        'service_license_number' => '123456789',
                    ],
                    'fuel_log' => [
                        'remaining_fuel_unloaded' => '370 KG',
                        'fuel_uplifted'           => '830 KG',
                        'total_fuel'              => '1,208 KG',
                        'eng1' => 'NIL', 'eng2' => 'NIL', 'mge' => 'NIL', 'tge' => 'NIL', 'idg' => 'NIL', 'rtu1' => 'NIL',
                    ],
                    'aircraft_rate' => [
                        'sfb' => true, 'cat1' => false, 'cat2' => false,
                    ],
                    'crs' => [
                        'aircraft_basic_weight' => '4604.15',
                        'aircraft_up_weight'    => '6044.15',
                        'rank_name'             => 'HAMDAN',
                        'authority_no'          => 'WAS228',
                        'time'                  => '07:00',
                    ],
                    'maint_supervisor' => [
                        'rank_name'    => 'HAFIDZ H.',
                        'authority_no' => 'WAS226',
                        'time'         => '07:10',
                    ],
                    'pre_flight' => [
                        ['description' => 'Check A (Pre-flight)', 'name' => 'MO SALAH', 'authority_no' => 'WAS12345', 'date' => '08 Apr 2018', 'time' => '07:10'],
                        ['description' => 'Check C (Turn around)','name' => 'HAMDAN',  'authority_no' => 'WAS228',   'date' => '08 Apr 2018', 'time' => '10:00'],
                    ],
                    'next_due' => [
                        'type_of_maintenance' => '25HRS INSP',
                        'due_at_flight_hours' => '12504:30',
                        'due_at_date'         => '-',
                    ],
                    'daily_maint' => [
                        ['description' => 'Check B (After Last Flight / Airworthiness Check)', 'authority_no' => 'WAS123', 'date' => '08 Apr 2018', 'time' => '19:30'],
                    ],
                    'defects' => [
                        ['no' => 1, 'tone' => 'red',   'type' => 'MAREP', 'description' => 'Spoiler actuator leaking hydraulic fluid', 'reported_by_name' => 'EAS Tech Ops',   'reported_by_auth' => 'WAS12345', 'action_taken' => 'Replaced right outboard spoiler actuator',     'performed_by_name' => 'EAS Tech Ops',   'performed_by_auth' => 'WAS12345', 'deferral' => 'Yes', 'mel_ref' => '25-21-01', 'mel_repair_category' => 'C', 'mel_expiry_date' => '-',           'reason_for_deferral' => '-', 'part_number' => 'S60-1234-01', 'qty' => 1, 'description_short' => 'Actuator Assy', 'remarks' => 'R/O Spoiler', 'defect_category' => 'MEL Item - mech action required'],
                        ['no' => 2, 'tone' => 'amber', 'type' => 'PIREP', 'description' => 'Nose gear torque link shows minor crack near bushing', 'reported_by_name' => 'Flight Crew', 'reported_by_auth' => 'WAS22056', 'action_taken' => 'Replaced nose gear torque link',                'performed_by_name' => 'EAS Tech Ops',   'performed_by_auth' => 'WAS12345', 'deferral' => 'Yes', 'mel_ref' => '32-11-09', 'mel_repair_category' => 'B', 'mel_expiry_date' => '08 May 2025', 'reason_for_deferral' => '-', 'part_number' => '321-1678-01', 'qty' => 1, 'description_short' => 'Torque Link Assy', 'remarks' => 'NLG', 'defect_category' => 'MEL Item - planning required'],
                        ['no' => 3, 'tone' => 'gray',  'type' => 'INFO',  'description' => 'Air conditioning pack flow slightly reduced',         'reported_by_name' => 'EAS Engineering','reported_by_auth' => 'WAS24957', 'action_taken' => 'Monitored system and performed detailed check', 'performed_by_name' => 'EAS Engineering','performed_by_auth' => 'WAS24957', 'deferral' => 'No',  'mel_ref' => '-',         'mel_repair_category' => '-', 'mel_expiry_date' => '-',           'reason_for_deferral' => '-', 'part_number' => '-',           'qty' => '-','description_short' => '-',                'remarks' => '-',          'defect_category' => 'Non-Safety related item'],
                    ],
                ],
            ],

            'events' => [
                'rows' => [
                    ['id' => 'EVT-000198', 'type' => 'Component Installation',         'category' => 'Technical',     'description' => 'Installation of Engine 1 (CFM56-5B4/3)',          'date' => '22 May 2025', 'time' => '09:45', 'performed_by' => 'WO SALAH',         'reference' => 'WO-12349'],
                    ['id' => 'EVT-000197', 'type' => 'Applied Configuration Update',   'category' => 'Technical',     'description' => 'Configuration update applied: STD 3.2',           'date' => '22 May 2025', 'time' => '08:30', 'performed_by' => 'HAMDAN',           'reference' => 'CONF-STD-3.2'],
                    ['id' => 'EVT-000196', 'type' => 'Visit Application',              'category' => 'Maintenance',   'description' => 'A Check Visit Applied',                            'date' => '21 May 2025', 'time' => '16:10', 'performed_by' => 'EAS Tech Ops',     'reference' => 'VA-2025-0456'],
                    ['id' => 'EVT-000195', 'type' => 'Technical Publication Embodiment','category' => 'Technical',    'description' => 'AD 2023-10-05 Embodiment',                         'date' => '21 May 2025', 'time' => '11:20', 'performed_by' => 'EAS Engineering',  'reference' => 'AD 2023-10-05'],
                    ['id' => 'EVT-000194', 'type' => 'Task Application',                'category' => 'Maintenance',  'description' => '25HRS Insp Task Card Applied',                     'date' => '20 May 2025', 'time' => '07:50', 'performed_by' => 'WAS12345',         'reference' => 'TSK-25HRS-001'],
                    ['id' => 'EVT-000193', 'type' => 'Component Uninstallation',        'category' => 'Technical',    'description' => 'Removal of APU (GTCP36-150)',                      'date' => '19 May 2025', 'time' => '18:40', 'performed_by' => 'HAMDAN',           'reference' => 'WO-12340'],
                    ['id' => 'EVT-000192', 'type' => 'Change of Aircraft Status',       'category' => 'Operational',  'description' => 'Aircraft status changed to "MEL"',                'date' => '19 May 2025', 'time' => '17:15', 'performed_by' => 'EAS Tech Ops',     'reference' => 'MEL-2025-0078'],
                    ['id' => 'EVT-000191', 'type' => 'Airworthiness Review',            'category' => 'Airworthiness','description' => 'Airworthiness Review Certificate Issued',         'date' => '18 May 2025', 'time' => '12:00', 'performed_by' => 'EAS CAMO',         'reference' => 'ARC-2025-051'],
                    ['id' => 'EVT-000190', 'type' => 'Service Bulletin Embodiment',     'category' => 'Technical',    'description' => 'SB A320-27-1234 Embodiment',                       'date' => '18 May 2025', 'time' => '09:30', 'performed_by' => 'EAS Engineering',  'reference' => 'SB-A320-27-1234'],
                    ['id' => 'EVT-000189', 'type' => 'Mandatory Modification',          'category' => 'Technical',    'description' => 'Mod 123456 Incorporation',                         'date' => '17 May 2025', 'time' => '14:25', 'performed_by' => 'EAS Engineering',  'reference' => 'MOD-123456'],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function a6Eas(): array
    {
        $base = self::a6Atp();

        return array_merge($base, [
            'registration' => 'A6-EAS',
            'msn'          => '5678',
            'status'       => 'Active',
            'identity' => array_merge($base['identity'], [
                'aircraft_type'    => 'A320-251N',
                'delivery_date'    => '12 Mar 2018',
                'configuration'    => 'C12 Y162',
                'base'             => 'DXB',
                'maintenance_plan' => 'A320 NEO AMM ISS 4 REV 2',
                'owner'            => 'Eastmoon Aviation',
                'operator'         => 'Eastmoon Aviation Services Sdn Bhd',
            ]),
            'utilization' => [
                'avg_fh_per_day' => 6.45,
                'avg_fc_per_day' => 3.78,
                'fh_series'      => [5.2, 5.5, 5.8, 6.0, 6.1, 6.3, 6.5, 6.4, 6.2, 6.0, 6.1, 6.3, 6.5, 6.6, 6.4, 6.2, 6.3, 6.5, 6.6, 6.4, 6.2, 6.4, 6.5, 6.6, 6.4, 6.5, 6.7, 6.5, 6.4, 6.45],
                'fc_series'      => [2.9, 3.0, 3.1, 3.3, 3.5, 3.6, 3.7, 3.8, 3.6, 3.5, 3.6, 3.7, 3.8, 3.9, 3.7, 3.6, 3.7, 3.8, 3.9, 3.7, 3.6, 3.7, 3.8, 3.9, 3.7, 3.8, 3.9, 3.8, 3.7, 3.78],
            ],
            'general' => array_merge($base['general'], [
                'lifecycle' => [
                    'date_of_manufacture' => '12 Mar 2018',
                    'entry_into_service'  => '15 Mar 2018',
                    'date_of_acquisition' => '01 Mar 2018',
                    'acquisition_cost'    => '52,300,000.00',
                    'currency'            => 'USD',
                ],
                'registration' => [
                    'aircraft_registration' => 'A6-EAS',
                    'state_of_registry'     => 'United Arab Emirates',
                    'coa_issue_date'        => '12 Mar 2018',
                    'coa_expiry_date'       => '11 Mar 2028',
                    'airworthiness_authority' => 'GCAA - General Civil Aviation Authority',
                ],
                'manufacturer' => [
                    'manufacturer'             => 'AIRBUS',
                    'aircraft_model'           => 'A320-251N',
                    'manufacturer_serial_number' => '5678',
                    'line_number'              => '7892',
                ],
                'powerplant' => [
                    'engine_type'         => 'PW1127G-JM',
                    'engine_manufacturer' => 'Pratt & Whitney',
                    'number_of_engines'   => 2,
                    'apu_installed'       => true,
                ],
            ]),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private static function a6Wsa(): array
    {
        $base = self::a6Atp();

        return array_merge($base, [
            'registration' => 'A6-WSA',
            'msn'          => '9012',
            'status'       => 'MEL',
            'identity' => array_merge($base['identity'], [
                'aircraft_type'    => 'A321-271N',
                'delivery_date'    => '03 Jun 2020',
                'configuration'    => 'C20 Y180',
                'base'             => 'AUH',
                'maintenance_plan' => 'A321 NEO AMM ISS 3 REV 1',
                'owner'            => 'Eastmoon Aviation',
                'operator'         => 'Eastmoon Aviation Services Sdn Bhd',
            ]),
            'utilization' => [
                'avg_fh_per_day' => 4.92,
                'avg_fc_per_day' => 2.61,
                'fh_series'      => [3.8, 4.0, 4.2, 4.5, 4.7, 4.8, 5.0, 5.1, 4.9, 4.8, 4.9, 5.0, 5.1, 5.0, 4.9, 4.8, 4.9, 5.0, 5.1, 5.0, 4.9, 5.0, 5.1, 5.0, 4.9, 5.0, 5.1, 5.0, 4.9, 4.92],
                'fc_series'      => [2.0, 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.5, 2.4, 2.5, 2.6, 2.7, 2.6, 2.5, 2.4, 2.5, 2.6, 2.7, 2.6, 2.5, 2.6, 2.7, 2.6, 2.5, 2.6, 2.7, 2.6, 2.5, 2.61],
            ],
            'general' => array_merge($base['general'], [
                'lifecycle' => [
                    'date_of_manufacture' => '03 Jun 2020',
                    'entry_into_service'  => '10 Jun 2020',
                    'date_of_acquisition' => '01 Jun 2020',
                    'acquisition_cost'    => '61,800,000.00',
                    'currency'            => 'USD',
                ],
                'registration' => [
                    'aircraft_registration' => 'A6-WSA',
                    'state_of_registry'     => 'United Arab Emirates',
                    'coa_issue_date'        => '03 Jun 2020',
                    'coa_expiry_date'       => '02 Jun 2030',
                    'airworthiness_authority' => 'GCAA - General Civil Aviation Authority',
                ],
                'manufacturer' => [
                    'manufacturer'             => 'AIRBUS',
                    'aircraft_model'           => 'A321-271N',
                    'manufacturer_serial_number' => '9012',
                    'line_number'              => '9456',
                ],
                'powerplant' => [
                    'engine_type'         => 'PW1133G-JM',
                    'engine_manufacturer' => 'Pratt & Whitney',
                    'number_of_engines'   => 2,
                    'apu_installed'       => true,
                ],
            ]),
            // Bump some defects status to demonstrate MEL aircraft
            'overview' => array_merge($base['overview'], [
                'status_summary' => [
                    ['group' => 'Configuration Status',         'icon' => 'exclamation-triangle', 'tone' => 'red',    'count' => 18, 'label' => 'Uninstalled Component'],
                    ['group' => 'Maintenance Status',           'icon' => 'calendar-days',        'tone' => 'red',    'count' => 14, 'label' => 'Overdue'],
                    ['group' => 'Maintenance Planning Status',  'icon' => 'check-circle',         'tone' => 'green',  'count' => 0,  'label' => 'Due Within Alarm'],
                    ['group' => 'Maintenance Planning Status',  'icon' => 'bell',                 'tone' => 'red',    'count' => 6,  'label' => 'Overdue Without Work Package'],
                    ['group' => 'Technical Publications Status','icon' => 'document',             'tone' => 'amber',  'count' => 4,  'label' => 'Due Within Alarm Without Work Package'],
                    ['group' => 'Technical Publications Status','icon' => 'document',             'tone' => 'red',    'count' => 2,  'label' => 'Overdue Technical Publication Compliance'],
                    ['group' => 'Defects Status',               'icon' => 'document',             'tone' => 'red',    'count' => 5,  'label' => 'Open Defects (5 of 9)'],
                    ['group' => 'Defects Status',               'icon' => 'document',             'tone' => 'red',    'count' => 4,  'label' => 'Overdue Deferred Defects (MEL / CFD)'],
                ],
            ]),
        ]);
    }
}
