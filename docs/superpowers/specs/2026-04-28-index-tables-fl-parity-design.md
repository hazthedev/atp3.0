# Index tables — FL parity pass — Design

**Date:** 2026-04-28
**Modules:** Business Partners (L1 #3) · Inventory (L1 #4) · Human Resources (L1 #5)
**Cross-L1:** Yes — three L1s. The user-stated goal is to standardize the table design as a system-wide pattern; cross-L1 reach is intentional. Per CLAUDE.md the cross-L1 scope is acknowledged in advance.

## Goal

Bring the three master-data index pages — Business Partner, Item, Employee — to design parity with the canonical FL search index ([resources/views/livewire/fleet/functional-location-search-page.blade.php](resources/views/livewire/fleet/functional-location-search-page.blade.php)). Cell-level utility classes, the `<x-data-table>` props pattern, the `datatable` directive, the "Browse N records" subhead, and the lead-column link treatment unify across all three pages. Page-specific content (column sets, data sources, action presence) is untouched.

## Out of scope

- Column sets, data sources, row contents on any of the three pages.
- The arrow-chevron lead-column variant (`<x-enterprise.table-cell variant="arrow">`). CLAUDE.md reserves it for list views whose source spec calls for it; none of the three pages' specs do.
- The Item page's 17-column horizontal-overflow problem. Pure design-pattern pass; column-priority and responsive-truncation decisions are content-shape issues for a separate spec.
- Other index pages elsewhere in the system (User Management, MRO Work Order, etc.). Spec scope is the three URLs the user named.
- The Employee page's status-pill column. It's a column unique to Employee; styling decisions there are content, not design drift.

## Design system reference

[resources/views/livewire/fleet/functional-location-search-page.blade.php](resources/views/livewire/fleet/functional-location-search-page.blade.php) is the canonical pattern per CLAUDE.md. The shape of a parity-compliant index page:

```blade
<div class="space-y-6">
    <x-page-header title="..." description="...">
        {{-- optional: actions slot for "New X" buttons --}}
    </x-page-header>

    <p class="text-sm text-gray-500">Browse {{ $records->count() }} records.</p>

    <x-data-table
        :empty="$records->isEmpty()"
        empty-label="No records found"
        empty-description="..."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">...</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($records as $record)
                <tr class="table-row">
                    <td class="table-td">
                        <a href="..." class="font-semibold text-blue-600 hover:underline">{{ $record->code }}</a>
                    </td>
                    {{-- ... --}}
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
```

The FL page itself uses `<x-enterprise.table-cell variant="arrow">` on the ID column; the three target pages keep a plain link instead, per the Q1 catalog-rule decision.

## Per-page edits

### Business Partner Master Data — `resources/views/pages/system/business-partner-master-data/index.blade.php`

- After the `<x-page-header>` block, add `<p class="text-sm text-gray-500">Browse {{ count($partners) }} business partner records.</p>`.
- `<x-data-table datatable>` → `<x-data-table :empty="count($partners) === 0" empty-label="No business partners found" empty-description="Try a different code, name, or BP group." search-meta="" datatable>`.
- Every `<th>` (9 cells) → `<th class="table-th">`. Preserve the `data-sortable="false"` on the Actions header.
- `<tr class="hover:bg-neutral-secondary-soft cursor-pointer">` → `<tr class="table-row">`.
- Every `<td>` (9 cells) → `<td class="table-td">`. Drop the inline `font-medium text-heading whitespace-nowrap` from the Code cell — the `table-td` utility already covers that visual.
- Code-column anchor: `class="font-semibold text-[#2f5bff] transition hover:text-[#284ef0] hover:underline"` → `class="font-semibold text-blue-600 hover:underline"`.
- Edit-button anchor: replace the bespoke 7-class inline-styled anchor (`inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-[#9fb2ff] hover:text-[#2f5bff]`) with `class="btn-secondary px-3"`.

### Item Master Data — `resources/views/pages/system/item-master-data/index.blade.php`

- "Browse N item master records" line stays — already present.
- `<x-data-table datatable>` → `<x-data-table :empty="$items->isEmpty()" empty-label="No items found" empty-description="Try a different item number, description, or class." search-meta="" datatable>`.
- Every `<th>` (17 cells) → `<th class="table-th">`. Preserve the existing `class="w-10" data-sortable="false"` on the row-index column by composing → `class="table-th w-10" data-sortable="false"`.
- `<tr class="hover:bg-neutral-secondary-soft">` → `<tr class="table-row">`.
- Every `<td>` (17 cells) → `<td class="table-td">`. Preserve `text-right` on the In-Stock cell by composing → `class="table-td text-right"`. Drop the inline `font-medium whitespace-nowrap` from the Item No. cell.
- Item-No.-column anchor: same `font-semibold text-blue-600 hover:underline` swap as BP.

### Employee Master Data — `resources/views/livewire/hr/employee-index-page.blade.php`

- Drop the outer `<x-card padding="p-0">` wrapper. The `<x-data-table>` sits bare under the page header, matching FL.
- After the `<x-page-header>`, add `<p class="text-sm text-gray-500">Browse {{ $employees->count() }} employee master records.</p>`.
- `<x-data-table>` → `<x-data-table :empty="$employees->isEmpty()" empty-label="No employees found" empty-description="Try a different employee number, name, or department." search-meta="" datatable>`. Adds the missing `datatable` directive (currently no client-side search/sort/pagination on this page) and the props.
- `@forelse … @empty` block → plain `@foreach`. The empty-state UX moves to the `<x-data-table>` props.
- Drop the developer-only seeder hint (`Run php artisan db:seed --class=EmployeeSeeder to load samples.`) — it's developer copy that doesn't belong on a prod page; the seeder is already documented in the HR module doc and the factory.
- Employee-No. cell: replace the chevron-circle widget — currently a `<span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">` wrapping `<x-icon name="chevron-right">` next to the employee number — with a plain link: `<a href="..." class="font-semibold text-blue-600 hover:underline">{{ $employee->employee_no }}</a>`.
- Status-pill cell stays as-is (column unique to Employee, content not design drift).

## Acceptance

- All three pages render with `<th class="table-th">`, `<tr class="table-row">`, `<td class="table-td">` cell-level utilities. No bare `<th>` / `<td>` and no inline `hover:bg-neutral-secondary-soft` `<tr>` overrides on these three files.
- All three pages pass `:empty`, `empty-label`, `empty-description`, `search-meta` on `<x-data-table>`.
- Employee page has the `datatable` directive — the search box, sortable headers, and pagination footer appear and work after `php artisan view:clear`.
- Employee page has no `<x-card>` wrapper around the data-table.
- All three pages have a `<p class="text-sm text-gray-500">Browse …</p>` subhead directly under the page header.
- Lead identifier anchors on all three pages render as `font-semibold text-blue-600 hover:underline`. No inline `text-[#2f5bff]` hex anywhere; no chevron-circle widget on the Employee page.
- BP Edit button uses `class="btn-secondary px-3"`. No bespoke 7-class inline-styled anchor on the page.
- The seeder hint in the Employee empty-state is gone.
- `git grep -n "text-\[#2f5bff\]"` returns zero matches (those two cells were the only callers).
- `git grep -n "hover:bg-neutral-secondary-soft"` returns zero matches across the three target files.

## Risks

- **Employee seeder hint loss.** The current Employee empty-state tells a developer to run `php artisan db:seed --class=EmployeeSeeder`. That hint disappears with the props pattern. The seeder is already documented in `docs/modules/human-resources.md` and the factory comments, so the practical loss is small. If lost dev-discoverability becomes a problem, a `@env('local')` conditional below the empty-state can re-introduce it without polluting prod. Default in this spec is to drop it.
- **Item page horizontal overflow.** Cell-class normalization doesn't fix the 17-column-wide layout. Visual scroll behavior is unchanged from current. Out of scope per content-vs-design boundary.
- **`<x-card>` removal on Employee.** Slight DOM shape change under the page header. Brings the page visually closer to FL. Eyeball after deploy + `php artisan view:clear`.
- **Cross-L1 reach.** Three module docs touched in one PR. Per CLAUDE.md the cross-L1 ack is in this spec; if the user prefers per-L1 PRs, the work splits cleanly along the three index files plus their respective module docs.
- **`<x-data-table>` empty-state behavior.** Confirmed during audit that the data-table component renders empty-label / empty-description from props when `:empty="true"`; no call-site empty markup is needed.

## File touch list

| File | Change |
|---|---|
| `resources/views/pages/system/business-partner-master-data/index.blade.php` | Cells, props, "Browse N" line, lead-link color, Edit button class |
| `resources/views/pages/system/item-master-data/index.blade.php` | Cells, props, lead-link color |
| `resources/views/livewire/hr/employee-index-page.blade.php` | Drop `<x-card>` wrapper, add `datatable` + props, drop `@forelse @empty`, drop chevron-circle widget, "Browse N" line |
| `docs/modules/business-partners.md` | Last-updated entry referencing this spec |
| `docs/modules/inventory.md` | Last-updated entry referencing this spec |
| `docs/modules/human-resources.md` | Last-updated entry referencing this spec; chevron-circle widget removed |

No new components in `resources/views/components/`. No new Livewire classes. No new routes. No DB migration. No seeder change. No JS payload change.

## Branch + PR

- Branch: `refactor/index-tables-fl-parity`, off `origin/master`.
- One PR. Auto-merge squash per repo convention for `refactor/*` branches.
- Commit lead: `refactor(ui): align BP / Item / Employee index tables with FL data-table reference`.
- PR body should call out: (1) cross-L1 design unification per user direction; (2) cell-level + props + datatable directive parity; (3) lead-column anchor unified to `text-blue-600`; (4) Employee chevron-circle widget removed; (5) no behavior change beyond Employee gaining client-side search/sort/pagination via the previously-missing `datatable` directive.
- Deploy reminder: standard cPanel flow — `php artisan view:clear`, `php artisan config:cache`. No route or migration changes, so `route:cache` and `migrate` are unnecessary.
