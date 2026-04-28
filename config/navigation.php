<?php

return [
    [
        'label' => 'Dashboard',
        'icon' => 'home',
        'children' => [
            ['label' => 'User Dashboard', 'route' => 'dashboard.user', 'icon' => 'user-circle'],
            ['label' => 'Fleet Dashboard', 'route' => 'dashboard.fleet', 'icon' => 'chart-bar'],
        ],
    ],
    [
        'label' => 'Administration',
        'icon' => 'badge-verified',
        'children' => [
            [
                'label' => 'User Management',
                'icon' => 'user-circle',
                'children' => [
                    ['label' => 'User', 'route' => 'system.user-management.index', 'icon' => 'user-circle'],
                    ['label' => 'User Groups', 'route' => 'admin.user-management.user-groups', 'icon' => 'id-card'],
                    ['label' => 'User Authorizations', 'route' => 'admin.user-management.user-authorizations', 'icon' => 'lock-closed'],
                ],
            ],
            [
                'label' => 'Stock Management',
                'icon' => 'archive-box',
                'children' => [
                    ['label' => 'Item Groups', 'route' => 'admin.stock-management.item-groups', 'icon' => 'queue-list'],
                    ['label' => 'Category Part', 'route' => 'admin.stock-management.category-part', 'icon' => 'squares-2x2'],
                    ['label' => 'Warehouses', 'route' => 'admin.stock-management.warehouses', 'icon' => 'archive-box'],
                ],
            ],
            [
                'label' => 'Fleet Management',
                'icon' => 'cube',
                'children' => [
                    ['label' => 'Technical Publication Type', 'route' => 'admin.fleet.technical-publication-type', 'icon' => 'document-text'],
                    ['label' => 'Status Management & Workflow', 'route' => 'admin.fleet.status-management-workflow', 'icon' => 'arrow-path'],
                    ['label' => 'Task Type', 'route' => 'admin.fleet.task-type', 'icon' => 'document-text'],
                    ['label' => 'Counters', 'route' => 'system.counter.index', 'icon' => 'chart-bar'],
                    ['label' => 'Penalties', 'route' => 'admin.fleet.penalties', 'icon' => 'exclamation-triangle'],
                ],
            ],
            [
                'label' => 'Flight Operations',
                'icon' => 'megaphone-solid',
                'children' => [
                    ['label' => 'Departure / Arrival Locations', 'route' => 'admin.flight-operations.departure-arrival-locations', 'icon' => 'map-pin'],
                ],
            ],
            [
                'label' => 'MRO Management',
                'icon' => 'mro-receipt',
                'children' => [
                    ['label' => 'Work Order Type', 'route' => 'admin.mro.work-order-type', 'icon' => 'briefcase'],
                    ['label' => 'Defect Type', 'route' => 'admin.mro.defect-type', 'icon' => 'exclamation-triangle'],
                    ['label' => 'Status Management & Workflow', 'route' => 'admin.mro.status-management-workflow', 'icon' => 'arrow-path'],
                ],
            ],
            [
                'label' => 'Utilities',
                'icon' => 'adjustments-horizontal',
                'children' => [
                    ['label' => 'Counter Synchronization', 'route' => 'admin.utilities.counter-synchronization', 'icon' => 'arrows-right-left'],
                    ['label' => 'Max Value Bulk Update', 'route' => 'admin.utilities.max-value-bulk-update', 'icon' => 'pencil-square'],
                    ['label' => 'FL Counters Bulk Update', 'route' => 'admin.utilities.fl-counters-bulk-update', 'icon' => 'pencil-square'],
                    ['label' => 'Customer Equipment Card Status Bulk Update', 'route' => 'admin.utilities.cec-status-bulk-update', 'icon' => 'pencil-square'],
                    ['label' => 'Change Customer Information', 'route' => 'admin.utilities.change-customer-information', 'icon' => 'identification'],
                    ['label' => 'Equipment Reference Evolution', 'route' => 'admin.utilities.equipment-reference-evolution', 'icon' => 'arrow-path'],
                ],
            ],
            ['label' => 'Settings', 'route' => 'system.settings', 'icon' => 'cog-6-tooth'],
        ],
    ],
    [
        'label' => 'Business Partners',
        'icon' => 'id-card',
        'children' => [
            [
                'label' => 'Business Partner Master Data',
                'route' => 'system.business-partner-master-data.index',
                'icon' => 'briefcase',
                'active_routes' => [
                    'system.business-partner-master-data.index',
                    'system.business-partner-master-data.create',
                    'system.business-partner-master-data.show',
                    'system.business-partner-master-data.edit',
                ],
            ],
        ],
    ],
    [
        'label' => 'Inventory',
        'icon' => 'archive-box',
        'children' => [
            [
                'label' => 'Item Master Data',
                'route' => 'system.item-master-data.index',
                'icon' => 'briefcase',
                'active_routes' => [
                    'system.item-master-data.index',
                    'system.item-master-data.create',
                    'system.item-master-data.show',
                    'system.item-master-data.edit',
                ],
            ],
        ],
    ],
    [
        'label' => 'Human Resources',
        'icon' => 'identification',
        'children' => [
            [
                'label' => 'Employee Master Data',
                'route' => 'hr.employee-master-data',
                'icon' => 'user-circle',
                'active_routes' => [
                    'hr.employee-master-data',
                    'hr.employee-master-data.show',
                    'hr.employee-master-data.edit',
                ],
            ],
        ],
    ],
    [
        'label' => 'Technical Data',
        'icon' => 'clipboard-document-list',
        'children' => [
            [
                'label' => 'Configuration Management',
                'icon' => 'squares-2x2',
                'children' => [
                    ['label' => 'Family', 'route' => 'technical-data.configuration-management.family', 'icon' => 'document-text'],
                    ['label' => 'Type', 'route' => 'technical-data.configuration-management.type', 'icon' => 'document-text'],
                    ['label' => 'Variant', 'route' => 'technical-data.configuration-management.variant', 'icon' => 'document-text'],
                    ['label' => 'Applicable Configuration', 'route' => 'technical-data.configuration-management.applicable-configuration', 'icon' => 'document-text'],
                ],
            ],
            ['label' => 'Technical Publications', 'route' => 'technical-data.technical-publications', 'icon' => 'document-text'],
            [
                'label' => 'Maintenance Program',
                'icon' => 'wrench-screwdriver',
                'children' => [
                    ['label' => 'Visit', 'route' => 'technical-data.maintenance-program.visit', 'icon' => 'calendar-days'],
                    ['label' => 'Task', 'route' => 'technical-data.maintenance-program.task', 'icon' => 'clipboard-document-list'],
                    ['label' => 'Maintenance Program Administration', 'route' => 'technical-data.maintenance-program.administration', 'icon' => 'clipboard-document-check'],
                ],
            ],
        ],
    ],
    [
        'label' => 'Fleet Management',
        'icon' => 'cube',
        'children' => [
            [
                'label' => 'Functional Location',
                'icon' => 'building-office-2',
                'children' => [
                    [
                        'label' => 'Functional Location Card',
                        'route' => 'fleet.functional-location.index',
                        'icon' => 'identification',
                        'active_routes' => [
                            'fleet.functional-location.index',
                            'fleet.functional-location.show',
                            'fleet.functional-location.edit',
                        ],
                    ],
                    ['label' => 'Attach equipment to functional location', 'route' => 'fleet.functional-location.attach-equipment', 'icon' => 'link'],
                    ['label' => 'Detach equipment from functional location', 'route' => 'fleet.functional-location.detach-equipment', 'icon' => 'scissors'],
                    ['label' => 'Configuration Control', 'route' => 'fleet.functional-location.configuration-control', 'icon' => 'squares-2x2'],
                    ['label' => 'Airworthiness Review', 'route' => 'fleet.functional-location.airworthiness-review', 'icon' => 'clipboard-document-check'],
                ],
            ],
            [
                'label' => 'Equipment',
                'icon' => 'cog-6-tooth',
                'children' => [
                    [
                        'label' => 'Equipment Card',
                        'route' => 'fleet.equipment.index',
                        'icon' => 'identification',
                        'active_routes' => [
                            'fleet.equipment.index',
                            'fleet.equipment.show',
                        ],
                    ],
                    ['label' => 'Attach Equipment', 'route' => 'fleet.equipment.attach-equipment', 'icon' => 'arrow-down-tray'],
                    ['label' => 'Detach Equipment', 'route' => 'fleet.equipment.detach-equipment', 'icon' => 'arrow-up-tray'],
                    ['label' => 'Swap Equipment', 'route' => 'fleet.equipment.swap-equipment', 'icon' => 'arrows-right-left'],
                ],
            ],
            [
                'label' => 'Technical Publications',
                'icon' => 'document-text',
                'children' => [
                    ['label' => 'Technical Publications Administration', 'route' => 'fleet.technical-publications.administration', 'icon' => 'clipboard-document-list'],
                    ['label' => 'Technical Publications Application', 'route' => 'fleet.technical-publications.application', 'icon' => 'clipboard-document-check'],
                ],
            ],
            [
                'label' => 'Maintenance Plan',
                'icon' => 'calendar-days',
                'children' => [
                    ['label' => 'Maintenance Plan Administration', 'route' => 'maintenance.maintenance-plan.administration', 'icon' => 'clipboard-document-list'],
                    ['label' => 'Utilisation Model', 'route' => 'fleet.maintenance-plan.utilisation-model', 'icon' => 'chart-bar'],
                    ['label' => 'Maintenance Planning', 'route' => 'fleet.maintenance-plan.maintenance-planning', 'icon' => 'clipboard-document-check'],
                    ['label' => 'Work Package', 'route' => 'maintenance.maintenance-plan.work-package', 'icon' => 'briefcase'],
                ],
            ],
            [
                'label' => 'Operational Inputs',
                'icon' => 'adjustments-horizontal',
                'children' => [
                    ['label' => 'Daily Updates', 'route' => 'operations.daily-updates', 'icon' => 'calendar-days'],
                    ['label' => 'Fleet Management Cockpit', 'route' => 'operations.fleet-management-cockpit', 'icon' => 'chart-bar'],
                    ['label' => 'Defects', 'route' => 'fleet.operational-inputs.defects', 'icon' => 'exclamation-triangle'],
                ],
            ],
            [
                'label' => 'Initialization',
                'icon' => 'arrow-path',
                'children' => [
                    ['label' => 'Apply Maintenance Program', 'route' => 'initialization.apply-maintenance-program', 'icon' => 'wrench-screwdriver'],
                    ['label' => 'Structure Duplication', 'route' => 'initialization.structure-duplication', 'icon' => 'document-text'],
                ],
            ],
        ],
    ],
    [
        'label' => 'Flight Recording',
        'icon' => 'megaphone-solid',
        'children' => [
            ['label' => 'Flight Details', 'route' => 'flight.flight-details', 'icon' => 'document-text'],
            ['label' => 'Technical Log', 'route' => 'flight.technical-log', 'icon' => 'clipboard-document-list'],
            ['label' => 'Defects', 'route' => 'flight.defects', 'icon' => 'exclamation-triangle'],
        ],
    ],
    [
        'label' => 'MRO Management',
        'icon' => 'mro-receipt',
        'children' => [
            ['label' => 'Work Package', 'route' => 'mro.work-package', 'icon' => 'briefcase'],
            ['label' => 'Work Order', 'route' => 'mro.work-order.index', 'icon' => 'briefcase'],
            [
                'label' => 'Time Tracking',
                'icon' => 'clock',
                'children' => [
                    ['label' => 'Time Sheet', 'route' => 'mro.time-sheet', 'icon' => 'clipboard-document-list'],
                ],
            ],
            ['label' => 'Defects', 'route' => 'mro.defects', 'icon' => 'exclamation-triangle'],
        ],
    ],
    [
        'label' => 'Reports',
        'icon' => 'chart-bar',
        'children' => [
            [
                'label' => 'Fleet Commercial Report',
                'icon' => 'chart-bar',
                'children' => [
                    ['label' => 'Equipment Reliability (Aero One)', 'route' => 'reports.fleet-commercial.equipment-reliability', 'icon' => 'document-text'],
                    ['label' => 'Equipment Utilization (Aero One)', 'route' => 'reports.fleet-commercial.equipment-utilization', 'icon' => 'document-text'],
                    ['label' => 'Monthly Aircraft Report (Aero One)', 'route' => 'reports.fleet-commercial.monthly-aircraft-report', 'icon' => 'document-text'],
                    ['label' => 'Monthly Engine Report (Aero One)', 'route' => 'reports.fleet-commercial.monthly-engine-report', 'icon' => 'document-text'],
                ],
            ],
            [
                'label' => 'Fleet Management Report',
                'icon' => 'clipboard-document-list',
                'children' => [
                    ['label' => 'Due List Report (CAMP)', 'route' => 'reports.fleet-management.due-list-report', 'icon' => 'document-text'],
                    ['label' => 'Life Limit / Overhaul Report (CAMP)', 'route' => 'reports.fleet-management.life-limit-overhaul-report', 'icon' => 'document-text'],
                    ['label' => 'Time Controlled Items Report (CAMP)', 'route' => 'reports.fleet-management.time-controlled-items-report', 'icon' => 'document-text'],
                    ['label' => 'Status Report (CAMP)', 'route' => 'reports.fleet-management.status-report', 'icon' => 'document-text'],
                    ['label' => 'Status Check (Aero One)', 'route' => 'reports.fleet-management.status-check', 'icon' => 'document-text'],
                    ['label' => 'ADSB Status (Aero One)', 'route' => 'reports.fleet-management.adsb-status', 'icon' => 'document-text'],
                    ['label' => 'Monthly Flight Hour (Aero One)', 'route' => 'reports.fleet-management.monthly-flight-hour', 'icon' => 'document-text'],
                ],
            ],
            [
                'label' => 'Time Tracking',
                'icon' => 'clock',
                'children' => [
                    ['label' => 'Personal experience', 'route' => 'reports.time-tracking.personal-experience', 'icon' => 'user-circle'],
                ],
            ],
        ],
    ],
    [
        'label'     => 'My Workspace',
        'icon'      => 'star',
        'workspace' => true,
    ],
];
