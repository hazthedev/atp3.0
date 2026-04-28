# Index Actions — View | Edit pair (FL pattern adoption) — Design

**Date:** 2026-04-28
**Modules:** Business Partners (L1 #3) · Inventory (L1 #4) · Human Resources (L1 #5)
**Cross-L1:** Yes — three L1s. User asked to adopt the FL search page's Actions-column pattern across the three master-data index pages. Acknowledged per CLAUDE.md.

## Goal

Adopt the FL search page's `View | Edit` Actions-column pattern on the BP / Item / Employee master-data index pages, by introducing a real read-only `*.show` route alongside each module's existing `*.edit` route. View buttons land on the read-only page; Edit buttons land on the same form pre-opened for editing. Index lead-column anchors switch to the read-only `*.show` route so the dominant click path lands read-only first.

## Out of scope

- DB schema changes. No new columns, no migrations.
- Form re-architecture. The existing form partials (BP, Item) and the existing `EmployeeMasterDataForm` Livewire class stay; we add a single readonly-flag pass-through.
- Other modules' index pages (User Management, MRO Work Order, Reports, etc.). Spec scope is the three URLs the user named.
- A redirect layer for old `/edit` URLs. Old URLs continue to resolve — same view file, behavior changes only in initial editing state. No external surface to break.
- Adding a `*.show` route for any module that already lacks an `*.edit` route. Spec only touches modules where the route pair has a known asymmetry.

## Background — current state

All three pages already implement the editMode pattern with `data-edit-scope` and `[data-editing]` attributes per CLAUDE.md, and currently default to **read-only with an Edit Record toggle**:

- BP and Item form partials wrap content in `editMode(false)` Alpine component (always starts read-only).
- Employee Livewire form blade uses inline `x-data="{ editing: false, ... }"`.

So today's `*.edit` URLs land read-only-with-toggle. There is no `*.show` route. Lead-column anchors on the indexes route to `*.edit` because that's the only entry point that exists.

The FL search page works differently: it has both `fleet.functional-location.show` and `fleet.functional-location.edit` routes. Both include the same partial (`functional-location-show-page`) but pass different `$readonly` values. Combined with the Edit Record toggle, this gives FL three states a user can be in: read-only show, editing show (toggled in), and direct-edit (URL pre-opened editing).

## Routes

`routes/web.php` — three new entries inserted next to the existing `*.edit` routes:

```php
// hr group
['/employee-master-data/{id}', 'pages.hr.employee-master-data.show', 'employee-master-data.show'],
['/employee-master-data/{id}/edit', 'pages.hr.employee-master-data.edit', 'employee-master-data.edit'],

// system group
['/item-master-data/{id}', 'pages.system.item-master-data.show', 'item-master-data.show'],
['/item-master-data/{id}/edit', 'pages.system.item-master-data.edit', 'item-master-data.edit'],
['/business-partner-master-data/{id}', 'pages.system.business-partner-master-data.show', 'business-partner-master-data.show'],
['/business-partner-master-data/{id}/edit', 'pages.system.business-partner-master-data.edit', 'business-partner-master-data.edit'],
```

URL choice: `/.../{id}` for show, `/.../{id}/edit` for edit. No `/edit` suffix on the show route — matches FL and Laravel REST convention.

## View files

### Business Partner Master Data

- **New** `resources/views/pages/system/business-partner-master-data/show.blade.php`:
  ```blade
  @extends('layouts.app')

  @section('title', 'Business Partner Master Data')

  @section('content')
      @include('pages.system.business-partner-master-data.partials.form', [
          'mode' => 'show',
          'recordId' => request()->route('id'),
      ])
  @endsection
  ```
- **Existing** `edit.blade.php` already passes `mode=edit` — no change.
- **Modify** `resources/views/pages/system/business-partner-master-data/partials/form.blade.php` line 127: `<div x-data="editMode(false)" data-edit-scope ...>` → `<div x-data="editMode({{ $isEdit ? 'true' : 'false' }})" data-edit-scope ...>`. The partial already computes `$isEdit = $mode === 'edit'` on line 3, so no new variable.

### Item Master Data

- **New** `resources/views/pages/system/item-master-data/show.blade.php` — same shape as BP show, with `'mode' => 'show'`.
- **Existing** `edit.blade.php` passes `mode=edit` — no change (verify during impl; mirror BP if absent).
- **Modify** `resources/views/pages/system/item-master-data/partials/form.blade.php` line 104: same `editMode($isEdit)` swap as BP.

### Employee Master Data

- **New** `resources/views/pages/hr/employee-master-data/show.blade.php`:
  ```blade
  @extends('layouts.app')

  @section('title', 'Employee Master Data')

  @section('content')
      @livewire('hr.employee-master-data-form', [
          'employeeId' => (int) request()->route('id'),
          'initialEditing' => false,
      ])
  @endsection
  ```
- **Modify** `resources/views/pages/hr/employee-master-data/edit.blade.php` to pass `'initialEditing' => true` to the same `@livewire` call. Mount signature mirrors current call site, just with the new flag.
- **Modify** `app/Livewire/Hr/EmployeeMasterDataForm.php`:
  - Add `public bool $initialEditing = false;`
  - Update `mount()` signature to accept the flag and assign to the property. The flag is consumed by the blade only — does not persist or affect Livewire state.
- **Modify** `resources/views/livewire/hr/employee-master-data-form.blade.php` line 14: `x-data="{ editing: false, activeTab: 'address' }"` → `x-data="{ editing: @json($this->initialEditing), activeTab: 'address' }"`. Use `@json` for proper boolean serialization.

## Index page Actions columns

Shared `View | Edit` button pair shape (mirrors FL search page lines 44-47):

```blade
<td class="table-td">
    <div class="flex gap-2">
        <a href="{{ route('....show', ['id' => $r->id]) }}" class="btn-ghost px-3">View</a>
        <a href="{{ route('....edit', ['id' => $r->id]) }}" class="btn-secondary px-3">Edit</a>
    </div>
</td>
```

### BP index — `resources/views/pages/system/business-partner-master-data/index.blade.php`

- Lead-column anchor (`Code` cell, line 56-57): `route('system.business-partner-master-data.edit', ...)` → `route('system.business-partner-master-data.show', ...)`. Same `font-semibold text-blue-600 hover:underline` styling.
- Actions cell (line 67-69): replace the lone `<a class="btn-secondary px-3">Edit</a>` with the shared `View | Edit` div above. Header label `Actions` unchanged. `data-sortable="false"` on the header stays.

### Item index — `resources/views/pages/system/item-master-data/index.blade.php`

- Lead-column anchor (Item No. cell, line 58-60): `*.edit` → `*.show` swap.
- **Add** an Actions column where none exists today:
  - Header: `<th class="table-th" data-sortable="false">Actions</th>` after `<th class="table-th">Item Type</th>` (the current last header).
  - Body cell: `<td class="table-td">` with the shared `View | Edit` div, after the existing last cell (`{{ $item->item_type }}`).
- The page goes from 17 columns to 18.

### Employee index — `resources/views/livewire/hr/employee-index-page.blade.php`

- Lead-column anchor (Employee No. cell, line 30): `route('hr.employee-master-data.edit', ...)` → `route('hr.employee-master-data.show', ...)`.
- **Add** an Actions column:
  - Header: `<th class="table-th" data-sortable="false">Actions</th>` after `<th class="table-th">Status</th>`.
  - Body cell: `<td class="table-td">` with the shared `View | Edit` div, after the existing Status cell.

## Breadcrumbs (`config/breadcrumbs.php`)

Insert next to the existing entries:

```php
'system.item-master-data.show'             => ['Administration', 'Item Master Data', 'View'],
'system.business-partner-master-data.show' => ['Business Partners', 'Business Partner Master Data', 'View'],
'hr.employee-master-data.show'             => ['Human Resources', 'Employee Master Data', 'View'],
'hr.employee-master-data.edit'             => ['Human Resources', 'Employee Master Data', 'Edit'],
```

The fourth line covers an existing gap — `hr.employee-master-data.edit` had no breadcrumb entry before this PR.

## Sidebar active-route highlighting (`config/navigation.php`)

- BP entry (lines 84-89): add `'system.business-partner-master-data.show'` to the `active_routes` array.
- Item entry (lines 100-105): add `'system.item-master-data.show'` to the `active_routes` array.
- Employee entry (line 113): currently has no `active_routes`. Add one:
  ```php
  ['label' => 'Employee Master Data', 'route' => 'hr.employee-master-data', 'icon' => 'user-circle',
   'active_routes' => ['hr.employee-master-data', 'hr.employee-master-data.show', 'hr.employee-master-data.edit']],
  ```

## Acceptance

- `/system/business-partner-master-data/300028` (no `/edit`) renders the BP form **read-only by default** with the Edit Record toggle visible. Clicking the toggle enables the inputs.
- `/system/business-partner-master-data/300028/edit` renders the same form **with editing pre-enabled** — the Edit Record toggle is in its open state on first paint; user can collapse back via the same toggle.
- Same pair-behavior on `/system/item-master-data/{id}` and `/hr/employee-master-data/{id}`.
- Each of the three index pages has an Actions column with `View | Edit` buttons. View → `*.show`, Edit → `*.edit`. Lead-column anchors route to `*.show`.
- Sidebar Dashboard L1 entry stays highlighted on any of `*.index`, `*.show`, `*.edit` for all three modules.
- Breadcrumbs on a show page read `… › View`. Breadcrumbs on an edit page read `… › Edit`.
- Old `/edit` URLs continue to resolve. No 404s, no redirects.
- `php artisan route:list | grep -E "(business-partner|item-master-data|employee-master-data)\.(show|edit)"` shows 6 route names total — three `.show` + three `.edit`.

## Risks

- **Behavior change on existing `*.edit` URLs.** Today they land read-only-with-toggle; after this PR they land already-open-for-editing. Mitigation: lead-column anchors on the index pages flip to `*.show`, so the dominant user-driven nav path (click record → land read-only) stays intact. Only direct typed/bookmarked `/edit` URLs experience the change. Documented in PR body.
- **Form-partial behavior on the existing edit page.** Both `partials/form.blade.php` files compute `$isEdit = $mode === 'edit'` already and use it for body checks. The wrapper-div change `editMode(false) → editMode($isEdit)` is a one-line swap; risk that some partial body code assumed the wrapper always starts non-editing — none found during audit, but worth a visual check on the edit page after impl.
- **Employee Livewire mount signature.** Adding `bool $initialEditing = false` to `mount()` is backward-compatible (default false). Other call sites (currently only `edit.blade.php`) get explicit `initialEditing => true`. Existing `EmployeeMasterDataFormTest` should keep passing — tests instantiate the component without the flag and the default keeps them green.
- **`@json($this->initialEditing)` in Alpine `x-data`.** The Livewire blade refers to `$this->initialEditing` (Livewire component property). Verify the existing blade uses similar `$this->...` references — quick check during impl. If the partial pattern doesn't bind `$this`, fall back to `{{ $initialEditing ? 'true' : 'false' }}` literal interpolation.
- **Cross-L1 reach.** Same three L1s as PR #94. No new module touched.
- **Item index column count.** Goes from 17 to 18. Already wider than viewport at common sizes; this PR makes it slightly worse. Out of scope per content-vs-design boundary, but flagging because the Actions column is being introduced fresh on this page.

## File touch list

| File | Change |
|---|---|
| `routes/web.php` | +3 `*.show` route entries |
| `config/navigation.php` | +`active_routes` entries (1 for BP, 1 for Item, new array for Employee) |
| `config/breadcrumbs.php` | +3 `*.show` entries, +1 missing `hr.employee-master-data.edit` entry |
| `resources/views/pages/system/business-partner-master-data/show.blade.php` | **New** — 5-line wrapper |
| `resources/views/pages/system/business-partner-master-data/partials/form.blade.php` | Wrapper div: `editMode(false)` → `editMode({{ $isEdit ? 'true' : 'false' }})` |
| `resources/views/pages/system/business-partner-master-data/index.blade.php` | Lead-anchor → `*.show`; Actions cell → `View \| Edit` pair |
| `resources/views/pages/system/item-master-data/show.blade.php` | **New** — 5-line wrapper |
| `resources/views/pages/system/item-master-data/partials/form.blade.php` | Wrapper div: same `editMode($isEdit)` swap |
| `resources/views/pages/system/item-master-data/index.blade.php` | Lead-anchor → `*.show`; new Actions column with `View \| Edit` pair |
| `resources/views/pages/hr/employee-master-data/show.blade.php` | **New** — Livewire mount with `initialEditing => false` |
| `resources/views/pages/hr/employee-master-data/edit.blade.php` | Mount call gains `initialEditing => true` |
| `resources/views/livewire/hr/employee-master-data-form.blade.php` | `x-data` editing initial → `@json($this->initialEditing)` |
| `app/Livewire/Hr/EmployeeMasterDataForm.php` | `+public bool $initialEditing = false;` + `mount` param |
| `resources/views/livewire/hr/employee-index-page.blade.php` | Lead-anchor → `*.show`; new Actions column with `View \| Edit` pair |
| `docs/modules/business-partners.md` | Last-updated entry referencing this spec |
| `docs/modules/inventory.md` | Last-updated entry referencing this spec |
| `docs/modules/human-resources.md` | Last-updated entry referencing this spec; note the `EmployeeMasterDataForm` gains an `$initialEditing` prop |

No DB migration. No seeder change. No new components in `resources/views/components/`. No new Livewire classes.

## Branch + PR

- Branch: `refactor/index-actions-view-edit-pair`, off `origin/master`.
- One PR. Auto-merge squash per repo convention for `refactor/*` branches.
- Commit lead: `refactor(ui): add show routes + View|Edit Actions pair to BP / Item / Employee`.
- PR body: (1) cross-L1 design unification per FL pattern; (2) new `*.show` routes — no breaking URL changes; (3) **behavior change** on existing `*.edit` URLs — they now pre-open editing (was read-only-with-toggle); (4) lead-column anchors on indexes flip to `*.show` so the dominant nav path still lands read-only; (5) `EmployeeMasterDataForm` gains an `$initialEditing` prop; (6) module docs updated for all three L1s.
- Deploy: standard cPanel flow — `php artisan route:cache` (routes added), `php artisan view:clear`, `php artisan config:cache`.
