<?php

return [
    [
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'home',
    ],
    [
        'label' => 'Business Partners',
        'icon' => 'users',
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
        'icon' => 'plane',
        'children' => [
            [
                'label' => 'Functional Location',
                'icon' => 'squares-2x2',
                'children' => [
                    [
                        'label' => 'Search Functional Locations',
                        'route' => 'fleet.functional-location.index',
                        'icon' => 'magnifying-glass',
                        'active_routes' => [
                            'fleet.functional-location.index',
                            'fleet.functional-location.search',
                        ],
                    ],
                    [
                        'label' => 'Customer Functional Location',
                        'route' => 'fleet.functional-location.customer',
                        'icon' => 'building-office-2',
                        'active_routes' => [
                            'fleet.functional-location.customer',
                            'fleet.functional-location.show',
                            'fleet.functional-location.edit',
                        ],
                    ],
                    ['label' => 'Attach equipment to functional location', 'route' => 'fleet.functional-location.attach-equipment', 'icon' => 'link'],
                    ['label' => 'Detach equipment from functional location', 'route' => 'fleet.functional-location.detach-equipment', 'icon' => 'scissors'],
                    ['label' => 'Change customer information', 'route' => 'fleet.functional-location.change-customer-information', 'icon' => 'identification'],
                    ['label' => 'Pending Installed Base updates from Work Orders', 'route' => 'fleet.functional-location.pending-installed-base-updates-from-work-orders', 'icon' => 'queue-list'],
                ],
            ],
            [
                'label' => 'Equipment',
                'icon' => 'cog-6-tooth',
                'children' => [
                    ['label' => 'Search Equipments', 'route' => 'fleet.equipment.index', 'icon' => 'magnifying-glass'],
                    ['label' => 'Components Monitoring', 'route' => 'fleet.equipment.components-monitoring', 'icon' => 'chart-bar'],
                    [
                        'label' => 'Customer Equipment Card',
                        'route' => 'fleet.equipment.customer-equipment-card',
                        'icon' => 'identification',
                        'active_routes' => [
                            'fleet.equipment.customer-equipment-card',
                            'fleet.equipment.show',
                        ],
                    ],
                    ['label' => 'Attach Equipment', 'route' => 'fleet.equipment.attach-equipment', 'icon' => 'arrow-down-tray'],
                    ['label' => 'Detach Equipment', 'route' => 'fleet.equipment.detach-equipment', 'icon' => 'arrow-up-tray'],
                    ['label' => 'Swap Equipment', 'route' => 'fleet.equipment.swap-equipment', 'icon' => 'arrows-right-left'],
                    ['label' => 'Change customer information', 'route' => 'fleet.equipment.change-customer-information', 'icon' => 'user-circle'],
                    ['label' => 'Generate Customer Equipment Card', 'route' => 'fleet.equipment.generate-customer-equipment-card', 'icon' => 'document-arrow-down'],
                    ['label' => 'Pending Installed Base updates from Work Orders', 'route' => 'fleet.equipment.pending-installed-base-updates-from-work-orders', 'icon' => 'clock'],
                    ['label' => 'Maintenance Item Monitoring', 'route' => 'fleet.equipment.maintenance-item-monitoring', 'icon' => 'eye'],
                ],
            ],
            [
                'label' => 'Minimum Equipment List',
                'icon' => 'clipboard-document-list',
                'children' => [
                    ['label' => 'Minimum Equipment List', 'route' => 'fleet.equipment.minimum-equipment-list', 'icon' => 'shield-check'],
                ],
            ],
            [
                'label' => 'Modification',
                'icon' => 'sparkles',
                'children' => [
                    [
                        'label' => 'Search Modifications',
                        'route' => 'fleet.modification.index',
                        'icon' => 'magnifying-glass',
                        'active_routes' => [
                            'fleet.modification.index',
                        ],
                    ],
                    [
                        'label' => 'Modification',
                        'route' => 'fleet.modification.modification',
                        'icon' => 'document-text',
                        'active_routes' => [
                            'fleet.modification.modification',
                            'fleet.modification.show',
                        ],
                    ],
                    ['label' => 'Apply Modifications to an Equipment', 'route' => 'fleet.modification.apply-on-equipment', 'icon' => 'wrench-screwdriver'],
                    ['label' => 'Apply Modifications to a Functional Location', 'route' => 'fleet.modification.apply-on-functional-location', 'icon' => 'map-pin'],
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
                        'icon' => 'book-open',
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
                            [
                                'label' => 'Simulation on Fleet',
                                'route' => 'maintenance.maintenance-plan.simulation-on-fleet',
                                'icon' => 'beaker',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Fleet Report',
                'icon' => 'document-chart-bar',
                'children' => [
                    [
                        'label' => 'Historical Equipment Hierarchy',
                        'route' => 'reports.historical-equipment-hierarchy',
                        'icon' => 'queue-list',
                    ],
                    [
                        'label' => 'View Modification On Equipment',
                        'route' => 'reports.view-modification-on-equipment',
                        'icon' => 'wrench-screwdriver',
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
                    ['label' => 'List of Postponed Operations', 'route' => 'operations.postponed-operation', 'icon' => 'clock'],
                    ['label' => 'Components Removed: To be received in Warehouse', 'route' => 'operations.component-removed', 'icon' => 'archive-box'],
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
        'label' => 'Maintenance',
        'icon' => 'tool',
        'children' => [
            ['label' => 'Maintenance Program', 'route' => 'maintenance.maintenance-program.index', 'icon' => 'book-open'],
            ['label' => 'Maintenance Plan', 'route' => 'maintenance.maintenance-plan.index', 'icon' => 'calendar-days'],
            ['label' => 'Work Package', 'route' => 'maintenance.maintenance-plan.work-package', 'icon' => 'briefcase'],
            ['label' => 'Simulation on Fleet', 'route' => 'maintenance.maintenance-plan.simulation-on-fleet', 'icon' => 'chart-bar'],
        ],
    ],
    [
        'label' => 'Operations',
        'icon' => 'rocket-launch',
        'children' => [
            ['label' => 'Daily Updates', 'route' => 'operations.daily-updates', 'icon' => 'calendar-days'],
            ['label' => 'Fleet Management Cockpit', 'route' => 'operations.fleet-management-cockpit', 'icon' => 'chart-bar'],
            ['label' => 'Technical Logs', 'route' => 'operations.technical-logs', 'icon' => 'clipboard-document-list'],
            ['label' => 'Postponed Operation', 'route' => 'operations.postponed-operation', 'icon' => 'clock'],
            ['label' => 'Component Removed', 'route' => 'operations.component-removed', 'icon' => 'cube'],
        ],
    ],
    [
        'label' => 'Services',
        'icon' => 'chat-bubble-left-right',
        'children' => [
            ['label' => 'Contact Report', 'route' => 'services.contact-report.index', 'icon' => 'document-text'],
            ['label' => 'My Contact Report', 'route' => 'services.my-contact-report.index', 'icon' => 'clipboard-document-list'],
            ['label' => 'Observations', 'route' => 'services.observations.index', 'icon' => 'information-circle'],
            ['label' => 'Activities', 'route' => 'services.activities.index', 'icon' => 'clock'],
            [
                'label' => 'Scheduled Visits',
                'icon' => 'calendar-days',
                'children' => [
                    ['label' => 'New Scheduled Visit', 'route' => 'services.schedule-visits.create', 'icon' => 'plus'],
                    ['label' => 'My Scheduled Visits', 'route' => 'services.schedule-visits.index', 'icon' => 'clipboard-document-list'],
                ],
            ],
            [
                'label' => 'Alerts',
                'icon' => 'bell',
                'children' => [
                    ['label' => 'My Alerts Subscription', 'route' => 'services.alert.index', 'icon' => 'bell'],
                    ['label' => 'Personalized Alerts Management', 'route' => 'services.alert.create', 'icon' => 'sliders'],
                ],
            ],
            [
                'label' => 'Search',
                'icon' => 'magnifying-glass',
                'children' => [
                    ['label' => 'Search Contact Reports', 'route' => 'search.contact-report', 'icon' => 'magnifying-glass'],
                    ['label' => 'Search Observations', 'route' => 'search.observations', 'icon' => 'magnifying-glass'],
                    ['label' => 'Search Activities', 'route' => 'search.activities', 'icon' => 'magnifying-glass'],
                ],
            ],
            ['label' => 'Service Contract', 'route' => 'services.service-contract.index', 'icon' => 'briefcase'],
        ],
    ],
    [
        'label' => 'Flight',
        'icon' => 'paper-airplane',
        'children' => [
            [
                'label' => 'Flight Scheduling',
                'icon' => 'calendar-days',
                'children' => [
                    ['label' => 'Aircraft Schedule', 'route' => 'flight.aircraft-schedule', 'icon' => 'calendar-days'],
                    ['label' => 'Flight Schedule Template', 'route' => 'flight.flight-schedule-template', 'icon' => 'document-text'],
                    ['label' => 'Schedule Flight', 'route' => 'flight.schedule-flight', 'icon' => 'plus'],
                ],
            ],
            [
                'label' => 'Flight Records',
                'icon' => 'clipboard-document-list',
                'children' => [
                    ['label' => 'Flight Details', 'route' => 'flight.flight-details', 'icon' => 'document-text'],
                    ['label' => 'Daily Flight Log', 'route' => 'flight.daily-flight-log', 'icon' => 'clipboard-document-list'],
                ],
            ],
            ['label' => 'Search Flight Details', 'route' => 'flight.search-flight-details', 'icon' => 'magnifying-glass'],
        ],
    ],
    [
        'label' => 'Reports',
        'icon' => 'presentation-chart-line',
        'children' => [
            ['label' => 'Fleet Synthesis', 'route' => 'reports.fleet-synthesis', 'icon' => 'chart-bar'],
            ['label' => 'Fleet Report', 'route' => 'reports.fleet-report', 'icon' => 'document-text'],
            ['label' => 'Time Tracking', 'route' => 'reports.time-tracking', 'icon' => 'clock'],
        ],
    ],
    [
        'label' => 'MRO',
        'icon' => 'cube',
        'children' => [
            ['label' => 'Tag Traveler Cockpit', 'route' => 'mro.tag-traveler-cockpit', 'icon' => 'paperclip'],
            ['label' => 'Tools Status', 'route' => 'mro.tools-status', 'icon' => 'wrench-screwdriver'],
            [
                'label' => 'Receiving And Shipping',
                'icon' => 'cube',
                'children' => [
                    ['label' => 'New Receiving', 'route' => 'mro.receiving.create', 'icon' => 'plus'],
                    ['label' => 'Receiving List', 'route' => 'mro.receiving.index', 'icon' => 'clipboard-document-list'],
                    ['label' => 'New Shipping', 'route' => 'mro.shipping.create', 'icon' => 'plus'],
                    ['label' => 'Shipping List', 'route' => 'mro.shipping.index', 'icon' => 'document-text'],
                ],
            ],
            ['label' => 'Work Scope Cockpit', 'route' => 'mro.workscope-cockpit', 'icon' => 'adjustments-horizontal'],
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
            [
                'label' => 'Task List',
                'icon' => 'clipboard-document-list',
                'children' => [
                    ['label' => 'Search Task List', 'route' => 'mro.task-list.search', 'icon' => 'magnifying-glass'],
                    ['label' => 'Task List', 'route' => 'mro.task-list.index', 'icon' => 'document-text'],
                ],
            ],
            [
                'label' => 'Work Order',
                'icon' => 'briefcase',
                'children' => [
                    ['label' => 'List of Technical Logs', 'route' => 'mro.work-order.technical-logs', 'icon' => 'document-text'],
                    ['label' => 'List of Postponed Operations', 'route' => 'mro.work-order.postponed-operations', 'icon' => 'clock'],
                    ['label' => 'Components Removed: To be received in Warehouse', 'route' => 'mro.work-order.component-removed', 'icon' => 'cube'],
                    ['label' => 'List of Open Work Order', 'route' => 'mro.work-order.index', 'icon' => 'clipboard-document-list'],
                    ['label' => 'List of Open Operations for Released Work Order', 'route' => 'mro.work-order.open-operations-released', 'icon' => 'check-circle'],
                    ['label' => 'Search Work Order', 'route' => 'mro.work-order.search', 'icon' => 'magnifying-glass'],
                    ['label' => 'Work Order', 'route' => 'mro.work-order.detail', 'icon' => 'briefcase'],
                    ['label' => 'Logistic Cockpit', 'route' => 'mro.work-order.logistic-cockpit', 'icon' => 'cube'],
                    ['label' => 'Measurement Point - Recording', 'route' => 'mro.work-order.measurement-point-recording', 'icon' => 'chart-bar'],
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
        'label' => 'Lookups',
        'route' => 'lookups.index',
        'icon' => 'book-open',
    ],
    [
        'label' => 'System',
        'icon' => 'shield-check',
        'children' => [
            ['label' => 'Item Master Data', 'route' => 'system.item-master-data.index', 'icon' => 'clipboard-document-list'],
            ['label' => 'Technical Logs', 'route' => 'system.technical-logs.index', 'icon' => 'document-text'],
            ['label' => 'Aircraft Type', 'route' => 'system.aircraft-type.index'],
            ['label' => 'Counter', 'route' => 'system.counter.index', 'icon' => 'chart-bar'],
            ['label' => 'User Management', 'route' => 'system.user-management.index'],
            ['label' => 'Manage Status', 'route' => 'system.manage-status.index'],
            ['label' => 'Profile', 'route' => 'system.profile'],
            ['label' => 'Settings', 'route' => 'system.settings'],
            ['label' => 'Tasks', 'route' => 'system.tasks'],
        ],
    ],
];
