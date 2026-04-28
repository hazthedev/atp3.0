# Master Data Route Module Rename - Design

**Date:** 2026-04-28
**Modules:** Business Partners - Inventory - Human Resources
**Cross-L1:** Yes - three module groups. User requested a clean route-root rename with no legacy aliases.

## Goal

Rename the three master-data route families so both the URL paths and the route names align with their destination modules:

- Business Partner Master Data
  - from `/system/business-partner-master-data...`
  - to `/business-partners/business-partner-master-data...`
  - from `system.business-partner-master-data.*`
  - to `business-partners.business-partner-master-data.*`
- Item Master Data
  - from `/system/item-master-data...`
  - to `/inventory/item-master-data...`
  - from `system.item-master-data.*`
  - to `inventory.item-master-data.*`
- Employee Master Data
  - from `/hr/employee-master-data...`
  - to `/human-resources/employee-master-data...`
  - from `hr.employee-master-data.*`
  - to `human-resources.employee-master-data.*`

The old URLs and old route names stop working completely. No redirect layer, no compatibility aliases.

## Out of scope

- Any visual or form-content changes inside the three modules.
- Permission-code renames unless a code path is proven to depend on route-name strings.
- Redirects from old URLs to new URLs.
- Renaming unrelated `system.*`, `hr.*`, or other route families.
- Reorganizing view file locations. Existing Blade and Livewire views stay where they are unless a route target is broken.

## Current state

`routes/web.php` currently defines:

- `Route::prefix('system')->name('system.')` for both Business Partner Master Data and Item Master Data
- `Route::prefix('hr')->name('hr.')` for Employee Master Data

The rest of the app links into those families through named routes in:

- `config/navigation.php`
- `config/breadcrumbs.php`
- page and Livewire blades using `route(...)`
- docs and module notes that mention current URLs and route names

Recent work added `show` routes and `View | Edit` pairs to all three modules, so each family now has multiple named endpoints. That makes a route-name cleanup higher impact than a path-only change, but still straightforward if we change the source-of-truth route groups first and then update every consumer.

## Approaches considered

### 1. Keep route names, change only paths

Lowest risk, but leaves the codebase with mismatched module naming (`system.*` routes that live under `/inventory/...` and `/business-partners/...`). Rejected because the user explicitly chose the clean rename path.

### 2. Rename paths and route names together

Recommended. The route table becomes consistent with the information architecture, and the app no longer carries the old module vocabulary.

### 3. Add parallel new routes and remove old ones later

Softens rollout risk, but contradicts the user requirement that old URLs should stop working completely and leaves duplicate names/paths during the transition.

## Proposed design

### Route groups

Update `routes/web.php` so the three families move to new prefixes and new name roots:

```php
Route::prefix('business-partners')->name('business-partners.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/business-partner-master-data', 'pages.system.business-partner-master-data.index', 'business-partner-master-data.index'],
        ['/business-partner-master-data/create', 'pages.system.business-partner-master-data.create', 'business-partner-master-data.create'],
        ['/business-partner-master-data/{id}', 'pages.system.business-partner-master-data.show', 'business-partner-master-data.show'],
        ['/business-partner-master-data/{id}/edit', 'pages.system.business-partner-master-data.edit', 'business-partner-master-data.edit'],
    ]);
});

Route::prefix('inventory')->name('inventory.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/item-master-data', 'pages.system.item-master-data.index', 'item-master-data.index'],
        ['/item-master-data/create', 'pages.system.item-master-data.create', 'item-master-data.create'],
        ['/item-master-data/{id}', 'pages.system.item-master-data.show', 'item-master-data.show'],
        ['/item-master-data/{id}/edit', 'pages.system.item-master-data.edit', 'item-master-data.edit'],
    ]);
});

Route::prefix('human-resources')->name('human-resources.')->group(function () use ($registerRoutes): void {
    $registerRoutes([
        ['/employee-master-data', 'pages.hr.employee-master-data.index', 'employee-master-data'],
        ['/employee-master-data/{id}', 'pages.hr.employee-master-data.show', 'employee-master-data.show'],
        ['/employee-master-data/{id}/edit', 'pages.hr.employee-master-data.edit', 'employee-master-data.edit'],
    ]);
});
```

Important detail: the route target views stay unchanged. This is a routing rename, not a view-tree rename.

### Consumer updates

Update all first-party references to the old route names and old literal paths:

- `config/navigation.php`
  - Business Partner navigation entry route and `active_routes`
  - Item navigation entry route and `active_routes`
  - Employee navigation entry route and `active_routes`
- `config/breadcrumbs.php`
  - all breadcrumb keys for the renamed route families
  - any breadcrumb jump targets keyed to the old names
- Blade and Livewire views
  - all `route('system.business-partner-master-data...')`
  - all `route('system.item-master-data...')`
  - all `route('hr.employee-master-data...')`
- Docs
  - user-facing route examples in module docs and current design notes where these URLs are described as the live path

### Hardcoded path scan

Run a repo-wide scan for the three old path roots:

- `/system/business-partner-master-data`
- `/system/item-master-data`
- `/hr/employee-master-data`

Any production-facing usage should be updated. Historical design docs may be left as historical records unless they are meant to document current live routes.

## Acceptance

- `/business-partners/business-partner-master-data` resolves and all internal app links point there.
- `/inventory/item-master-data` resolves and all internal app links point there.
- `/human-resources/employee-master-data` resolves and all internal app links point there.
- The old index, show, create, and edit URLs under `/system/...` and `/hr/...` for these three modules return 404.
- `php artisan route:list` shows only the new route names:
  - `business-partners.business-partner-master-data.*`
  - `inventory.item-master-data.*`
  - `human-resources.employee-master-data.*`
- Sidebar active-state logic still highlights correctly on index, show, create, and edit pages for all three modules.
- Breadcrumbs still render correctly on all three modules.

## Risks

- **Broad route-name touch surface.** This is larger than a path-only move because every named-route consumer must be updated. Mitigation: repo-wide search by old route-name prefix and old literal URL.
- **Old bookmarks break by design.** This is intentional per user instruction. No mitigation beyond clear deploy awareness.
- **Docs drift.** Older specs and module notes may still mention the previous paths. Mitigation: update current module docs and any current-facing design doc references that could mislead future work.
- **Cache confusion after deploy.** A stale route cache would make the deployment look broken. Mitigation: refresh route and config caches during deploy.

## File touch list

Expected implementation touch points:

- `routes/web.php`
- `config/navigation.php`
- `config/breadcrumbs.php`
- route-using blades under `resources/views/pages/system/business-partner-master-data/`
- route-using blades under `resources/views/pages/system/item-master-data/`
- route-using blades under `resources/views/pages/crm/business-partner/`
- route-using blades under `resources/views/livewire/hr/`
- route-using blades under `resources/views/pages/hr/employee-master-data/`
- `resources/views/pages/dashboard.blade.php`
- `docs/modules/business-partners.md`
- `docs/modules/inventory.md`
- `docs/modules/human-resources.md`

Additional files may be included if the repo-wide search finds more old route-name or old path usage.

## Verification

- `php artisan route:list --name=business-partners.business-partner-master-data`
- `php artisan route:list --name=inventory.item-master-data`
- `php artisan route:list --name=human-resources.employee-master-data`
- `php artisan view:clear`
- deploy reminder for cPanel after merge:
  - `git pull`
  - `php artisan view:clear`
  - `php artisan route:cache`
  - `php artisan config:cache`

## Implementation note

This work should be done as a single pass: route groups first, then global route-name/path replacement for the three families, then route-list verification. Because the user requested the clean rename path, we should not leave temporary aliases or redirects behind.
