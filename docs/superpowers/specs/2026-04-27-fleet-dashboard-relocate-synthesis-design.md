# Fleet Dashboard — Relocate Fleet Synthesis content — Design

**Date:** 2026-04-27
**Module:** Dashboard (L1 #1) → Fleet Dashboard
**Related L1s:** Touches `Reports` only via the breadcrumb-default fallback rewire (no Reports route is moved).

## Goal

Replace the stubbed Fleet Dashboard sidebar entry with the existing Fleet Synthesis flow (filter → matrix → details), then delete the redundant Fleet Synthesis sidebar entry. Routes, URLs, view paths, breadcrumbs, page titles, and headings all rename so no "synthesis" wording survives in the user-facing app or in repo file paths.

This is a relocation + rename refactor. Pages move byte-identical aside from title / heading / `route()` string updates. No new feature, no Livewire component, no DB migration, no seeder data change.

## Out of scope

- Any change to the matrix/details page logic, mock data, or filter behaviour. Pages render identical content under their new addresses.
- Any change to the User Dashboard L2 stub. It stays `pages.stub` until its own spec lands.
- Reports L1 sidebar tree. The `Reports` ancestor in `config/breadcrumbs.php` is repointed at a new default leaf (see below) but no Reports route is renamed.
- A 301 redirect layer from old `/fleet-synthesis*` URLs to the new addresses. The app has no external surface and no bookmarkable user base, so old URLs simply 404.

## Routes & file moves

| Old | New |
|---|---|
| route `reports.fleet-synthesis` · URL `/fleet-synthesis` · view `resources/views/pages/reports/fleet-synthesis.blade.php` | route `dashboard.fleet` · URL `/dashboard/fleet` · view `resources/views/pages/dashboard/fleet.blade.php` |
| route `reports.fleet-synthesis.dashboard` · URL `/fleet-synthesis/dashboard` · view `resources/views/pages/reports/fleet-synthesis/dashboard.blade.php` | route `dashboard.fleet.matrix` · URL `/dashboard/fleet/matrix` · view `resources/views/pages/dashboard/fleet/matrix.blade.php` |
| route `reports.fleet-synthesis.details` · URL `/fleet-synthesis/details` · view `resources/views/pages/reports/fleet-synthesis/details.blade.php` | route `dashboard.fleet.details` · URL `/dashboard/fleet/details` · view `resources/views/pages/dashboard/fleet/details.blade.php` |

`routes/web.php`:
- Delete the three `/fleet-synthesis*` entries inside the `reports.` prefix block (lines 206-208).
- In the `dashboard.` prefix block (line 23-28), replace the stub `['/fleet', 'pages.stub', 'fleet']` with three entries pointing at the new view paths above.

The pre-rename `dashboard.fleet` route resolved to `pages.stub`, so no view-path collision when the new files land.

## Sidebar (`config/navigation.php`)

- Delete line 10 — the `Fleet Synthesis` entry under the Dashboard L1.
- Keep line 9 — `Fleet Dashboard` — exactly as written (`'route' => 'dashboard.fleet'`, `'icon' => 'chart-bar'`). The route name is unchanged; only its target view changes.

After this edit the Dashboard L1 expands to two children: `User Dashboard`, `Fleet Dashboard`.

## Breadcrumbs (`config/breadcrumbs.php`)

Replace lines 11-13:
```php
'reports.fleet-synthesis'           => ['Dashboard', 'Fleet Synthesis'],
'reports.fleet-synthesis.dashboard' => ['Dashboard', 'Fleet Synthesis', 'Dashboard'],
'reports.fleet-synthesis.details'   => ['Dashboard', 'Fleet Synthesis', 'Details'],
```
with:
```php
'dashboard.fleet'         => ['Dashboard', 'Fleet Dashboard'],
'dashboard.fleet.matrix'  => ['Dashboard', 'Fleet Dashboard', 'Matrix'],
'dashboard.fleet.details' => ['Dashboard', 'Fleet Dashboard', 'Details'],
```

Line 194 — repoint the `Reports` ancestor default from the now-deleted `reports.fleet-synthesis` to a real Reports-L1 leaf. Use `'Reports' => 'reports.fleet-commercial.equipment-reliability'` (first child of the Reports L1 sidebar tree). This default is consulted when a breadcrumb path needs an ancestor route for the `Reports` label and that ancestor isn't otherwise resolvable.

## Permissions (`database/seeders/PermissionSeeder.php`)

- Line 21 already declares `['code' => 'dashboard.fleet', 'name' => 'Fleet Dashboard']`. No edit.
- No `reports.fleet-synthesis` permission code exists. Nothing to delete.
- No new sub-permissions for `.matrix` / `.details` — the matrix and details routes inherit from the parent `dashboard.fleet` permission, matching how other nested dashboard pages work in this repo.

## Generator script (`scripts/generate_frontend_pages.php`)

Line 315 declares `'fleet-synthesis' => 'Fleet Synthesis'` inside a reports-loop scaffolder. The actual filter page is hand-written, not generated, so re-running the script with the line present would clobber a real file with a stub. Delete the line.

## In-page wording + internal `route()` calls

### Filter page (`resources/views/pages/dashboard/fleet.blade.php`)

- `@section('title', 'Fleet Synthesis')` → `@section('title', 'Fleet Dashboard')`
- `<x-page-header title="Fleet Synthesis" description="Filter the fleet, then open the colored Dashboard or the detailed task list." />` → `<x-page-header title="Fleet Dashboard" description="Filter the fleet, then open the colored matrix or the detailed task list." />`
- Footer CTA #1 (line 130): `<a href="{{ route('reports.fleet-synthesis.dashboard') }}" class="btn-secondary">Dashboard</a>` → `<a href="{{ route('dashboard.fleet.matrix') }}" class="btn-secondary">Matrix</a>` (relabel avoids "Dashboard button inside the Fleet Dashboard page" ambiguity).
- Footer CTA #2 (line 131): route name updated to `dashboard.fleet.details`; label `Details` unchanged.

### Matrix page (`resources/views/pages/dashboard/fleet/matrix.blade.php`)

- `@section('title', 'Fleet Synthesis — Dashboard')` → `@section('title', 'Fleet Dashboard — Matrix')`
- Eyebrow text on line 93: `Fleet Synthesis` → `Fleet Dashboard`
- H2 on line 94: `Dashboard` → `Matrix` (so the page reads "Fleet Dashboard — Matrix" rather than "Fleet Dashboard — Dashboard").
- Back-button anchor (line 98): `route('reports.fleet-synthesis')` → `route('dashboard.fleet')`.
- Three drill-through cells (lines 168, 176, 184): `route('reports.fleet-synthesis.details')` → `route('dashboard.fleet.details')`.
- Footer SAP-spec ID label `Dummy data · CAM-FS-0100` (line 202) — keep verbatim. References the original SAP spec, not user-facing branding.

### Details page (`resources/views/pages/dashboard/fleet/details.blade.php`)

- `@section('title', 'Fleet Synthesis — Details')` → `@section('title', 'Fleet Dashboard — Details')`.
- Any eyebrow text, `<x-page-header>`, or `route('reports.fleet-synthesis*')` calls inside the file get the same `dashboard.fleet*` rename. Spec only audited the first 60 lines of the 341-line file; full sweep happens during impl. Acceptance check below catches anything missed.

## Module doc update (`docs/modules/dashboard.md`)

- L2 table: drop the `Fleet Synthesis` row. Rewrite the `Fleet Dashboard` row's purpose to: `Filter → matrix → details flow (relocated from Fleet Synthesis on 2026-04-27).`
- **Shipped** section: replace the two existing bullets with `Fleet Dashboard L2 routes to the relocated synthesis filter / matrix / details flow.`
- **Stubbed** section: drop the `Fleet Dashboard → pages.stub` bullet. Keep `User Dashboard → pages.stub`.
- **Last updated**: append `2026-04-27 — Fleet Synthesis content relocated under Fleet Dashboard. Sidebar Fleet Synthesis entry removed. Routes/URLs renamed dashboard.fleet[.matrix|.details]. See spec 2026-04-27-fleet-dashboard-relocate-synthesis-design.md.`

## File touch list

| File | Change |
|---|---|
| `routes/web.php` | Delete 3 fleet-synthesis route entries; replace 1 stub entry with 3 new dashboard.fleet entries |
| `config/navigation.php` | Delete the Fleet Synthesis sidebar entry |
| `config/breadcrumbs.php` | Replace 3 fleet-synthesis crumb entries; repoint `Reports` default-ancestor route |
| `database/seeders/PermissionSeeder.php` | No change (parent permission already exists) |
| `scripts/generate_frontend_pages.php` | Delete the `'fleet-synthesis'` generator entry |
| `resources/views/pages/reports/fleet-synthesis.blade.php` | **Move** to `resources/views/pages/dashboard/fleet.blade.php` + apply title/header/CTA edits |
| `resources/views/pages/reports/fleet-synthesis/dashboard.blade.php` | **Move** to `resources/views/pages/dashboard/fleet/matrix.blade.php` + apply title/eyebrow/H2/route edits |
| `resources/views/pages/reports/fleet-synthesis/details.blade.php` | **Move** to `resources/views/pages/dashboard/fleet/details.blade.php` + apply title and any internal route() edits |
| `docs/modules/dashboard.md` | Update L2 table, Shipped/Stubbed sections, and Last updated entry |

No migration. No seeder data change. No new components in `resources/views/components/`. No new Livewire classes in `app/Livewire/`.

## Acceptance

- Sidebar Dashboard L1 has two children: `User Dashboard`, `Fleet Dashboard`. No `Fleet Synthesis`.
- `/dashboard/fleet` renders the filter screen. Footer CTAs read `Matrix` and `Details`.
- `/dashboard/fleet/matrix` renders the R/A/G colored grid. Eyebrow says `Fleet Dashboard`, H2 says `Matrix`. Back button returns to `/dashboard/fleet`. Drill-through cells link to `/dashboard/fleet/details?…`.
- `/dashboard/fleet/details` renders the task-list table. Page title `Fleet Dashboard — Details`.
- `/fleet-synthesis`, `/fleet-synthesis/dashboard`, `/fleet-synthesis/details` all return 404.
- `git grep -n "fleet-synthesis\|Fleet Synthesis"` returns zero matches across `app/`, `config/`, `database/`, `resources/`, `routes/`, `scripts/`. (`storage/framework/views/` may still hold compiled blade caches — clear with `php artisan view:clear` post-deploy.)

## Risks

- **Compiled view cache.** Production `storage/framework/views/*.php` references old route names by their generated keys. Standard `php artisan view:clear` post-deploy handles it. Already part of the project deploy flow.
- **Breadcrumb default fallback re-point.** Line 194's `'Reports' => 'reports.fleet-commercial.equipment-reliability'` change is benign as long as no breadcrumb in the Reports L1 was relying on the old string match in a way that surfaces the old leaf as a label. Walk each Reports breadcrumb during impl as a sanity pass.
- **Generator-script regeneration.** If `scripts/generate_frontend_pages.php` is rerun after this PR with the `'fleet-synthesis'` line still in, it would re-create a `pages/reports/fleet-synthesis.blade.php` stub — clobbering an unrelated path. Removing the line in this PR closes that hole.
- **Details-page sweep coverage.** Spec only inspected lines 1-60 of the 341-line details file. Full search-and-replace of `reports.fleet-synthesis` and `Fleet Synthesis` happens during impl; the `git grep` acceptance check is the safety net.

## Branch + PR

- Branch: `refactor/fleet-dashboard-relocate-synthesis`, off `origin/master`. Independent of the in-flight `refactor/equipment-card-trim` work — no shared files.
- One PR. Auto-merge squash per repo convention for `refactor/*` branches.
- Commit lead: `refactor(dashboard): move Fleet Synthesis content under Fleet Dashboard and rename routes`.
- PR body should call out: (1) sidebar Fleet Synthesis entry deleted; (2) URLs renamed `/fleet-synthesis*` → `/dashboard/fleet*`; (3) no redirect layer — old URLs 404; (4) page logic byte-identical aside from title / heading / route() edits.
