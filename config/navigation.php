<?php

return [
    [
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'home',
    ],
    [
        'label' => 'Administration',
        'icon' => 'cog-6-tooth',
        'children' => [
            [
                'label' => 'User Management',
                'icon' => 'user-circle',
                'children' => [
                    ['label' => 'User', 'route' => 'system.user-management.index', 'icon' => 'user-circle'],
                    ['label' => 'User Groups', 'route' => 'admin.user-management.user-groups', 'icon' => 'queue-list'],
                    ['label' => 'User Authorizations', 'route' => 'admin.user-management.user-authorizations', 'icon' => 'lock-closed'],
                ],
            ],
            [
                'label' => 'Stock Management',
                'icon' => 'archive-box',
                'children' => [
                    ['label' => 'Item Groups', 'route' => 'admin.stock-management.item-groups', 'icon' => 'queue-list'],
                    ['label' => 'Warehouses', 'route' => 'admin.stock-management.warehouses', 'icon' => 'archive-box'],
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
                            ['label' => 'Type', 'route' => 'system.aircraft-type.index', 'icon' => 'document-text'],
                        ],
                    ],
                    ['label' => 'I.P.C.', 'route' => 'admin.fleet.ipc', 'icon' => 'clipboard-document-list'],
                    [
                        'label' => 'Equipment',
                        'icon' => 'cog-6-tooth',
                        'children' => [
                            ['label' => 'Variant', 'route' => 'admin.fleet.equipment.variant', 'icon' => 'document-text'],
                        ],
                    ],
                    [
                        'label' => 'Modification',
                        'icon' => 'sparkles',
                        'children' => [
                            ['label' => 'Type', 'route' => 'admin.fleet.modification.type', 'icon' => 'document-text'],
                        ],
                    ],
                    [
                        'label' => 'Maintenance Program',
                        'icon' => 'wrench-screwdriver',
                        'children' => [
                            ['label' => 'Visit', 'route' => 'admin.fleet.maintenance-program.visit', 'icon' => 'calendar-days'],
                            ['label' => 'Utilization Model', 'route' => 'admin.fleet.maintenance-program.utilization-model', 'icon' => 'chart-bar'],
                        ],
                    ],
                    ['label' => 'Counters', 'route' => 'system.counter.index', 'icon' => 'chart-bar'],
                    ['label' => 'Penalties', 'route' => 'admin.fleet.penalties', 'icon' => 'exclamation-triangle'],
                ],
            ],
            [
                'label' => 'Flight Operations',
                'icon' => 'map-pin',
                'children' => [
                    ['label' => 'Departure / Arrival Locations', 'route' => 'admin.flight-operations.departure-arrival-locations', 'icon' => 'map-pin'],
                ],
            ],
            [
                'label' => 'MRO Management',
                'icon' => 'wrench-screwdriver',
                'children' => [
                    ['label' => 'Task Type', 'route' => 'system.tasks', 'icon' => 'document-text'],
                    ['label' => 'Work Order Type', 'route' => 'admin.mro.work-order-type', 'icon' => 'briefcase'],
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
                ],
            ],
            ['label' => 'Settings', 'route' => 'system.settings', 'icon' => 'cog-6-tooth'],
        ],
    ],
    [
        'label' => 'Business Partners',
        'icon' => 'identification',
        'children' => [
            [
                'label' => 'Business Partner Master Data',
                'route' => 'system.business-partner-master-data.index',
                'icon' => 'briefcase',
                'active_routes' => [
                    'system.business-partner-master-data.index',
                    'system.business-partner-master-data.create',
                    'system.business-partner-master-data.edit',
                ],
            ],
        ],
    ],
    [
        'label' => 'Human Resources',
        'icon' => 'identification',
        'children' => [
            ['label' => 'Employee Master Data', 'route' => 'hr.employee-master-data', 'icon' => 'user-circle'],
        ],
    ],
    [
        'label' => 'Fleet Management',
        'icon' => 'cube',
        'children' => [
            [
                'label' => 'Functional Location',
                'icon' => 'squares-2x2',
                'children' => [
                    [
                        'label' => 'Customer Functional Location',
                        'route' => 'fleet.functional-location.index',
                        'icon' => 'building-office-2',
                        'active_routes' => [
                            'fleet.functional-location.index',
                            'fleet.functional-location.show',
                            'fleet.functional-location.edit',
                        ],
                    ],
                    ['label' => 'Attach equipment to functional location', 'route' => 'fleet.functional-location.attach-equipment', 'icon' => 'link'],
                    ['label' => 'Detach equipment from functional location', 'route' => 'fleet.functional-location.detach-equipment', 'icon' => 'scissors'],
                    ['label' => 'Change customer information', 'route' => 'fleet.functional-location.change-customer-information', 'icon' => 'identification'],
                ],
            ],
            [
                'label' => 'Equipment',
                'icon' => 'cog-6-tooth',
                'children' => [
                    [
                        'label' => 'Customer Equipment Card',
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
                    ['label' => 'Change customer information', 'route' => 'fleet.equipment.change-customer-information', 'icon' => 'user-circle'],
                ],
            ],
            [
                'label' => 'Modification',
                'icon' => 'sparkles',
                'children' => [
                    [
                        'label' => 'Modification',
                        'route' => 'fleet.modification.index',
                        'icon' => 'document-text',
                        'active_routes' => [
                            'fleet.modification.index',
                            'fleet.modification.show',
                        ],
                    ],
                    ['label' => 'Apply Modifications to a Functional Location', 'route' => 'fleet.modification.apply-on-functional-location', 'icon' => 'map-pin'],
                    ['label' => 'Apply Modifications to an Equipment', 'route' => 'fleet.modification.apply-on-equipment', 'icon' => 'wrench-screwdriver'],
                    ['label' => 'Equipment Reference Evolution', 'route' => 'fleet.modification.equipment-reference-evolution', 'icon' => 'arrow-path'],
                ],
            ],
            [
                'label' => 'Maintenance Program',
                'icon' => 'wrench-screwdriver',
                'children' => [
                    [
                        'label' => 'Maintenance Program',
                        'route' => 'fleet.maintenance.maintenance-program',
                        'icon' => 'document-text',
                    ],
                    [
                        'label' => 'Maintenance Plan',
                        'icon' => 'calendar-days',
                        'children' => [
                            [
                                'label' => 'Maintenance Plan Administration',
                                'route' => 'maintenance.maintenance-plan.administration',
                                'icon' => 'clipboard-document-list',
                            ],
                            [
                                'label' => 'WorkPackage',
                                'route' => 'maintenance.maintenance-plan.work-package',
                                'icon' => 'briefcase',
                            ],
                            [
                                'label' => 'Apply Visit and Task List',
                                'route' => 'maintenance.maintenance-plan.apply-visit',
                                'icon' => 'clipboard-document-check',
                                'active_routes' => [
                                    'maintenance.maintenance-plan.apply-visit',
                                    'maintenance.maintenance-plan.apply-task-list',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Operational Inputs',
                'icon' => 'adjustments-horizontal',
                'children' => [
                    ['label' => 'Daily Updates', 'route' => 'operations.daily-updates', 'icon' => 'calendar-days'],
                    ['label' => 'Fleet Management Cockpit', 'route' => 'operations.fleet-management-cockpit', 'icon' => 'chart-bar'],
                    ['label' => 'List of Technical Logs', 'route' => 'operations.technical-logs', 'icon' => 'clipboard-document-list'],
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
        'label' => 'Flight Operations',
        'icon' => 'map-pin',
        'children' => [
            [
                'label' => 'Flight Records',
                'icon' => 'clipboard-document-list',
                'children' => [
                    ['label' => 'Flight Details', 'route' => 'flight.flight-details', 'icon' => 'document-text'],
                    ['label' => 'Daily Flight Log', 'route' => 'flight.daily-flight-log', 'icon' => 'clipboard-document-list'],
                ],
            ],
        ],
    ],
    [
        'label' => 'MRO Management',
        'icon' => 'wrench-screwdriver',
        'children' => [
            [
                'label' => 'Repair Information Cockpit',
                'icon' => 'information-circle',
                'children' => [
                    ['label' => 'Search Repair Information Cockpit', 'route' => 'mro.repair-information.search', 'icon' => 'magnifying-glass'],
                    ['label' => 'Repair Information Cockpit', 'route' => 'mro.repair-information.index', 'icon' => 'clipboard-document-list'],
                    ['label' => 'List of Open Repairs', 'route' => 'mro.repair-information.open-repairs', 'icon' => 'clock'],
                    ['label' => 'Calendar View', 'route' => 'mro.repair-information.calendar-view', 'icon' => 'chart-bar'],
                ],
            ],
            ['label' => 'Task', 'route' => 'mro.task-list.index', 'icon' => 'clipboard-document-list'],
            [
                'label' => 'Work Order',
                'icon' => 'briefcase',
                'children' => [
                    ['label' => 'List of Technical Logs', 'route' => 'mro.work-order.technical-logs', 'icon' => 'document-text'],
                    ['label' => 'List of Open Work Order', 'route' => 'mro.work-order.index', 'icon' => 'clipboard-document-list'],
                    ['label' => 'Work Order', 'route' => 'mro.work-order.detail', 'icon' => 'briefcase'],
                ],
            ],
            [
                'label' => 'Time Tracking',
                'icon' => 'clock',
                'children' => [
                    ['label' => 'Time Sheet', 'route' => 'mro.time-sheet', 'icon' => 'clipboard-document-list'],
                    ['label' => 'Start Operation', 'route' => 'mro.start-operation', 'icon' => 'plus'],
                    ['label' => 'End Operation', 'route' => 'mro.end-operation', 'icon' => 'check-circle'],
                ],
            ],
        ],
    ],
    [
        'label' => 'Reports',
        'icon' => 'chart-bar',
        'children' => [
            ['label' => 'Fleet Synthesis', 'route' => 'reports.fleet-synthesis', 'icon' => 'chart-bar'],
            ['label' => 'Fleet Report', 'route' => 'reports.fleet-report', 'icon' => 'document-text'],
            ['label' => 'Time Tracking', 'route' => 'reports.time-tracking', 'icon' => 'clock'],
        ],
    ],
    [
        'label' => 'Lookups',
        'route' => 'lookups.index',
        'icon' => 'magnifying-glass',
    ],
];
