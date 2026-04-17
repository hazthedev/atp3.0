<?php

return [
    [
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'home',
    ],
    [
        'label' => 'Administration',
        'icon' => 'badge-verified',
        'children' => [
            ['label' => 'Functional Location Type', 'route' => 'system.aircraft-type.index'],
            ['label' => 'Counter', 'route' => 'system.counter.index', 'icon' => 'chart-bar'],
            ['label' => 'User Management', 'route' => 'system.user-management.index'],
            ['label' => 'Manage Status', 'route' => 'system.manage-status.index'],
            ['label' => 'Profile', 'route' => 'system.profile'],
            ['label' => 'Settings', 'route' => 'system.settings'],
            ['label' => 'Task Types', 'route' => 'system.tasks'],
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
                    'system.business-partner-master-data.edit',
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
                        'icon' => 'book-solid',
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
        'icon' => 'megaphone-solid',
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
        'icon' => 'mro-receipt',
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
        'icon' => 'book-solid',
    ],
];
