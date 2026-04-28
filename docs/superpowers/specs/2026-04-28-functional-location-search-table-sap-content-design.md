# Functional Location Search Table - SAP Content Alignment - Design

**Date:** 2026-04-28
**Module:** Fleet Management (L1 #7) -> Functional Location search page
**Scope:** Single page only - `/fleet/functional-location`

## Goal

Update the current Functional Location search table so its visible content follows the SAP screenshot provided by the user.

The change is intentionally narrow:

- target page: `/fleet/functional-location`
- use the screenshot rows as the table content
- remove `Op. Code` and `Ow. Code` from the visible table

## Out of scope

- Functional Location detail/show page
- Customer Functional Location page
- Equipment list tables
- DB schema or seed changes
- Route, controller, or Livewire class changes outside the search-page dataset/view
- Removing the existing Actions column or linked ID behavior

## Current state

`resources/views/livewire/fleet/functional-location-search-page.blade.php` already renders the Fleet Functional Location list through the shared `<x-data-table datatable>` pattern.

Current visible columns:

- `ID`
- `Serial No.`
- `Registration`
- `Type`
- `Op. Code`
- `Operator name`
- `Ow. Code`
- `Owner`
- `Actions`

The page already behaves correctly as an ATP list screen:

- linked arrow-style ID column
- client-side search/sort/pagination
- `View | Edit` actions

So this request is best handled as a content-and-column adjustment, not a table-pattern rewrite.

## Approved design

### Columns

Change the visible table to:

- `ID`
- `Serial No.`
- `Registration`
- `Type`
- `Operator name`
- `Owner`
- `Actions`

Removed columns:

- `Op. Code`
- `Ow. Code`

### Rows

Replace the current mock content on this page with the three rows taken from the screenshot:

1. `9M-WAA | 31324 | M104-04 | AW139 | *WESTSTAR | *WESTSTAR`
2. `9M-WAB | 31326 | M104-08 | AW139 | *WESTSTAR | *WESTSTAR`
3. `9M-WAD | 31336 | M104-01 | AW139 | *WESTSTAR | *WESTSTAR`

### Interaction behavior

Keep existing behavior:

- first column remains the arrow-style linked `ID`
- page remains on shared `<x-data-table datatable>`
- `View | Edit` actions remain present

This preserves the repo's agreed list-page pattern while matching the SAP content requested by the user.

## File touch list

- `resources/views/livewire/fleet/functional-location-search-page.blade.php`
- `docs/modules/fleet-management.md`

No additional file changes are expected unless implementation reveals the row data comes from a shared source that must be updated at the page boundary.

## Acceptance

- `/fleet/functional-location` shows only the columns:
  - `ID`
  - `Serial No.`
  - `Registration`
  - `Type`
  - `Operator name`
  - `Owner`
  - `Actions`
- `Op. Code` and `Ow. Code` are no longer visible on this table.
- The three visible records match the screenshot content.
- The `ID` column remains clickable using the current arrow-style linked cell.
- The page still uses the shared datatable behavior.

## Risks

- **Page-specific vs shared mock source.** If the rows come from a shared Fleet catalog instead of inline page data, implementation should update only the search-page-facing dataset and avoid accidental changes to `/fleet/functional-location/customer`.
- **Visual mismatch with SAP screenshot.** The app intentionally keeps the repo's list behavior and action column, so the result follows the screenshot's content rather than becoming a pixel-perfect SAP clone.

## Verification

- Open `/fleet/functional-location`
- Confirm the two code columns are gone
- Confirm the table shows the three approved rows
- Confirm `ID` link and `View | Edit` actions still work
