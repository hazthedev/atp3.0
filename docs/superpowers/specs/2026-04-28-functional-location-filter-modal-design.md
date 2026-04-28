# Functional Location Filter Modal - Design

**Date:** 2026-04-28
**Module:** Fleet Management (L1 #7) -> Functional Location search page
**Scope:** Single page only - `/fleet/functional-location`

## Goal

Add an advanced filter flow to the Functional Location search page using a modal with SAP-structured tabs, while keeping the UI in the current ATP visual language and keeping the first delivery on mock apply behavior.

The approved direction is:

- add a `Filter` button on `/fleet/functional-location`
- clicking `Filter` opens a modal
- the modal contains the SAP-style filter tabs
- user clicks `Apply`
- the modal closes
- filtering behavior is mocked for now
- the existing results table stays on the page

## Out of scope

- Real filtering logic
- New routes or route changes
- Functional Location detail/show page changes
- Replacing the current results table
- Creating a brand-new reusable generic filter component
- Raw SAP visual mimicry that ignores the current ATP design system

## UX flow

1. User lands on `/fleet/functional-location`
2. User sees the current results page plus a new `Filter` trigger
3. User clicks `Filter`
4. A modal opens
5. Inside the modal, user navigates tabs:
   - `Functional Location`
   - `Properties`
   - `Part Information`
   - `Customers Information`
   - `Flight OPS`
   - `Result`
6. User fills any combination of fields
7. User clicks `Apply`
8. Modal closes
9. Page remains on `/fleet/functional-location`
10. Mock behavior updates status/preview state only; no real dataset filtering yet

No separate route and no modal-on-modal flow.

## UI system choice

Use the existing Enterprise UI layer as the primary building block for the filter content.

Reuse:

- `resources/views/components/modal.blade.php`
- `resources/views/components/enterprise/panel.blade.php`
- `resources/views/components/enterprise/field-row.blade.php`
- `resources/views/components/enterprise/control-row.blade.php`
- `resources/views/components/enterprise/date-row.blade.php`
- `resources/views/components/enterprise/input.blade.php`
- `resources/views/components/enterprise/select.blade.php`
- `resources/views/components/enterprise/checkbox.blade.php`

Also reuse the current tab styling already established in the app:

- `subtab-shell`
- `subtab-list`
- `subtab-link`
- `subtab-link-active`
- `subtab-link-inactive`

Do not create a new shared generic `filter-modal` component at this stage. Compose the modal directly inside the Functional Location page first.

## Approved design

### Main page

Keep the current Functional Location results table and page structure intact.

Add a `Filter` button near the page header / results controls. The button opens the modal.

Optionally show a lightweight status message after `Apply`, such as:

- `Functional location filter preset applied.`

This is page-local feedback only, not proof of real filtering.

### Modal tabs

The modal contains these tabs:

- `Functional Location`
- `Properties`
- `Part Information`
- `Customers Information`
- `Flight OPS`
- `Result`

These tabs mirror the SAP structure, but the visual treatment stays in ATP styling.

### Tab content

#### Functional Location tab

Include fields patterned after the screenshots:

- Serial Number
- Registration
- Type grid/list area
- Maintenance Plan checkbox/control
- Operational status selector
- Load Types checkbox/control
- Qualifications checkbox/control
- Positions checkbox/control

#### Properties tab

- Mission Type
- Environment Type
- Oil Type
- Date of Purchase
- Purchase Price
- Cum. Flight Time
- Only with anomaly on Data checkbox

#### Part Information tab

- Serial Number
- Item No.
- Part Description
- Engine Variant
- Category Part

#### Customers Information tab

- Customer Owner Code
- Customer Owner Name
- Customer Operator Code
- Customer Operator Name

#### Flight OPS tab

- MTOW Min
- MTOW Max
- Scheduled departure date/time range
- Scheduled arrival date/time range

#### Result tab

This tab is part of the SAP structure, but for the mock first cut it acts as a summary/state tab inside the modal rather than rendering a second full results table. It can show a concise preview like:

- selected criteria summary
- mock note that the current result preview is ready to apply

The actual existing table remains on the page below the modal trigger.

### Modal actions

Footer buttons:

- `Apply`
- `Reset`
- `Cancel`

Behavior:

- `Apply`: closes modal, updates page-local status state, no real filtering yet
- `Reset`: clears modal fields back to defaults
- `Cancel`: closes modal without applying

## Implementation shape

Keep this page-local in the Functional Location search page rather than extracting a shared abstraction now.

Likely implementation approach:

- add Alpine state for `filterModalOpen`, `activeFilterTab`, and page-local filter form fields
- render `<x-modal>` in the page
- compose each tab with Enterprise panels and rows
- preserve the existing results table below

No backend/data-source mutation is required for the mock first pass.

## File touch list

- `resources/views/livewire/fleet/functional-location-search-page.blade.php`
- `docs/modules/fleet-management.md`

Additional files are not expected unless a tiny helper is needed for modal state styling.

## Acceptance

- `/fleet/functional-location` has a visible `Filter` trigger
- clicking `Filter` opens a modal
- modal contains the approved six tabs
- filter fields are rendered using the existing ATP/Enterprise visual system
- `Apply`, `Reset`, and `Cancel` all work at the mock-interaction level
- `Apply` closes the modal and updates a lightweight page status/preview state
- the existing Functional Location result table remains on the page
- no real filtering logic is required in this first delivery

## Risks

- **User expectation of real filtering.** Because the flow feels complete, users may expect live filtering immediately. Mitigation: keep the first-cut feedback explicit and modest.
- **Large modal content.** The SAP field set is broad, so modal height could become large. Mitigation: use scrollable modal content and tab segmentation.
- **Future reuse pressure.** This may later want extraction into a shared advanced-filter pattern, but that should happen only after a second real use case proves the shape.

## Verification

- Open `/fleet/functional-location`
- Click `Filter`
- Confirm modal opens
- Switch across all tabs
- Click `Reset` and confirm fields clear
- Click `Cancel` and confirm modal closes
- Reopen modal, click `Apply`, confirm modal closes and page status updates
- Confirm the existing results table still renders below
