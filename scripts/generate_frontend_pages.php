<?php

declare(strict_types=1);

$viewRoot = dirname(__DIR__) . '/resources/views/pages';

/**
 * @param  array<string, mixed>  $data
 */
function writePage(string $viewRoot, string $path, string $title, string $partial, array $data = [], string $afterInclude = '', string $append = ''): void
{
    $file = $viewRoot . '/' . $path . '.blade.php';
    $dir = dirname($file);

    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $export = var_export($data, true);
    $export = preg_replace('/^/m', '        ', $export ?? '[]');

    $contents = <<<BLADE
@extends('layouts.app')

@section('title', %s)

@section('content')
    @include('pages.partials.%s', %s)
%s
@endsection
%s
BLADE;

    $contents = sprintf(
        $contents,
        var_export($title, true),
        $partial,
        $export,
        $afterInclude !== '' ? "\n" . $afterInclude : '',
        $append !== '' ? "\n" . $append : '',
    );

    file_put_contents($file, $contents . PHP_EOL);
}

function writeInlinePage(string $viewRoot, string $path, string $title, string $body, string $append = ''): void
{
    $file = $viewRoot . '/' . $path . '.blade.php';
    $dir = dirname($file);

    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $contents = <<<BLADE
@extends('layouts.app')

@section('title', %s)

@section('content')
%s
@endsection
%s
BLADE;

    $contents = sprintf(
        $contents,
        var_export($title, true),
        $body,
        $append !== '' ? "\n" . $append : '',
    );

    file_put_contents($file, $contents . PHP_EOL);
}

$pages = [];

$add = static function (string $path, string $title, string $partial, array $data = [], string $afterInclude = '', string $append = '') use (&$pages): void {
    $pages[] = ['mode' => 'include'] + compact('path', 'title', 'partial', 'data', 'afterInclude', 'append');
};

$addInline = static function (string $path, string $title, string $body, string $append = '') use (&$pages): void {
    $pages[] = ['mode' => 'inline', 'path' => $path, 'title' => $title, 'body' => $body, 'append' => $append];
};

$addCrud = static function (string $directory, string $title, string $routePrefix, ?array $columns = null) use ($add): void {
    $indexData = [
        'title' => $title,
        'description' => 'Static placeholder list view for the ' . $title . ' module.',
        'createRoute' => $routePrefix . '.create',
    ];

    if ($columns !== null) {
        $indexData['columns'] = $columns;
    }

    $add($directory . '/index', $title, 'list-page', $indexData);
    $add($directory . '/create', 'Create ' . $title, 'form-page', [
        'title' => 'Create ' . $title,
        'description' => 'Frontend-only form shell for creating a new ' . strtolower($title) . '.',
    ]);
    $add($directory . '/edit', 'Edit ' . $title, 'form-page', [
        'title' => 'Edit ' . $title,
        'description' => 'Frontend-only edit experience for updating an existing ' . strtolower($title) . '.',
    ]);
};

$addCrud('crm/business-partner', 'Business Partner', 'crm.business-partner', ['Partner ID', 'Partner Name', 'Category', 'Status', 'Updated']);
$addCrud('maintenance/maintenance-program', 'Maintenance Program', 'maintenance.maintenance-program');
$addCrud('system/item-master-data', 'Item Master Data', 'system.item-master-data');
$addCrud('system/business-partner-master-data', 'Business Partner Master Data', 'system.business-partner-master-data');
$addCrud('system/user-management', 'User Management', 'system.user-management', ['User', 'Role', 'Team', 'Status', 'Last Login']);

$addInline('fleet/functional-location/index', 'Search Functional Locations', "    @livewire('fleet.functional-location-search-page')");
$addInline('fleet/functional-location/search', 'Search Functional Locations', "    @livewire('fleet.functional-location-search-page')");
$add('fleet/functional-location/create', 'Create Functional Location', 'form-page', [
    'title' => 'Create Functional Location',
    'description' => 'Establish a new functional location within the fleet structure.',
]);
$addInline('fleet/functional-location/customer', 'Customer Functional Location', "    @livewire('fleet.customer-functional-location-page', ['emptyState' => true])");
$add('fleet/functional-location/edit', 'Edit Functional Location', 'form-page', [
    'title' => 'Edit Functional Location',
    'description' => 'Adjust the functional location hierarchy, naming, and planning metadata.',
]);
$addInline('fleet/functional-location/show', 'Customer Functional Location', "    @livewire('fleet.customer-functional-location-page', ['recordId' => (int) request()->route('id')])");
$add('fleet/functional-location/component-history', 'Component History', 'list-page', [
    'title' => 'Component History',
    'description' => 'Review historical component activity tied to a functional location.',
]);
$add('fleet/functional-location/equipment-card', 'Equipment Card', 'show-page', [
    'title' => 'Equipment Card',
    'description' => 'Preview the card layout for equipment summaries at the functional location level.',
]);
$addInline('fleet/functional-location/attach-equipment', 'Attach Equipment', "    @livewire('fleet.attach-equipment-page')");
$addInline('fleet/functional-location/detach-equipment', 'Detach Equipment', "    @livewire('fleet.detach-equipment-page')");
$addInline('fleet/functional-location/change-customer-information', 'Change Customer Information', "    @livewire('fleet.change-customer-information-page')");
$addInline('fleet/functional-location/pending-installed-base-updates-from-work-orders', 'Pending Installed Base updates from Work Orders', "    @livewire('fleet.pending-installed-base-updates-page')");
$add('fleet/functional-location/repair-information-cockpit', 'Repair Information Cockpit', 'show-page', [
    'title' => 'Repair Information Cockpit',
    'description' => 'Tabbed cockpit layout covering repair creation, activity, detail, and work-order context.',
    'tabs' => [
        ['id' => 'create', 'label' => 'Create', 'items' => [['label' => 'Template', 'value' => 'Repair request'], ['label' => 'Prepared by', 'value' => 'Structures Team']]],
        ['id' => 'activity', 'label' => 'Activity', 'items' => [['label' => 'Current status', 'value' => 'Waiting for material review'], ['label' => 'Last update', 'value' => 'Today 09:45']]],
        ['id' => 'detail', 'label' => 'Detail', 'items' => [['label' => 'Reference', 'value' => 'RPR-4103'], ['label' => 'Station', 'value' => 'Kuala Lumpur']]],
        ['id' => 'work-order', 'label' => 'Work Order', 'items' => [['label' => 'WO Link', 'value' => 'WO-91022'], ['label' => 'Assigned', 'value' => 'Composite Shop']]],
    ],
]);
$add('fleet/aircraft-type/index', 'Aircraft Type', 'list-page', [
    'title' => 'Aircraft Type',
    'description' => 'Manage aircraft-type reference data with an inline modal for quick adds.',
    'columns' => ['Type', 'Manufacturer', 'Configuration', 'Status', 'Updated'],
], <<<'BLADE'
    <div class="flex justify-end">
        <button type="button" class="btn-secondary" @click="$dispatch('open-modal', { id: 'aircraft-type-create' })">Quick add aircraft type</button>
    </div>
BLADE
, <<<'BLADE'
@push('modals')
    <x-modal id="aircraft-type-create" title="Quick Add Aircraft Type">
        <div class="grid gap-4 md:grid-cols-2">
            <x-form.input label="Aircraft type" name="aircraft_type_name" placeholder="AW139" />
            <x-form.input label="Manufacturer" name="manufacturer" placeholder="Leonardo" />
            <x-form.select label="Configuration" name="configuration" :options="['vip' => 'VIP', 'utility' => 'Utility', 'medical' => 'Medical']" />
            <x-form.select label="Status" name="status" :options="['active' => 'Active', 'planned' => 'Planned']" />
        </div>
        <x-slot name="footer">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', { id: 'aircraft-type-create' })">Cancel</button>
            <button type="button" class="btn-primary">Save aircraft type</button>
        </x-slot>
    </x-modal>
@endpush
BLADE
);
$add('fleet/fleet-management-cockpit', 'Fleet Management Cockpit', 'cockpit-page', [
    'title' => 'Fleet Management Cockpit',
    'description' => 'Executive cockpit for aircraft readiness, counters, and key operational signals.',
]);
$add('fleet/technical-logs/index', 'Technical Logs', 'list-page', [
    'title' => 'Technical Logs',
    'description' => 'Preview technical-log list states and action affordances.',
    'createRoute' => 'fleet.technical-logs.create',
]);
$add('fleet/technical-logs/create', 'Create Technical Log', 'technical-log-create-page');
$add('fleet/counter/index', 'Counter', 'list-page', [
    'title' => 'Counter',
    'description' => 'Review fleet counters and their synchronization states.',
    'createRoute' => 'fleet.counter.create',
]);
$add('fleet/counter/create', 'Create Counter', 'form-page', [
    'title' => 'Create Counter',
    'description' => 'Add a counter definition used for monitoring fleet utilization.',
]);
$add('fleet/counter/edit', 'Edit Counter', 'form-page', [
    'title' => 'Edit Counter',
    'description' => 'Modify counter thresholds, references, and labels.',
]);
$addInline('fleet/modification/index', 'Search Modifications', "    @livewire('fleet.modification-search-page')");
$addInline('fleet/modification/modification', 'Modification', <<<'BLADE'
    <div class="space-y-6">
        <x-page-header
            title="Modification"
            description="Blank modification workspace until a record is selected from Search Modifications."
        >
            <x-slot name="actions">
                <a href="{{ route('fleet.modification.index') }}" class="btn-primary">Search Modifications</a>
            </x-slot>
        </x-page-header>

        <x-empty-state
            icon="magnifying-glass"
            label="No modification selected"
            description="Open Search Modifications and click a Unique Ref. row to populate this workspace with the selected modification package."
        >
            <a href="{{ route('fleet.modification.index') }}" class="btn-primary">Go to Search Modifications</a>
        </x-empty-state>
    </div>
BLADE
);
$addInline('fleet/modification/show', 'Modification', <<<'BLADE'
    @php
        use App\Support\ModificationCatalog;

        $record = ModificationCatalog::find((int) request()->route('id'));
    @endphp
    @include('pages.partials.modification-show-page', ['record' => $record])
BLADE
);
$addInline('fleet/modification/apply-on-equipment', 'Apply Modifications to an Equipment', "    @livewire('fleet.apply-modification-on-equipment-page')");
$addInline('fleet/modification/apply-on-functional-location', 'Apply Modifications to a Functional Location', "    @livewire('fleet.apply-modification-on-functional-location-page')");
$addInline('fleet/modification/equipment-reference-evolution', 'Equipment Reference Evolution', "    @livewire('fleet.equipment-reference-evolution-page')");
$addInline('fleet/equipment/index', 'Equipment', "    @livewire('fleet.equipment-index-page')");
$addInline('fleet/equipment/customer-equipment-card', 'Customer Equipment Card', "    @livewire('fleet.customer-equipment-card-page', ['emptyState' => true])");
$addInline('fleet/equipment/components-monitoring', 'Components Monitoring', "    @livewire('fleet.components-monitoring-page')");
$addInline('fleet/equipment/attach-equipment', 'Attach Equipment', "    @livewire('fleet.equipment-attach-page')");
$addInline('fleet/equipment/detach-equipment', 'Detach Equipment', "    @livewire('fleet.equipment-detach-page')");
$addInline('fleet/equipment/swap-equipment', 'Swap Equipment', "    @livewire('fleet.equipment-swap-page')");
$addInline('fleet/equipment/change-customer-information', 'Change Customer Information', "    @livewire('fleet.change-equipment-customer-information-page')");
$addInline('fleet/equipment/show', 'Customer Equipment Card', "    @livewire('fleet.customer-equipment-card-page', ['recordId' => (int) request()->route('id')])");
$add('fleet/equipment/equipment-information', 'Equipment Information', 'show-page', ['title' => 'Equipment Information', 'description' => 'Overview of equipment metadata, ownership, and reporting context.']);
$addInline('fleet/equipment/generate-equipment-card', 'Generate Equipment Card', "    @livewire('fleet.generate-equipment-card-page', ['mode' => 'standard'])");
$addInline('fleet/equipment/generate-customer-equipment-card', 'Generate Customer Equipment Card', "    @livewire('fleet.generate-equipment-card-page', ['mode' => 'customer'])");
$addInline('fleet/equipment/pending-install-base-update', 'Pending Install Base Update', "    @livewire('fleet.pending-installed-base-updates-page', ['context' => 'equipment'])");
$addInline('fleet/equipment/pending-installed-base-updates-from-work-orders', 'Pending Installed Base updates from Work Orders', "    @livewire('fleet.pending-installed-base-updates-page', ['context' => 'equipment'])");
$addInline('fleet/equipment/maintenance-item-monitoring', 'Maintenance Item Monitoring', "    @livewire('fleet.maintenance-item-monitoring-page')");
$addInline('fleet/equipment/minimum-equipment-list', 'Minimum Equipment List', "    @livewire('fleet.minimum-equipment-list-page')");
$addInline('fleet/maintenance/maintenance-program', 'Maintenance Program', "    @livewire('fleet.maintenance-program-page')");
$add('fleet/maintenance/maintenance-plan', 'Fleet Maintenance Plan', 'list-page', ['title' => 'Fleet Maintenance Plan', 'description' => 'Fleet-linked maintenance planning overview for quick navigation.']);

$add('maintenance/maintenance-plan/index', 'Maintenance Plan', 'list-page', ['title' => 'Maintenance Plan', 'description' => 'Browse maintenance plans and staging scenarios.']);
$addInline('maintenance/maintenance-plan/administration', 'Maintenance Plan Administration', "    @livewire('maintenance.maintenance-plan-administration-page')");
$addInline('maintenance/maintenance-plan/work-package', 'WorkPackage', "    @livewire('maintenance.work-package-page')");
$addInline('maintenance/maintenance-plan/apply-visit', 'Apply Visits and Task Lists', "    @livewire('maintenance.apply-visit-and-task-list-page', ['initialTab' => 'visit'])");
$addInline('maintenance/maintenance-plan/apply-task-list', 'Apply Visits and Task Lists', "    @livewire('maintenance.apply-visit-and-task-list-page', ['initialTab' => 'task-list'])");
$addInline('maintenance/maintenance-plan/simulation-on-fleet', 'Simulation on Fleet', "    @livewire('maintenance.simulation-on-fleet-page')");

$add('operations/daily-updates', 'Daily Updates', 'form-page', ['title' => 'Daily Updates', 'description' => 'Capture the daily operational update summary and coordination notes.']);
$add('operations/fleet-management-cockpit', 'Operations Fleet Management Cockpit', 'cockpit-page', ['title' => 'Operations Fleet Management Cockpit', 'description' => 'Operations-focused cockpit for near-term readiness, delays, and coordination tasks.']);
$add('operations/technical-logs', 'Operations Technical Logs', 'list-page', ['title' => 'Operations Technical Logs', 'description' => 'Operations perspective on technical-log follow-up items.']);
$add('operations/postponed-operation', 'Postponed Operation', 'list-page', ['title' => 'Postponed Operation', 'description' => 'Track postponed operational work items and owner follow-up.']);
$add('operations/component-removed', 'Component Removed', 'list-page', ['title' => 'Component Removed', 'description' => 'Review removed components and dispatch for downstream analysis.']);

foreach ([
    'contact-report' => 'Contact Report',
    'observations' => 'Observations',
    'activities' => 'Activities',
    'schedule-visits' => 'Schedule Visits',
    'alert' => 'Alert',
    'service-contract' => 'Service Contract',
] as $slug => $title) {
    $add('services/' . $slug . '/index', $title, 'list-page', [
        'title' => $title,
        'description' => 'Frontend list preview for the ' . $title . ' service area.',
        'createRoute' => 'services.' . $slug . '.create',
    ]);
    $add('services/' . $slug . '/create', 'Create ' . $title, 'form-page', [
        'title' => 'Create ' . $title,
        'description' => 'Static placeholder form for creating a new ' . strtolower($title) . ' entry.',
    ]);
}

$add('services/my-contact-report/index', 'My Contact Report', 'list-page', [
    'title' => 'My Contact Report',
    'description' => 'Personalized list shell for contact reports authored by the signed-in user.',
]);

$add('flight/flight-schedule', 'Flight Schedule', 'simple-page', [
    'title' => 'Flight Schedule',
    'description' => 'Calendar and table hybrid placeholder for the flight-schedule experience.',
    'sections' => [
        ['title' => 'Calendar lane', 'body' => 'This area reserves space for a monthly or weekly planning surface once live schedule data is available.'],
        ['title' => 'Flight strip list', 'body' => 'Use a synchronized list to show departures, arrivals, and task dependencies beside the calendar.'],
        ['title' => 'Dispatch notes', 'body' => 'Static cards in the frontend phase preview the density and spacing of operational annotations.'],
    ],
]);
$add('flight/flight-record/index', 'Flight Record', 'list-page', [
    'title' => 'Flight Record',
    'description' => 'Track flight records, crew metadata, and operational events in list form.',
    'createRoute' => 'flight.flight-record.create',
]);
$add('flight/flight-record/create', 'Create Flight Record', 'form-page', [
    'title' => 'Create Flight Record',
    'description' => 'Capture a new flight record entry for the operational history preview.',
]);

$add('mro/tag-traveler-cockpit', 'Tag Traveler Cockpit', 'cockpit-page', ['title' => 'Tag Traveler Cockpit', 'description' => 'Cockpit summary for traveler status, queues, and work allocation.']);
$add('mro/tools-status', 'Tools Status', 'list-page', ['title' => 'Tools Status', 'description' => 'Track tool availability and inspection status.']);
$add('mro/receiving-shipping', 'Receiving & Shipping', 'form-page', ['title' => 'Receiving & Shipping', 'description' => 'Combined receiving and shipping workflow preview for MRO coordination.']);
$add('mro/workscope-cockpit', 'Workscope Cockpit', 'cockpit-page', ['title' => 'Workscope Cockpit', 'description' => 'View workscope progress and readiness from a cockpit layout.']);
$add('mro/report-information-cockpit', 'Report Information Cockpit', 'cockpit-page', ['title' => 'Report Information Cockpit', 'description' => 'Quick visibility into report queues, approvals, and escalations.']);
$add('mro/tasklist', 'Tasklist', 'search-page', ['title' => 'Tasklist', 'description' => 'Filterable tasklist experience with a results grid preview.']);
$add('mro/work-order/index', 'Work Order', 'list-page', ['title' => 'Work Order', 'description' => 'Track work-order references, owners, and execution status.']);
$add('mro/time-tracking', 'Time Tracking', 'list-page', ['title' => 'Time Tracking', 'description' => 'Preview time-tracking entries and approval states.']);

foreach ([
    'fleet-report' => 'Fleet Report',
    'time-tracking' => 'Time Tracking',
] as $slug => $title) {
    $add('reports/' . $slug, $title, 'report-page', [
        'title' => $title,
        'description' => 'Reporting surface preview for ' . strtolower($title) . '.',
    ]);
}

$addInline('reports/historical-equipment-hierarchy', 'Historical Equipment Hierarchy', "    @livewire('reports.historical-equipment-hierarchy-page')");
$addInline('reports/view-modification-on-equipment', 'View Modification on Equipment', "    @livewire('reports.view-modification-on-equipment-page')");

foreach ([
    'contact-report' => 'Contact Report Search',
    'observations' => 'Observation Search',
    'activities' => 'Activity Search',
] as $slug => $title) {
    $add('search/' . $slug, $title, 'search-page', [
        'title' => $title,
        'description' => 'Filter and inspect placeholder search results for ' . strtolower($title) . '.',
    ]);
}

$add('initialization/apply-maintenance-program', 'Apply Maintenance Program', 'form-page', ['title' => 'Apply Maintenance Program', 'description' => 'Initialize a maintenance program against a selected scope.']);
$add('initialization/structure-duplication', 'Structure Duplication', 'form-page', ['title' => 'Structure Duplication', 'description' => 'Duplicate structural hierarchies during system initialization.']);
$add('lookups/index', 'Lookups', 'simple-page', ['title' => 'Lookups', 'description' => 'Scaffolded landing page for lookup-oriented reference content.']);

$add('system/technical-logs/index', 'System Technical Logs', 'list-page', ['title' => 'System Technical Logs', 'description' => 'System-maintained technical-log reference entries.', 'columns' => ['Template', 'Description', 'Revision', 'Status', 'Updated']]);
$add('system/aircraft-type/index', 'System Aircraft Type', 'list-page', ['title' => 'System Aircraft Type', 'description' => 'Administrative aircraft-type reference list for system settings.']);
$add('system/functional-location/index', 'System Functional Location', 'list-page', ['title' => 'System Functional Location', 'description' => 'Reference-level functional location administration list.']);
$add('system/counter/index', 'System Counter', 'list-page', ['title' => 'System Counter', 'description' => 'Administrative counter definitions for system-wide use.']);
$add('system/manage-status/index', 'Manage Status', 'list-page', ['title' => 'Manage Status', 'description' => 'Configure and review reusable status codes across the platform.']);
$add('system/profile', 'Profile', 'form-page', ['title' => 'Profile', 'description' => 'User profile editing surface for the frontend preview.']);
$add('system/settings', 'Settings', 'form-page', ['title' => 'Settings', 'description' => 'Global system settings shell with reusable form sections.']);
$add('system/tasks', 'Tasks', 'list-page', [
    'title' => 'Tasks',
    'description' => 'Track personal and system-assigned tasks in a compact list layout.',
    'columns' => ['Task', 'Owner', 'Due', 'Priority', 'Status'],
]);

foreach ($pages as $page) {
    if (($page['mode'] ?? 'include') === 'inline') {
        writeInlinePage($viewRoot, $page['path'], $page['title'], $page['body'], $page['append']);

        continue;
    }

    writePage($viewRoot, $page['path'], $page['title'], $page['partial'], $page['data'], $page['afterInclude'], $page['append']);
}

echo 'Generated ' . count($pages) . " frontend page view(s)." . PHP_EOL;
