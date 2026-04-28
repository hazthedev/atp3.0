# Functional Location Filter Redesign - Design

**Date:** 2026-04-28
**Module:** Fleet Management (L1 #7) -> Functional Location search page
**Scope:** Single page only - `/fleet/functional-location`

## Goal

Redesign the existing Functional Location advanced filter modal so it feels more compact, efficient, and polished while still following the current ATP Enterprise UI language.

This is a visual and layout follow-up to the already-approved modal filter flow. The interaction model stays the same:

- `Filter` button on `/fleet/functional-location`
- modal opens on click
- user works through filter tabs
- `Apply` closes the modal
- current table remains on the page
- filtering behavior stays mock-only for now

The approved redesign direction is:

- compact
- efficient
- Enterprise-based
- remove the `Result` tab
- avoid oversized empty panels and excessive spacing

## Out of scope

- Real filtering logic
- Route changes
- Functional Location table structure changes
- Replacing the modal flow with inline filters
- Creating a new shared reusable filter framework
- Reworking the current Filter button/page entry point

## Problem statement

The current first-pass modal works functionally, but it is too broad and airy for an advanced operational filter:

- modal footprint feels larger than necessary
- panel spacing is too loose
- tab content reads more like a general form than a focused filter tool
- the `Result` tab adds extra navigation without adding real value in mock mode

The redesign should make the filter feel like a tighter enterprise control surface rather than a large generic workspace.

## UX flow

1. User opens `/fleet/functional-location`
2. User clicks `Filter`
3. Modal opens
4. User switches between filter tabs
5. User fills any desired fields
6. User clicks `Apply`
7. Modal closes
8. Mock page-level status feedback updates
9. Existing results table remains visible below

No extra result step inside the modal and no separate result tab.

## UI system choice

Keep the redesign anchored to the current Enterprise layer.

Reuse:

- `resources/views/components/modal.blade.php`
- `resources/views/components/enterprise/panel.blade.php`
- `resources/views/components/enterprise/field-row.blade.php`
- `resources/views/components/enterprise/control-row.blade.php`
- `resources/views/components/enterprise/input.blade.php`
- `resources/views/components/enterprise/select.blade.php`
- `resources/views/components/enterprise/checkbox.blade.php`

Reuse the existing ATP tab styling, but tune the presentation to feel denser and more efficient:

- `subtab-shell`
- `subtab-list`
- `subtab-link`
- `subtab-link-active`
- `subtab-link-inactive`

Do not introduce a new bespoke visual system and do not create a new generic shared filter component in this pass.

## Approved design

### Modal shell

Keep the filter as a modal, but reduce the feeling of width and empty space.

Design intent:

- slightly narrower than the current broad workspace feel
- tighter content rhythm
- less padding waste
- easier scanning at a glance

The modal should read as an efficient advanced-filter dialog, not a pseudo-page inside a popup.

### Tabs

Keep these tabs only:

- `Functional Location`
- `Properties`
- `Part Information`
- `Customers Information`
- `Flight OPS`

Remove:

- `Result`

Reason:

- in mock mode, `Result` adds an extra stop without doing real work
- `Apply` already serves as the handoff back to the results table
- removing it makes the modal faster to understand and navigate

### Content styling

The redesigned modal should be visibly more compact than the current version:

- smaller vertical gaps between rows and sections
- fewer oversized bordered blocks
- denser field grouping
- shorter visual distance between label and input
- more restrained panel padding
- better scan alignment across two-column layouts

This should feel operational and deliberate, not decorative.

### Functional Location tab

Keep the same field set, but redesign the layout for efficiency:

- Serial Number
- Registration
- Type grid/list area
- Maintenance Plan checkbox/control
- Status selector
- Load Types checkbox/control
- Qualifications checkbox/control
- Positions checkbox/control

The type area should remain readable but occupy less visual weight than it does today.

### Properties tab

Keep:

- Mission Type
- Environment Type
- Oil Type
- Date of Purchase
- Purchase Price
- Cum. Flight Time
- Only with anomaly on Data

This tab should feel like a concise two-column filter sheet rather than a wide form slab.

### Part Information tab

Keep:

- Serial Number
- Item No.
- Part Description
- Engine Variant
- Category Part

This tab should use a compact grouped layout with minimal wasted width.

### Customers Information tab

Keep:

- Customer Owner Code
- Customer Owner Name
- Customer Operator Code
- Customer Operator Name

The redesign should make owner/operator pairing easier to scan as two compact grouped blocks.

### Flight OPS tab

Keep:

- MTOW Min
- MTOW Max
- Status
- Scheduled departure date/time range
- Scheduled arrival date/time range

This tab should be the most structured one visually, with date/time ranges grouped tightly enough that they read as filter controls instead of standalone form rows.

### Footer actions

Keep:

- `Reset`
- `Cancel`
- `Apply`

Behavior stays the same:

- `Apply` closes the modal and updates mock page-local status
- `Reset` clears the page-local filter state back to defaults
- `Cancel` closes without applying

## Implementation shape

Keep this redesign page-local in the existing Functional Location search view.

Expected implementation shape:

- adjust modal width and internal spacing
- remove the `Result` tab and its preview block
- restructure current tab bodies for denser Enterprise presentation
- keep existing Alpine state and mock apply flow unless a tiny cleanup is needed

No backend filtering or shared component extraction is required.

## File touch list

- `resources/views/livewire/fleet/functional-location-search-page.blade.php`
- `docs/modules/fleet-management.md`

No other files are expected unless a tiny styling assist is truly necessary.

## Acceptance

- `/fleet/functional-location` still opens the filter through the existing `Filter` button
- modal uses a more compact and efficient layout than the first-pass version
- only five tabs remain
- `Result` tab is removed
- content continues to use the ATP Enterprise component language
- `Apply`, `Reset`, and `Cancel` still work in mock mode
- existing result table remains unchanged below the modal flow

## Risks

- **Too much compression.** If spacing is reduced too aggressively, the modal may feel cramped. Mitigation: compact, not crowded.
- **Inconsistent density between tabs.** Some tabs may still feel looser than others after removal of the `Result` tab. Mitigation: normalize spacing and grouping across all tab bodies.
- **Premature abstraction pressure.** This redesign may look reusable, but shared extraction should wait for another real advanced-filter use case.

## Verification

- Open `/fleet/functional-location`
- Click `Filter`
- Confirm the modal opens with the reduced tab set
- Confirm `Result` no longer appears
- Switch through all five tabs
- Confirm the content feels tighter and more efficient than the earlier version
- Click `Reset` and confirm fields clear
- Click `Cancel` and confirm modal closes
- Reopen modal, click `Apply`, confirm modal closes and page status still updates
