# Equipment Index - Actions And FL Parity Alignment - Design

**Date:** 2026-04-28
**Module:** Fleet Management (L1 #7) -> Equipment index page
**Scope:** Single page only - `/fleet/equipment`

## Goal

Bring the Equipment index page into parity with the recent FL-derived index pattern used elsewhere in the system, while preserving the Equipment page's existing chevron-circle `ID` lead cell by explicit user choice.

The user-approved direction is:

- keep the current chevron-circle `ID` cell
- add an `Actions` column with `View | Edit`
- perform a broader parity pass around the table shell where needed, without replacing the lead-cell treatment

## Out of scope

- Equipment detail page restructuring
- Equipment data-source changes
- Functional Location table changes
- Removing the chevron-circle `ID` pattern
- Column-content cleanup unrelated to the parity shell
- Route changes, DB changes, seeder changes

## Current state

`resources/views/livewire/fleet/equipment-index-page.blade.php` already uses the shared `<x-data-table datatable>` shell and already has:

- page header
- browse-count subhead
- empty-state props
- `table-th`, `table-row`, `table-td` utilities
- status badges

The main remaining parity gap versus the other recent index-table tasks is:

- there is no `Actions` column
- the page uses a custom chevron-circle `ID` lead cell instead of the simpler linked-text lead cell used on BP / Item / HR

The chevron-circle difference is intentional for this task, because the user explicitly chose to keep it.

## Approved design

### Lead cell

Keep the current `ID` cell exactly as-is:

- blue circular chevron icon
- linked `ID` text
- same target route currently used by the row

This is the approved Equipment-specific exception to the simpler linked-text lead-cell pattern.

### Actions column

Add an `Actions` column at the end of the table:

- header: `Actions`
- header must remain non-sortable via `data-sortable="false"`
- body cell contains:
  - `View` button using `btn-ghost px-3`
  - `Edit` button using `btn-secondary px-3`

### Route behavior

Use the Equipment page's existing row-detail route as the `View` destination.

For `Edit`, implementation should use the canonical Equipment edit route already present in the repo. If the current Equipment index only exposes a single detail route, implementation should confirm and wire the edit button to the correct existing edit endpoint rather than inventing a new route.

### Parity rules

Keep the rest of the page aligned with the FL-based table shell:

- keep `<x-data-table datatable>`
- keep the browse-count line
- keep the empty-state props
- keep `table-th`, `table-row`, `table-td`
- keep the status badge treatment

This is a parity pass around the shell and actions workflow, not a redesign of Equipment column content.

## File touch list

- `resources/views/livewire/fleet/equipment-index-page.blade.php`
- `docs/modules/fleet-management.md`

Additional read-only verification may inspect route definitions or existing Equipment page links, but no other files are expected to change unless a route-target adjustment is required.

## Acceptance

- `/fleet/equipment` keeps the existing chevron-circle `ID` lead cell.
- The table gains an `Actions` column as the last visible column.
- Each row shows `View | Edit` actions.
- The `Actions` header is non-sortable.
- Existing datatable behavior, status badges, and content columns remain intact.
- No unintended change is made to `/fleet/functional-location` or other Fleet list pages.

## Risks

- **Edit-route ambiguity.** If Equipment currently routes only to a detail/card page from the index, implementation must resolve which existing route is the canonical edit destination. The fix should reuse an existing route, not create a new one.
- **Wide table width.** Equipment already has many columns. Adding `Actions` increases width slightly; horizontal scroll behavior is expected to remain the same.
- **Exception to simple lead-link parity.** This page will intentionally differ from BP / Item / HR by keeping the chevron-circle lead cell. That is a user-directed exception, not design drift.

## Verification

- Open `/fleet/equipment`
- Confirm the chevron-circle `ID` cell is unchanged
- Confirm `Actions` appears as the last header
- Confirm each row shows `View | Edit`
- Confirm the page still sorts/searches/paginates as before
