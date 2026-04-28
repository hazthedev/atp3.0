# Equipment Index - SAP Content Follow-up - Design

**Date:** 2026-04-28
**Module:** Fleet Management (L1 #7) -> Equipment index page
**Scope:** Single page only - `/fleet/equipment`

## Goal

Update the Equipment index table so its visible content follows the user-provided SAP screenshot sample, while preserving the already-approved Equipment page behavior:

- keep the existing chevron-circle `ID` lead cell
- keep the `Actions` column added in the prior Equipment parity change
- use the screenshot rows as the table data shown on `/fleet/equipment`
- remove the visible owner/operator code columns from this page

## Out of scope

- Equipment detail/card page changes
- New routes or route renames
- Functional Location table changes
- Shared catalog changes that would affect other Equipment or Fleet pages
- Removing the `Actions` column
- Replacing the chevron-circle `ID` cell

## Current state

After the previous Equipment parity pass, `/fleet/equipment` currently has:

- the existing chevron-circle `ID` lead cell
- an `Actions` column with `View | Edit`
- the legacy content columns including:
  - `Op. Code`
  - `Ow. Code`

The user now wants the page content to more closely follow the SAP screenshot sample, specifically:

- use the first three screenshot rows as the table data
- remove the visible code columns

## Approved design

### Visible columns

The final visible columns should be:

- `ID`
- `Item No.`
- `Item Name`
- `Serial Number`
- `Old`
- `Category Part`
- `Variant`
- `Status`
- `Father Object`
- `Father Reference`
- `Operator Name`
- `Owner Name`
- `Actions`

Remove these visible columns from `/fleet/equipment`:

- `Op. Code`
- `Ow. Code`

### Visible rows

Use the three rows shown in the screenshot as the table content on this page:

1. `1 | AW139 | AW139 | 31324 |  |  | AW139 | On Aircraft | Functional Location | AW139 / M104-04 | *WESTSTAR | *WESTSTAR`
2. `2 | 4G1860F00113 | Kit MVA Assy | R94 |  | O/C | AW139 | On Aircraft | Functional Location | AW139 / M104-04 | *WESTSTAR | *WESTSTAR`
3. `3 | 4G1860F00113A1 | VIBRATION ABS DAT0011 |  |  | H/T LLP | AW139 | Removed |  |  | *WESTSTAR | *WESTSTAR`

### Interaction behavior

Keep existing Equipment-specific behavior:

- the `ID` cell keeps the chevron-circle linked treatment
- `Actions` stays as the last column
- `View | Edit` actions remain intact
- the shared `<x-data-table datatable>` shell remains intact

### Data-scope rule

Implementation should keep this page-level where practical. If the current rows come from a shared Equipment source, the search page should narrow or transform its own dataset rather than broadly mutating shared content used elsewhere.

## File touch list

- `resources/views/livewire/fleet/equipment-index-page.blade.php`
- `app/Livewire/Fleet/EquipmentIndexPage.php`
- `docs/modules/fleet-management.md`

## Acceptance

- `/fleet/equipment` shows only the approved visible columns.
- `Op. Code` and `Ow. Code` are no longer visible on the Equipment table.
- The three screenshot rows are the visible data on the page.
- The chevron-circle `ID` lead cell remains unchanged.
- The `Actions` column remains present and working.
- No unintended change is made to other Fleet pages.

## Risks

- **Shared data source coupling.** If the Equipment index consumes a shared dataset, implementation should keep the screenshot-sample narrowing page-local to avoid unintended changes to other Fleet screens.
- **Mixed "parity + SAP sample" intent.** This page will intentionally keep the Equipment-specific chevron-circle lead cell and the ATP `Actions` column, even though the screenshot itself does not show the app's action buttons. That is consistent with the user-approved design.
- **Wider-row behavior remains.** Removing two columns offsets the added `Actions` column, but the page is still a wide table and horizontal scroll remains expected.

## Verification

- Open `/fleet/equipment`
- Confirm `Op. Code` and `Ow. Code` are gone
- Confirm the table shows exactly the three screenshot rows
- Confirm the chevron-circle `ID` cell remains
- Confirm `View | Edit` actions still render and link correctly
