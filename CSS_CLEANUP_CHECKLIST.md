# CSS Cleanup Checklist

Replace custom `@apply`-based CSS classes with inline Tailwind utilities, then delete the CSS definitions from `resources/css/app.css`.

## Completed Modules

- [x] Functional Location (was already clean)
- [x] Equipment (all pages)
- [x] Minimum Equipment List
- [x] Modification (search, show, apply-on-equipment, apply-on-FL, equipment-reference-evolution)
- [x] Maintenance (maintenance-program, simulation-on-fleet, apply-visit-and-task-list)
- [x] Maintenance Plan (administration, work-package — already clean)
- [x] Fleet Report (historical-equipment-hierarchy, view-modification-on-equipment — already clean)
- [x] Pending Installed Base Updates (inlined `pending-base-shell`, `pending-base-toolbar`)
- [x] Initialization > Apply Maintenance Program (already clean)
- [x] All page partials (show-page, form-page, simple-page, list-page, cockpit-page, report-page, etc.)
- [x] Orphaned/legacy CSS purge (~25 kB: legacy-*, tab-pill, observation-priority-pill-*, apply-maintenance-program-toggle-*, pending-base-footer)

---

## Remaining Modules

### Orphaned CSS & Components (no views reference them)

- [ ] Delete `detail-surface`, `detail-surface-accent`, `field-label` from CSS
- [ ] Delete unused component `components/detail/field.blade.php`

### Components (shared Blade components that use custom classes)

- [ ] `components/enterprise/field-row.blade.php` — inline `customer-change-field-grid`; remove dead `equipment-customer-change-row` reference
- [ ] `components/enterprise/lookup-row.blade.php` — remove dead `equipment-customer-change-inline` reference
- [ ] `components/enterprise/table-shell.blade.php` — inline `pending-base-table-shell` (keep `alert-subscription-table` name for datatable detection logic but inline its styles)

### Livewire: FL Customer Change

- [ ] `livewire/fleet/change-customer-information-page.blade.php` — inline `customer-change-shell`, `customer-change-inline-row`
- [ ] Delete `customer-change-shell`, `customer-change-field-grid`, `customer-change-inline-row` from CSS

### Operations (4 pages)

- [ ] `pages/operations/daily-updates.blade.php`
- [ ] `pages/operations/technical-logs.blade.php`
- [ ] `pages/operations/postponed-operation.blade.php`
- [ ] `pages/operations/component-removed.blade.php`

Custom classes: `daily-update-status`, `daily-update-section-heading`, `daily-update-list-meta`, `technical-log-status-pill`, `flight-generic-table`

### Services (10 pages)

- [ ] `pages/services/contact-report/create.blade.php`
- [ ] `pages/services/my-contact-report/index.blade.php`
- [ ] `pages/services/observations/index.blade.php`
- [ ] `pages/services/activities/index.blade.php`
- [ ] `pages/services/schedule-visits/index.blade.php`
- [ ] `pages/services/schedule-visits/create.blade.php`
- [ ] `pages/services/alert/index.blade.php`
- [ ] `pages/services/alert/create.blade.php`
- [ ] `pages/services/service-contract/create.blade.php`
- [ ] `pages/services/observations/create.blade.php` (if exists)

Custom classes: `contact-report-list-toolbar`, `contact-report-list-summary`, `contact-report-list-count`, `contact-report-issue-pill[-green/-amber/-red]`, `scheduled-visit-attachment-table`, `scheduled-visit-attachment-actions`, `service-contract-attachment-grid`, `daily-update-*`, `technical-log-status-pill`

### Search (3 pages)

- [ ] `pages/search/contact-report.blade.php`
- [ ] `pages/search/observations.blade.php`
- [ ] `pages/search/activities.blade.php`

Custom classes: `search-contact-report-*` (10 classes), `search-observation-*` (8 classes), `daily-update-*`, `technical-log-status-pill`, `flight-generic-table`

### Flight (7 pages)

- [ ] `pages/flight/aircraft-schedule.blade.php`
- [ ] `pages/flight/flight-schedule-template.blade.php`
- [ ] `pages/flight/schedule-flight.blade.php`
- [ ] `pages/flight/flight-details.blade.php`
- [ ] `pages/flight/daily-flight-log.blade.php`
- [ ] `pages/flight/flight-record/create.blade.php`
- [ ] `pages/flight/search-flight-details.blade.php`

Custom classes: `flight-generic-table`, `flight-search-result-toggle-row`, `scheduled-visit-attachment-table`, `daily-update-*`, `technical-log-status-pill`, `service-contract-attachment-grid`

### MRO (16 pages)

- [ ] `pages/mro/tag-traveler-cockpit.blade.php`
- [ ] `pages/mro/tools-status.blade.php`
- [ ] `pages/mro/receiving/create.blade.php`
- [ ] `pages/mro/receiving/index.blade.php`
- [ ] `pages/mro/shipping/create.blade.php`
- [ ] `pages/mro/shipping/index.blade.php`
- [ ] `pages/mro/repair-information-cockpit/search.blade.php`
- [ ] `pages/mro/repair-information-cockpit/index.blade.php`
- [ ] `pages/mro/repair-information-cockpit/open-repairs.blade.php`
- [ ] `pages/mro/repair-information-cockpit/calendar-view.blade.php`
- [ ] `pages/mro/task-list/search.blade.php`
- [ ] `pages/mro/task-list/index.blade.php`
- [ ] `pages/mro/work-order/index.blade.php`
- [ ] `pages/mro/work-order/search.blade.php`
- [ ] `pages/mro/work-order/technical-log-detail.blade.php`
- [ ] `pages/mro/work-order/logistic-cockpit.blade.php`
- [ ] `pages/mro/time-sheet.blade.php`
- [ ] `pages/mro/start-operation.blade.php`
- [ ] `pages/mro/end-operation.blade.php`

Custom classes: `mro-tools-status-alert[-active/-muted]`, `mro-receiving-*` (13 classes), `flight-generic-table`, `daily-update-*`, `technical-log-status-pill`, `search-contact-report-*`, `search-observation-*`

### Business Partners (4 pages)

- [ ] `pages/crm/business-partner/index.blade.php`
- [ ] `pages/crm/business-partner/partials/form.blade.php`
- [ ] `pages/system/business-partner-master-data/index.blade.php`
- [ ] `pages/system/business-partner-master-data/partials/form.blade.php`

Custom classes: `segmented-option[-active]`, `daily-update-*`, `technical-log-status-pill`

---

## CSS Classes to Delete After All Views Are Inlined

| Group | Classes | Inline Tailwind |
|-------|---------|-----------------|
| orphaned | `detail-surface` | `flex min-h-11 items-center rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 shadow-sm` |
| orphaned | `detail-surface-accent` | `border-blue-100 bg-blue-50 text-blue-700` |
| orphaned | `field-label` | `text-xs font-semibold uppercase tracking-[0.18em] text-gray-500` |
| daily-update | `daily-update-status` | `rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700` |
| daily-update | `daily-update-section-heading` | `text-sm font-semibold text-gray-900` |
| daily-update | `daily-update-list-meta` | `mt-1 text-sm text-gray-500` |
| tech-log | `technical-log-status-pill` | `inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700` |
| contact-report | `contact-report-list-toolbar` | `flex flex-col gap-3 border-b border-gray-200 pb-4 md:flex-row md:items-center md:justify-between` |
| contact-report | `contact-report-list-summary` | `flex items-center gap-3` |
| contact-report | `contact-report-list-count` | `inline-flex min-w-[72px] justify-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-900` |
| contact-report | `contact-report-issue-pill` | `inline-flex rounded-full px-2.5 py-1 text-xs font-semibold` |
| contact-report | `contact-report-issue-pill-green` | `bg-emerald-100 text-emerald-700` |
| contact-report | `contact-report-issue-pill-amber` | `bg-amber-100 text-amber-700` |
| contact-report | `contact-report-issue-pill-red` | `bg-rose-100 text-rose-700` |
| sched-visit | `scheduled-visit-attachment-table` | table: `min-w-full border-collapse`; thead tr: `bg-gray-50`; th: `border-b border-gray-200 px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap`; td: `border-b border-gray-100 px-3 py-2.5 text-sm text-gray-700 align-middle`; tbody tr: `transition-colors hover:bg-blue-50/60` |
| sched-visit | `scheduled-visit-attachment-actions` | `flex flex-col gap-3` |
| flight | `flight-generic-table` | table: `min-w-full border-collapse`; thead tr: `bg-gray-50`; th: `border-b border-gray-200 px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap`; td: `border-b border-gray-100 px-3 py-2.5 text-sm text-gray-700 align-top`; tbody tr: `transition-colors hover:bg-blue-50/60` |
| flight | `flight-search-result-toggle-row` | `flex flex-wrap items-center gap-2` |
| mro | `mro-tools-status-alert` | `inline-flex min-w-[20px] items-center justify-center text-sm font-semibold` |
| mro | `mro-tools-status-alert-active` | `text-amber-600` |
| mro | `mro-tools-status-alert-muted` | `text-gray-300` |
| mro-receiving | `mro-receiving-shell` | `max-w-[1280px] space-y-5` |
| mro-receiving | `mro-receiving-header-grid` | `grid gap-5 xl:grid-cols-[520px_minmax(0,1fr)]` |
| mro-receiving | `mro-receiving-general-top` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]` |
| mro-receiving | `mro-receiving-general-grid` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_280px]` |
| mro-receiving | `mro-receiving-large-textarea` | `min-h-[280px]` |
| mro-receiving | `mro-receiving-document-table` | `min-w-[980px]` |
| mro-receiving | `mro-receiving-linked-grid` | `grid gap-5 xl:grid-cols-3` |
| mro-receiving | `mro-receiving-linked-list` | `min-h-[140px] rounded-xl border border-gray-200 bg-white p-3` |
| mro-receiving | `mro-receiving-linked-row` | `border-b border-gray-100 py-2 text-sm text-gray-700 last:border-b-0` |
| mro-receiving | `mro-receiving-list-shell` | `max-w-[1380px] space-y-5` |
| mro-receiving | `mro-receiving-list-toolbar` | `flex flex-wrap items-center gap-8` |
| mro-receiving | `mro-receiving-list-table` | `min-w-[1180px]` |
| mro-receiving | `mro-receiving-list-footer` | `flex flex-wrap items-center gap-4` |
| service-contract | `service-contract-attachment-grid` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_160px]` |
| alert | `alert-subscription-table` | table: `min-w-full border-collapse`; thead tr: `bg-gray-50`; th: `border-b border-gray-200 px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap`; td: `border-b border-gray-100 px-3 py-2.5 text-sm text-gray-700 align-middle`; tbody tr: `transition-colors hover:bg-blue-50/60` |
| search-cr | `search-contact-report-general-grid` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]` |
| search-cr | `search-contact-report-mini-table-shell` | `max-h-[220px] overflow-auto` |
| search-cr | `search-contact-report-mini-table` | table: `min-w-full border-collapse`; thead/th/td/tbody same as flight-generic-table |
| search-cr | `search-contact-report-result-table` | same as mini-table |
| search-cr | `search-contact-report-inline-tools` | `flex flex-wrap items-center gap-3` |
| search-cr | `search-contact-report-type-shell` | `max-h-[180px] overflow-auto` |
| search-cr | `search-contact-report-status-row` | `flex flex-wrap items-center gap-4` |
| search-cr | `search-contact-report-id-grid` | `grid gap-4 md:grid-cols-2` |
| search-cr | `search-contact-report-footer` | `flex flex-wrap items-end gap-3` |
| search-cr | `search-contact-report-max-records` | `grid gap-2` (+ input: `w-24`) |
| search-obs | `search-observation-date-origin-grid` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]` |
| search-obs | `search-observation-date-row` | `grid grid-cols-[120px_156px_24px_156px] items-center gap-3` |
| search-obs | `search-observation-toggle-row` | `flex flex-wrap items-center gap-3` |
| search-obs | `search-observation-object-grid` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]` |
| search-obs | `search-observation-chapter-grid` | `grid grid-cols-5 gap-2` |
| search-obs | `search-observation-misc-grid` | `grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]` |
| search-obs | `search-observation-field-pairs` | `grid grid-cols-[minmax(0,1fr)_180px] items-center gap-x-3 gap-y-2.5` |
| search-obs | `search-observation-result-table` | table: `min-w-[1260px] border-collapse`; thead/th/td/tbody same as flight-generic-table |
| customer-change | `customer-change-shell` | `max-w-[720px]` |
| customer-change | `customer-change-field-grid` | `grid grid-cols-[112px_minmax(0,1fr)] items-center gap-3` |
| customer-change | `customer-change-inline-row` | `grid grid-cols-[112px_160px] items-center gap-3` |
| segmented | `segmented-option` | `inline-flex items-center justify-center rounded-lg px-3.5 py-2 text-sm font-medium text-gray-600 transition` |
| segmented | `segmented-option-active` | `bg-white text-blue-600 shadow-sm ring-1 ring-inset ring-blue-100` |

---

## Build Verification

After each batch of changes, run:

```bash
cd c:\Users\User\Project\weststar-dev.com\atp3-laravel && npm run build
```

Current CSS output: **162.42 kB** — should decrease with each batch.
