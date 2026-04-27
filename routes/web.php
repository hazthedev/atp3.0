<?php

use Illuminate\Support\Facades\Route;

/**
 * @param  array<int, array{0: string, 1: string, 2: string}>  $routes
 */
$registerRoutes = static function (array $routes): void {
    foreach ($routes as [$uri, $view, $name]) {
        Route::get($uri, static fn () => view($view))->name($name);
    }
};

Route::middleware('guest')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/login', 'pages.auth.login', 'login'],
        ['/register', 'pages.auth.register', 'register'],
    ]);
});

Route::get('/', static fn () => view('pages.dashboard'))->name('dashboard');

Route::prefix('dashboard')->name('dashboard.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/user', 'pages.stub', 'user'],
        ['/fleet', 'pages.stub', 'fleet'],
    ]);
});

Route::prefix('technical-data')->name('technical-data.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/configuration-management/family', 'pages.stub', 'configuration-management.family'],
        ['/configuration-management/type', 'pages.stub', 'configuration-management.type'],
        ['/configuration-management/variant', 'pages.stub', 'configuration-management.variant'],
        ['/configuration-management/applicable-configuration', 'pages.stub', 'configuration-management.applicable-configuration'],
        ['/technical-publications', 'pages.stub', 'technical-publications'],
        ['/maintenance-program/visit', 'pages.reference.visits', 'maintenance-program.visit'],
        ['/maintenance-program/task', 'pages.reference.task-types', 'maintenance-program.task'],
        ['/maintenance-program/administration', 'pages.stub', 'maintenance-program.administration'],
    ]);
});

Route::prefix('crm')->name('crm.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/business-partner', 'pages.crm.business-partner.index', 'business-partner.index'],
        ['/business-partner/create', 'pages.crm.business-partner.create', 'business-partner.create'],
        ['/business-partner/{id}/edit', 'pages.crm.business-partner.edit', 'business-partner.edit'],
    ]);
});

Route::prefix('fleet')->name('fleet.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/functional-location', 'pages.fleet.functional-location.index', 'functional-location.index'],
        ['/functional-location/search', 'pages.fleet.functional-location.search', 'functional-location.search'],
        ['/functional-location/create', 'pages.fleet.functional-location.create', 'functional-location.create'],
        ['/functional-location/customer', 'pages.fleet.functional-location.customer', 'functional-location.customer'],
        ['/functional-location/component-history', 'pages.fleet.functional-location.component-history', 'functional-location.component-history'],
        ['/functional-location/equipment-card', 'pages.fleet.functional-location.equipment-card', 'functional-location.equipment-card'],
        ['/functional-location/attach-equipment', 'pages.fleet.functional-location.attach-equipment', 'functional-location.attach-equipment'],
        ['/functional-location/detach-equipment', 'pages.fleet.functional-location.detach-equipment', 'functional-location.detach-equipment'],
        ['/functional-location/change-customer-information', 'pages.fleet.functional-location.change-customer-information', 'functional-location.change-customer-information'],
        ['/functional-location/pending-installed-base-updates-from-work-orders', 'pages.fleet.functional-location.pending-installed-base-updates-from-work-orders', 'functional-location.pending-installed-base-updates-from-work-orders'],
        ['/functional-location/repair-information-cockpit', 'pages.fleet.functional-location.repair-information-cockpit', 'functional-location.repair-information-cockpit'],
        ['/functional-location/configuration-control', 'pages.fleet.functional-location.configuration-control', 'functional-location.configuration-control'],
        ['/functional-location/airworthiness-review', 'pages.fleet.functional-location.airworthiness-review', 'functional-location.airworthiness-review'],
        ['/functional-location/{id}', 'pages.fleet.functional-location.show', 'functional-location.show'],
        ['/functional-location/{id}/edit', 'pages.fleet.functional-location.edit', 'functional-location.edit'],
        ['/technical-publications/administration', 'pages.stub', 'technical-publications.administration'],
        ['/technical-publications/application', 'pages.stub', 'technical-publications.application'],
        ['/maintenance-plan/utilisation-model', 'pages.reference.utilization-models', 'maintenance-plan.utilisation-model'],
        ['/maintenance-plan/maintenance-planning', 'pages.stub', 'maintenance-plan.maintenance-planning'],
        ['/operational-inputs/defects', 'pages.stub', 'operational-inputs.defects'],
        ['/aircraft-type', 'pages.fleet.aircraft-type.index', 'aircraft-type.index'],
        ['/fleet-management-cockpit', 'pages.fleet.fleet-management-cockpit', 'fleet-management-cockpit'],
        ['/technical-logs', 'pages.fleet.technical-logs.index', 'technical-logs.index'],
        ['/technical-logs/create', 'pages.fleet.technical-logs.create', 'technical-logs.create'],
        ['/counter', 'pages.fleet.counter.index', 'counter.index'],
        ['/counter/create', 'pages.fleet.counter.create', 'counter.create'],
        ['/counter/{id}/edit', 'pages.fleet.counter.edit', 'counter.edit'],
        ['/modification', 'pages.fleet.modification.index', 'modification.index'],
        ['/modification/modification', 'pages.fleet.modification.modification', 'modification.modification'],
        ['/modification/apply-on-equipment', 'pages.fleet.modification.apply-on-equipment', 'modification.apply-on-equipment'],
        ['/modification/apply-on-functional-location', 'pages.fleet.modification.apply-on-functional-location', 'modification.apply-on-functional-location'],
        ['/modification/equipment-reference-evolution', 'pages.fleet.modification.equipment-reference-evolution', 'modification.equipment-reference-evolution'],
        ['/modification/{id}', 'pages.fleet.modification.show', 'modification.show'],
        ['/equipment', 'pages.fleet.equipment.index', 'equipment.index'],
        ['/equipment/customer', 'pages.fleet.equipment.customer-equipment-card', 'equipment.customer-equipment-card'],
        ['/equipment/components-monitoring', 'pages.fleet.equipment.components-monitoring', 'equipment.components-monitoring'],
        ['/equipment/attach', 'pages.fleet.equipment.attach-equipment', 'equipment.attach-equipment'],
        ['/equipment/detach', 'pages.fleet.equipment.detach-equipment', 'equipment.detach-equipment'],
        ['/equipment/swap', 'pages.fleet.equipment.swap-equipment', 'equipment.swap-equipment'],
        ['/equipment/change-customer-information', 'pages.fleet.equipment.change-customer-information', 'equipment.change-customer-information'],
        ['/equipment/information', 'pages.fleet.equipment.equipment-information', 'equipment.equipment-information'],
        ['/equipment/generate-card', 'pages.fleet.equipment.generate-equipment-card', 'equipment.generate-equipment-card'],
        ['/equipment/generate-customer-card', 'pages.fleet.equipment.generate-customer-equipment-card', 'equipment.generate-customer-equipment-card'],
        ['/equipment/pending-install-base-update', 'pages.fleet.equipment.pending-install-base-update', 'equipment.pending-install-base-update'],
        ['/equipment/pending-installed-base-updates-from-work-orders', 'pages.fleet.equipment.pending-installed-base-updates-from-work-orders', 'equipment.pending-installed-base-updates-from-work-orders'],
        ['/equipment/maintenance-item-monitoring', 'pages.fleet.equipment.maintenance-item-monitoring', 'equipment.maintenance-item-monitoring'],
        ['/equipment/minimum-equipment-list', 'pages.fleet.equipment.minimum-equipment-list', 'equipment.minimum-equipment-list'],
        ['/equipment/{id}', 'pages.fleet.equipment.show', 'equipment.show'],
        ['/maintenance/maintenance-program', 'pages.fleet.maintenance.maintenance-program', 'maintenance.maintenance-program'],
        ['/maintenance/maintenance-plan', 'pages.fleet.maintenance.maintenance-plan', 'maintenance.maintenance-plan'],
    ]);
});

Route::prefix('maintenance')->name('maintenance.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/maintenance-program', 'pages.maintenance.maintenance-program.index', 'maintenance-program.index'],
        ['/maintenance-program/create', 'pages.maintenance.maintenance-program.create', 'maintenance-program.create'],
        ['/maintenance-program/{id}/edit', 'pages.maintenance.maintenance-program.edit', 'maintenance-program.edit'],
        ['/maintenance-plan', 'pages.maintenance.maintenance-plan.index', 'maintenance-plan.index'],
        ['/maintenance-plan/administration', 'pages.maintenance.maintenance-plan.administration', 'maintenance-plan.administration'],
        ['/maintenance-plan/work-package', 'pages.maintenance.maintenance-plan.work-package', 'maintenance-plan.work-package'],
        ['/maintenance-plan/apply-visit', 'pages.maintenance.maintenance-plan.apply-visit', 'maintenance-plan.apply-visit'],
        ['/maintenance-plan/apply-task-list', 'pages.maintenance.maintenance-plan.apply-task-list', 'maintenance-plan.apply-task-list'],
        ['/maintenance-plan/simulation-on-fleet', 'pages.maintenance.maintenance-plan.simulation-on-fleet', 'maintenance-plan.simulation-on-fleet'],
    ]);
});

Route::prefix('mro')->name('mro.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/tag-traveler-cockpit', 'pages.mro.tag-traveler-cockpit', 'tag-traveler-cockpit'],
        ['/tools-status', 'pages.mro.tools-status', 'tools-status'],
        ['/receiving-shipping', 'pages.mro.receiving-shipping', 'receiving-shipping'],
        ['/receiving/create', 'pages.mro.receiving.create', 'receiving.create'],
        ['/receiving', 'pages.mro.receiving.index', 'receiving.index'],
        ['/shipping/create', 'pages.mro.shipping.create', 'shipping.create'],
        ['/shipping', 'pages.mro.shipping.index', 'shipping.index'],
        ['/workscope-cockpit', 'pages.mro.workscope-cockpit', 'workscope-cockpit'],
        ['/report-information-cockpit', 'pages.mro.report-information-cockpit', 'report-information-cockpit'],
        ['/repair-information-cockpit', 'pages.mro.repair-information-cockpit.index', 'repair-information.index'],
        ['/repair-information-cockpit/search', 'pages.mro.repair-information-cockpit.search', 'repair-information.search'],
        ['/repair-information-cockpit/open-repairs', 'pages.mro.repair-information-cockpit.open-repairs', 'repair-information.open-repairs'],
        ['/repair-information-cockpit/calendar-view', 'pages.mro.repair-information-cockpit.calendar-view', 'repair-information.calendar-view'],
        ['/tasklist', 'pages.mro.tasklist', 'tasklist'],
        ['/task-list', 'pages.mro.task-list.index', 'task-list.index'],
        ['/task-list/search', 'pages.mro.task-list.search', 'task-list.search'],
        ['/work-order', 'pages.mro.work-order.index', 'work-order.index'],
        ['/work-order/technical-logs', 'pages.mro.work-order.technical-logs', 'work-order.technical-logs'],
        ['/work-order/postponed-operations', 'pages.mro.work-order.postponed-operations', 'work-order.postponed-operations'],
        ['/work-order/component-removed', 'pages.mro.work-order.component-removed', 'work-order.component-removed'],
        ['/work-order/open-operations-released', 'pages.mro.work-order.open-operations-released', 'work-order.open-operations-released'],
        ['/work-order/search', 'pages.mro.work-order.search', 'work-order.search'],
        ['/work-order/detail', 'pages.mro.work-order.detail', 'work-order.detail'],
        ['/work-order/logistic-cockpit', 'pages.mro.work-order.logistic-cockpit', 'work-order.logistic-cockpit'],
        ['/work-order/measurement-point-recording', 'pages.mro.work-order.measurement-point-recording', 'work-order.measurement-point-recording'],
        ['/time-tracking', 'pages.mro.time-tracking', 'time-tracking'],
        ['/time-sheet', 'pages.mro.time-sheet', 'time-sheet'],
        ['/start-operation', 'pages.mro.start-operation', 'start-operation'],
        ['/end-operation', 'pages.mro.end-operation', 'end-operation'],
        ['/work-package', 'pages.stub', 'work-package'],
        ['/defects', 'pages.stub', 'defects'],
    ]);

    Route::get('/work-order/technical-logs/{log}', static function (string $log) {
        return view('pages.mro.work-order.technical-log-detail', ['logId' => $log]);
    })->name('work-order.technical-logs.show');
});

Route::prefix('operations')->name('operations.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/daily-updates', 'pages.operations.daily-updates', 'daily-updates'],
        ['/fleet-management-cockpit', 'pages.operations.fleet-management-cockpit', 'fleet-management-cockpit'],
        ['/technical-logs', 'pages.operations.technical-logs', 'technical-logs'],
        ['/postponed-operation', 'pages.operations.postponed-operation', 'postponed-operation'],
        ['/component-removed', 'pages.operations.component-removed', 'component-removed'],
    ]);
});

Route::prefix('services')->name('services.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/contact-report', 'pages.services.contact-report.index', 'contact-report.index'],
        ['/contact-report/create', 'pages.services.contact-report.create', 'contact-report.create'],
        ['/my-contact-report', 'pages.services.my-contact-report.index', 'my-contact-report.index'],
        ['/observations', 'pages.services.observations.index', 'observations.index'],
        ['/observations/create', 'pages.services.observations.create', 'observations.create'],
        ['/activities', 'pages.services.activities.index', 'activities.index'],
        ['/activities/create', 'pages.services.activities.create', 'activities.create'],
        ['/schedule-visits', 'pages.services.schedule-visits.index', 'schedule-visits.index'],
        ['/schedule-visits/create', 'pages.services.schedule-visits.create', 'schedule-visits.create'],
        ['/alert', 'pages.services.alert.index', 'alert.index'],
        ['/alert/create', 'pages.services.alert.create', 'alert.create'],
        ['/service-contract', 'pages.services.service-contract.index', 'service-contract.index'],
        ['/service-contract/create', 'pages.services.service-contract.create', 'service-contract.create'],
    ]);
});

Route::prefix('flight')->name('flight.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/aircraft-schedule', 'pages.flight.aircraft-schedule', 'aircraft-schedule'],
        ['/flight-schedule-template', 'pages.flight.flight-schedule-template', 'flight-schedule-template'],
        ['/schedule-flight', 'pages.flight.schedule-flight', 'schedule-flight'],
        ['/flight-details', 'pages.flight.flight-record.create', 'flight-details'],
        ['/daily-flight-log', 'pages.flight.daily-flight-log', 'daily-flight-log'],
        ['/technical-log', 'pages.flight.daily-flight-log', 'technical-log'],
        ['/defects', 'pages.stub', 'defects'],
        ['/search-flight-details', 'pages.flight.search-flight-details', 'search-flight-details'],
        ['/flight-schedule', 'pages.flight.aircraft-schedule', 'flight-schedule'],
        ['/flight-record', 'pages.flight.flight-record.create', 'flight-record.index'],
        ['/flight-record/create', 'pages.flight.flight-record.create', 'flight-record.create'],
    ]);
});

Route::prefix('reports')->name('reports.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/fleet-synthesis', 'pages.reports.fleet-synthesis', 'fleet-synthesis'],
        ['/fleet-synthesis/dashboard', 'pages.reports.fleet-synthesis.dashboard', 'fleet-synthesis.dashboard'],
        ['/fleet-synthesis/details', 'pages.reports.fleet-synthesis.details', 'fleet-synthesis.details'],
        ['/fleet-report', 'pages.reports.fleet-report', 'fleet-report'],
        ['/time-tracking', 'pages.reports.time-tracking', 'time-tracking'],
        ['/historical-equipment-hierarchy', 'pages.reports.historical-equipment-hierarchy', 'historical-equipment-hierarchy'],
        ['/view-modification-on-equipment', 'pages.reports.view-modification-on-equipment', 'view-modification-on-equipment'],
        ['/fleet-commercial/equipment-reliability', 'pages.stub', 'fleet-commercial.equipment-reliability'],
        ['/fleet-commercial/equipment-utilization', 'pages.stub', 'fleet-commercial.equipment-utilization'],
        ['/fleet-commercial/monthly-aircraft-report', 'pages.stub', 'fleet-commercial.monthly-aircraft-report'],
        ['/fleet-commercial/monthly-engine-report', 'pages.stub', 'fleet-commercial.monthly-engine-report'],
        ['/fleet-management/due-list-report', 'pages.stub', 'fleet-management.due-list-report'],
        ['/fleet-management/life-limit-overhaul-report', 'pages.stub', 'fleet-management.life-limit-overhaul-report'],
        ['/fleet-management/time-controlled-items-report', 'pages.stub', 'fleet-management.time-controlled-items-report'],
        ['/fleet-management/status-report', 'pages.stub', 'fleet-management.status-report'],
        ['/fleet-management/status-check', 'pages.stub', 'fleet-management.status-check'],
        ['/fleet-management/adsb-status', 'pages.stub', 'fleet-management.adsb-status'],
        ['/fleet-management/monthly-flight-hour', 'pages.stub', 'fleet-management.monthly-flight-hour'],
        ['/time-tracking/personal-experience', 'pages.stub', 'time-tracking.personal-experience'],
    ]);
});

Route::prefix('search')->name('search.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/contact-report', 'pages.search.contact-report', 'contact-report'],
        ['/observations', 'pages.search.observations', 'observations'],
        ['/activities', 'pages.search.activities', 'activities'],
    ]);
});

Route::prefix('initialization')->name('initialization.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/apply-maintenance-program', 'pages.initialization.apply-maintenance-program', 'apply-maintenance-program'],
        ['/structure-duplication', 'pages.initialization.structure-duplication', 'structure-duplication'],
    ]);
});

Route::prefix('admin')->name('admin.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/user-management/user-groups', 'pages.admin.user-management.user-groups', 'user-management.user-groups'],
        ['/user-management/user-authorizations', 'pages.admin.user-management.user-authorizations', 'user-management.user-authorizations'],
        ['/stock-management/item-groups', 'pages.admin.stock-management.item-groups.index', 'stock-management.item-groups'],
        ['/stock-management/item-groups/create', 'pages.admin.stock-management.item-groups.create', 'stock-management.item-groups.create'],
        ['/stock-management/item-groups/{id}/edit', 'pages.admin.stock-management.item-groups.edit', 'stock-management.item-groups.edit'],
        ['/stock-management/category-part', 'pages.admin.stock-management.category-parts', 'stock-management.category-part'],
        ['/stock-management/warehouses', 'pages.admin.stock-management.warehouses.index', 'stock-management.warehouses'],
        ['/stock-management/warehouses/create', 'pages.admin.stock-management.warehouses.create', 'stock-management.warehouses.create'],
        ['/stock-management/warehouses/{id}/edit', 'pages.admin.stock-management.warehouses.edit', 'stock-management.warehouses.edit'],
        ['/fleet/ipc', 'pages.stub', 'fleet.ipc'],
        ['/fleet/equipment/variant', 'pages.stub', 'fleet.equipment.variant'],
        ['/fleet/modification/type', 'pages.stub', 'fleet.modification.type'],
        ['/fleet/maintenance-program/visit', 'pages.reference.visits', 'fleet.maintenance-program.visit'],
        ['/fleet/maintenance-program/utilization-model', 'pages.reference.utilization-models', 'fleet.maintenance-program.utilization-model'],
        ['/fleet/penalties', 'pages.stub', 'fleet.penalties'],
        ['/fleet/technical-publication-type', 'pages.stub', 'fleet.technical-publication-type'],
        ['/fleet/status-management-workflow', 'pages.reference.workflow-groups', 'fleet.status-management-workflow'],
        ['/fleet/task-type', 'pages.reference.task-types', 'fleet.task-type'],
        ['/flight-operations/departure-arrival-locations', 'pages.stub', 'flight-operations.departure-arrival-locations'],
        ['/mro/work-order-type', 'pages.stub', 'mro.work-order-type'],
        ['/mro/defect-type', 'pages.stub', 'mro.defect-type'],
        ['/mro/status-management-workflow', 'pages.reference.workflow-groups', 'mro.status-management-workflow'],
        ['/utilities/counter-synchronization', 'pages.stub', 'utilities.counter-synchronization'],
        ['/utilities/max-value-bulk-update', 'pages.stub', 'utilities.max-value-bulk-update'],
        ['/utilities/fl-counters-bulk-update', 'pages.stub', 'utilities.fl-counters-bulk-update'],
        ['/utilities/cec-status-bulk-update', 'pages.stub', 'utilities.cec-status-bulk-update'],
        ['/utilities/change-customer-information', 'pages.stub', 'utilities.change-customer-information'],
        ['/utilities/equipment-reference-evolution', 'pages.stub', 'utilities.equipment-reference-evolution'],
    ]);
});

Route::prefix('hr')->name('hr.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/employee-master-data', 'pages.hr.employee-master-data.index', 'employee-master-data'],
        ['/employee-master-data/{id}/edit', 'pages.hr.employee-master-data.edit', 'employee-master-data.edit'],
    ]);
});

Route::prefix('lookups')->name('lookups.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/', 'pages.lookups.index', 'index'],
    ]);
});

Route::prefix('system')->name('system.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/item-master-data', 'pages.system.item-master-data.index', 'item-master-data.index'],
        ['/item-master-data/create', 'pages.system.item-master-data.create', 'item-master-data.create'],
        ['/item-master-data/{id}/edit', 'pages.system.item-master-data.edit', 'item-master-data.edit'],
        ['/business-partner-master-data', 'pages.system.business-partner-master-data.index', 'business-partner-master-data.index'],
        ['/business-partner-master-data/create', 'pages.system.business-partner-master-data.create', 'business-partner-master-data.create'],
        ['/business-partner-master-data/{id}/edit', 'pages.system.business-partner-master-data.edit', 'business-partner-master-data.edit'],
        ['/technical-logs', 'pages.system.technical-logs.index', 'technical-logs.index'],
        ['/aircraft-type', 'pages.system.aircraft-type.index', 'aircraft-type.index'],
        ['/functional-location', 'pages.system.functional-location.index', 'functional-location.index'],
        ['/counter', 'pages.system.counter.index', 'counter.index'],
        ['/user-management', 'pages.system.user-management.index', 'user-management.index'],
        ['/user-management/create', 'pages.system.user-management.create', 'user-management.create'],
        ['/user-management/{id}/edit', 'pages.system.user-management.edit', 'user-management.edit'],
        ['/manage-status', 'pages.system.manage-status.index', 'manage-status.index'],
        ['/profile', 'pages.system.profile', 'profile'],
        ['/settings', 'pages.system.settings', 'settings'],
        ['/tasks', 'pages.system.tasks', 'tasks'],
    ]);

    Route::get('/technical-logs/{log}', static function (string $log) {
        return view('pages.mro.work-order.technical-log-detail', ['logId' => $log]);
    })->name('technical-logs.show');
});
