# Aircraft Card — mock dashboard page (design)

Date: 2026-04-28
L1 scope: Fleet Management
Source: `functional location ui revamp/ATP 3.0 - Aircraft Card, Component Card*.pdf` (10 PDFs, one per tab)

## Goal

Add a new sidebar entry **Aircraft Card** under `Fleet Management → Functional Location` and ship a 10-tab dashboard page rendering the layout shown in the supplied PDFs. The page is mock-only — no DB, no models, no migrations. Mock data lives in a single PHP catalog. Three demo aircraft are switchable via a top-card picker.

## Non-goals

- No DB schema changes, models, migrations, or seeders.
- No integration with existing `functional_locations` / `equipments` tables.
- No real save persistence, print, export, or interactive filter wiring on the server. Filters/sort/pagination work client-side via the existing `<x-data-table datatable>` (simple-datatables) integration.
- No charting library — donuts are CSS conic-gradient, sparklines are inline SVG.

## Sidebar & routing

Add to `config/navigation.php` under `Fleet Management → Functional Location`, positioned **second** (after `Functional Location Card`, before `Attach equipment to functional location`):

```php
[
    'label' => 'Aircraft Card',
    'route' => 'fleet.functional-location.aircraft-card',
    'icon'  => 'paper-airplane',
    'active_routes' => ['fleet.functional-location.aircraft-card'],
],
```

Routes (`routes/web.php`):

```php
Route::get('/fleet/functional-location/aircraft-card/{registration?}', AircraftCardPage::class)
    ->name('fleet.functional-location.aircraft-card');
```

The optional `{registration}` parameter drives the picker. Default is `A6-ATP` (resolved by the Livewire component, not the route).

## Architecture

### Single Livewire component, partial-based tabs

```
app/Livewire/Fleet/AircraftCardPage.php
```

Public state:

| Property | Type | Purpose |
|---|---|---|
| `$registration` | `string` | Currently selected aircraft (default `A6-ATP`) |
| `$activeTab` | `string` | One of: `overview`, `general`, `configuration`, `counters`, `maintenance`, `technical-publications`, `defects`, `work-package`, `journey-logs`, `events` |
| `$editMode` | `bool` | Edit Record toggle for General tab |
| `$form` | `array` | Editable General-tab fields (hydrated from catalog on mount + on aircraft switch) |

Methods:

- `mount(?string $registration = null)` — resolve registration (param or default), hydrate `$form`.
- `switchAircraft(string $reg)` — change registration, re-hydrate `$form`, exit edit mode.
- `setTab(string $tab)` — change `$activeTab`.
- `enableEdit() / cancelEdit()` — toggle edit mode (cancelEdit re-hydrates `$form`).
- `save()` — validates a small whitelist, flashes a toast, exits edit mode. **No DB write.**
- `getAircraftProperty()` — computed property returning `AircraftCardCatalog::find($this->registration)`.

### Mock data catalog

```
app/Support/AircraftCardCatalog.php
```

Public API:

| Method | Returns |
|---|---|
| `all(): array` | List for picker — `[['registration' => 'A6-ATP', 'msn' => '1234', 'status' => 'Active'], …]` |
| `find(string $reg): array` | Full payload for one aircraft (see shape below) |
| `default(): string` | `'A6-ATP'` |

Internal structure: one private static method per aircraft (`a6Atp()`, `a6Eas()`, `a6Wsa()`), each returning the full nested array. `find()` dispatches by registration.

### Mock data shape (per aircraft)

```php
[
    'registration' => 'A6-ATP',
    'msn'          => '1234',
    'status'       => 'Active',           // 'Active' | 'MEL' | 'Stored'

    'identity' => [
        'aircraft_type'    => 'A320-214',
        'delivery_date'    => '15 Jan 2012',
        'configuration'    => 'C16 Y150',
        'base'             => 'AUH',
        'maintenance_plan' => 'A320 AMM ISS 7 REV 5',
        'owner'            => 'Eastmoon Aviation',
        'operator'         => 'Eastmoon Aviation Services Sdn Bhd',
        'thumbnail'        => '/img/aircraft/a6-atp.jpg',
    ],

    'utilization' => [
        'avg_fh_per_day' => 7.28,
        'avg_fc_per_day' => 4.12,
        'fh_series'      => [/* 30 floats */],
        'fc_series'      => [/* 30 floats */],
    ],

    'overview' => [
        'status_summary' => [/* 5 tile groups */],
        'top_counters'   => [/* 5 rows */],
        'critical_due'   => [/* 5 rows */],
        'work_packages'  => [/* 5 rows */],
        'work_orders'    => [/* 5 rows */],
        'journey_logs'   => [/* 5 rows */],
        'events'         => [/* 5 rows */],
    ],

    'general' => [
        'lifecycle'      => [...],   // Card 1
        'operator_org'   => [...],   // Card 2
        'mass_limits'    => [...],   // Card 3
        'registration'   => [...],   // Card 4
        'manufacturer'   => [...],   // Card 5
        'powerplant'     => [...],   // Card 6
        'owner_address'  => [...],   // Card 7
        'commercial'     => [...],   // Card 8
    ],

    'configuration' => [
        'status_pill'   => 'Complete',          // 'Complete' | 'Incomplete'
        'summary'       => [/* 5 tiles */],
        'effective'     => [...],
        'tree'          => [/* ATA chapters with status badges */],
        'selected_node' => [
            'header'              => [...],
            'installation_status' => [...],
            'counters'            => [...],
            'maintenance_due'     => [...],
            'history'             => [...],
            'config_control'      => [...],
            'compliance'          => [...],
        ],
    ],

    'counters' => [
        'summary'        => [...],
        'reading_checks' => [...],
        'last_update'    => [...],
        'rows'           => [/* counter table */],
        'by_type_donut'  => [...],
        'by_source_donut'=> [...],
    ],

    'maintenance' => [
        'summary'      => [...],
        'donut'        => [...],
        'utilization'  => [...],
        'rows'         => [/* maintenance items */],
    ],

    'technical_publications' => [
        'summary'  => [...],
        'donut'    => [...],
        'coverage' => [...],
        'rows'     => [/* publications */],
    ],

    'defects' => [
        'rows' => [/* defect rows */],
    ],

    'work_package' => [
        'packages'        => [/* WP rows */],
        'selected_pkg_no' => 'WABCD/1234/0108',
        'orders'          => [/* WO rows for selected package */],
    ],

    'journey_logs' => [
        'rows'             => [/* log rows */],
        'selected_log_no'  => '012893',
        'selected_log'     => [
            'flight_details'  => [...],
            'pic'             => [...],
            'fuel_log'        => [...],
            'aircraft_rate'   => [...],
            'crs'             => [...],
            'maint_supervisor'=> [...],
            'pre_flight'      => [...],
            'next_due'        => [...],
            'daily_maint'     => [...],
            'defects'         => [...],
        ],
    ],

    'events' => [
        'rows' => [/* 10+ event rows */],
    ],
]
```

Three aircraft seeded:
- **A6-ATP** — `Active`, full data per PDFs.
- **A6-EAS** — `Active`, varied numbers.
- **A6-WSA** — `MEL`, demonstrates the `MEL` status pill color and an `Overdue` defect.

## File layout

```
app/Livewire/Fleet/AircraftCardPage.php
app/Support/AircraftCardCatalog.php

resources/views/pages/fleet/functional-location/aircraft-card.blade.php   (route wrapper, single Livewire mount)
resources/views/livewire/fleet/aircraft-card-page.blade.php               (shell + header + tab nav)
resources/views/livewire/fleet/aircraft-card/
  _header.blade.php
  _summary-tile.blade.php
  _donut.blade.php
  _sparkline.blade.php
  _status-pill.blade.php
  overview.blade.php
  general.blade.php
  configuration.blade.php
  counters.blade.php
  maintenance.blade.php
  technical-publications.blade.php
  defects.blade.php
  work-package.blade.php
  journey-logs.blade.php
  events.blade.php
```

Tab partials are plain Blade `@include`d from `aircraft-card-page.blade.php` based on `$activeTab`. No nested Livewire — same pattern as the existing FL show page.

## UI conventions

### Header (persistent across all tabs)

- Page title `Aircraft Card`
- Aircraft thumbnail (left)
- Registration + status pill (top of identity block)
- Aircraft type subtitle
- Identity strip: MSN / Registration / Aircraft Type / Delivery Date / Configuration / Base / Maintenance Plan / Owner / Operator
- **Aircraft picker dropdown** (top-right) — switches between the 3 catalog entries
- Action buttons: Print, Export, Actions ▾ (all inert — render but no handlers)
- Alerts / Tasks / Messages icons with badges (inert)
- Utilization card (right): Avg FH/Day, Avg FC/Day with mini sparklines
- "Last updated 22 May 2025 10:35 UTC" + refresh icon (refresh re-renders, no-op)

### Tab navigation

Horizontal tab bar, blue underline on active. Click triggers `setTab($tab)`. 10 tabs as listed in the architecture section.

### Edit Record pattern

- Top-card has an **Edit Record** button — only enables/disables editability of the **General tab**.
- General tab partial wraps its content with `[data-edit-scope]`.
- When `$editMode === false`, all `<x-enterprise.input>` fields render with `variant="disabled"`.
- When `$editMode === true`, inputs render editable, and a Cancel / Save Changes footer appears.
- Cancel re-hydrates `$form` from the catalog and exits edit mode.
- Save validates a small whitelist (string lengths, date format), flashes a toast, exits edit mode. **No DB write.**
- Other tabs are always read-only.

### Reused enterprise components

- `<x-enterprise.input variant="...">`, `<x-enterprise.select>`, `<x-enterprise.textarea>`, `<x-enterprise.label>`, `<x-enterprise.checkbox>`, `<x-enterprise.radio>`
- `<x-data-table … datatable>` for all tabular tabs (Maintenance, Tech Pubs, Defects, Events, Journey Logs, Counters)
- `<x-enterprise.field-row>`, `<x-enterprise.date-row>`, `<x-enterprise.textarea-row>` on the General tab cards

### New small partials (not full components)

| Partial | Purpose |
|---|---|
| `_summary-tile.blade.php` | Icon + count + label tile (used on Overview status summary, Counters summary, Maintenance summary, Tech Pubs summary) |
| `_donut.blade.php` | CSS conic-gradient donut with center label and a side legend list |
| `_sparkline.blade.php` | Inline SVG line chart (utilization mini-charts, ~30 points) |
| `_status-pill.blade.php` | Colored badge: `Active` (green) / `MEL` (red) / `Stored` (grey) / `Compliant` (green) / `Overdue` (red) / `Due Within Alarm` (amber) / `Not Due` (grey) / `Pending Inspection` (amber) / `Missing` (red) / `NOK` (red) / `Installed` (green) |

### Color system

- Green — Compliant / Installed / Active
- Amber — Due Within Alarm / Pending Inspection
- Red — Overdue / Missing / NOK / MEL
- Grey — Not Due / Not Applicable / Stored
- Blue — Informational / current selection

## Tab-by-tab content reference

(Each entry is a quick reminder of what the tab partial renders. See the source PDF for the canonical layout.)

1. **Overview** — 5 status-summary tile groups (Configuration, Maintenance, Maintenance Planning, Tech Pubs, Defects) + 6 Top-5 widget cards (Counters, Critical Due, Work Packages, Work Orders, Journey Log, Events).
2. **General** — 8 numbered cards in a 3-column grid (Aircraft Lifecycle, Operator & Org, Mass & Limitations, Registration & Certification, Manufacturer Data, Powerplant, Registered Owner Address, Commercial Information). Cancel / Save Changes footer when in edit mode.
3. **Configuration** — Status pill, 5-tile summary, Effective box, two-column body: ATA tree (left, with status badges) + selected node detail (right) including Installation & Status, Counters, Maintenance & Due, Component History, Quick Actions, Configuration Control, Compliance & Validation.
4. **Counters** — Summary tiles, Reading Checks, Last Update, filterable counter table (`<x-data-table datatable>`), side donuts (Counters by Type, Counters by Source), Quick Links.
5. **Maintenance** — Summary tiles, status donut, utilization-since-new, filterable maintenance items table with Last Done / Next Due / Remaining / Status, Item Type Legend, Threshold/Interval Examples.
6. **Technical Publications** — Summary, compliance donut, coverage by type, filterable publications table with Last/Next compliance, Publication Types & Method of Compliance legends, Quick Links.
7. **Defects** — Filterable defects table with Reported By / Action Taken / Performed By / Deferral / MEL Repair Category / Expiry, Defects Category column, Type & MEL Repair Category legends.
8. **Work Package / Work Order** — Two stacked tables: WPs (with selection radio) + WOs filtered to the selected WP. Status legend (DRAFT / PLANNED / OPEN / CLOSED).
9. **Journey Logs** — Logs table + selected-log detail card: Flight Details, PIC, Fuel Log, Aircraft Rate, CRS, Maintenance Supervisor, Pre-Flight/Turn Around Maintenance, Next Maintenance Due, Daily Maintenance, Defects sub-table.
10. **Events** — Filterable events table (Event Type, Category, Date Range): Component Installation/Uninstallation, Configuration Update, Visit Application, Task Application, Tech Pub Embodiment, Status Change, Airworthiness Review, SB Embodiment, Mandatory Modification.

## Tests

`tests/Feature/Livewire/Fleet/AircraftCardPageTest.php` — Livewire feature tests:

- Page renders for default registration (no param).
- Page renders for each of the 3 aircraft via the route param.
- `switchAircraft('A6-EAS')` updates `$registration` and re-renders.
- `setTab('general')` updates `$activeTab` and re-renders.
- `enableEdit()` then `cancelEdit()` restores `$form`.
- `save()` exits edit mode and emits a session flash. (No DB assertions.)
- All 10 tab keys produce a renderable view (smoke test loop).

No deep assertions on every table row — the catalog is the source of truth, not the DOM.

## Module file update

At PR time, update `docs/modules/fleet-management.md`:

- Add **Aircraft Card** under Shipped (with: "mock dashboard page, 10 tabs, picker over 3 demo aircraft, no DB integration").
- Append a Last updated entry dated 2026-04-28 with the spec link.

## Risks

- **Catalog file size** — 3 aircraft × 10 tabs of dense data is a long file (~1,500-2,000 lines). Mitigated by one private static method per aircraft.
- **Visual fidelity vs SAP-trim look** — the PDFs use a slightly more dashboard-y visual language than the rest of the app. We lean toward existing component styling; some pixel-perfect details (donut colors, sparkline curves) will be approximations.
- **Drift from spec when this becomes real** — once a future sprint backs Counters/Maintenance/Defects with real models, the catalog shape will need to map to those models. The catalog is the single point of change.
- **Inert action buttons** — Print / Export / Actions / Alerts / Tasks / Messages render but do nothing. Acceptable for a mock; flag clearly to reviewers.

## Out-of-scope follow-ups (potential future work)

- Cross-link from FL show page → Aircraft Card for the same registration.
- Wire General tab Save to actually persist into `functional_locations`.
- Replace mock catalog with real Counter / Maintenance / Tech Pub / Defect / WP / WO / Journey Log / Event data once those modules are built.
- Real charting library (Chart.js or similar) once interactivity is needed.
- Component Card cross-navigation from the Configuration tree.
