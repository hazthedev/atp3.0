# Functional Location Filter SAP Layout Follow-up - Design

**Date:** 2026-04-28
**Module:** Fleet Management (L1 #7) -> Functional Location search page
**Scope:** Single page primary, plus shared modal shell only if needed for the viewport bug

## Goal

Redo the Functional Location filter modal so the tab layouts follow the SAP screenshots much more literally, while polishing the styling into the current ATP visual language.

This follow-up also fixes the current modal viewport problem shown in review:

- lower content area appears clipped / pushed off-screen
- large blank area appears beneath the visible modal content
- footer actions can become visually displaced when the modal content grows tall

The approved direction is:

- premium but compact
- layout follows the reference screenshots
- SAP field arrangement is the layout source of truth
- ATP Enterprise components still provide the visual system
- keep the current modal workflow and mock behavior

## Out of scope

- Real filtering logic
- New routes
- Replacing the modal flow with inline filters
- Redesigning the FL results table
- Creating a new generic advanced-filter framework
- Global modal redesign beyond what is required to safely support this filter

## Problem statement

The current compact redesign improved density, but it still misses the mark in two ways:

1. **Layout fidelity**
   - the tab interiors still feel like ATP-authored form layouts
   - they do not follow the SAP screenshots closely enough
   - the premium feel is undermined because the structure still feels improvised

2. **Modal shell behavior**
   - the shared modal currently centers a large content block with no dedicated max-height body region
   - tall filter content can overflow the viewport awkwardly
   - this creates the clipped / blank lower-half effect shown in the screenshot

This pass should fix both together.

## UX flow

1. User opens `/fleet/functional-location`
2. User clicks `Filter`
3. Modal opens
4. User navigates the five tabs
5. Each tab visually follows the SAP screenshot layout for that section
6. User clicks `Apply`, `Reset`, or `Cancel`
7. Modal closes or resets as it does today
8. Mock page-level status behavior remains unchanged

## UI system choice

Use the existing ATP Enterprise components for fields and controls, but do not let those abstractions dictate the layout.

Primary reused components:

- `resources/views/components/modal.blade.php`
- `resources/views/components/enterprise/panel.blade.php`
- `resources/views/components/enterprise/field-row.blade.php`
- `resources/views/components/enterprise/control-row.blade.php`
- `resources/views/components/enterprise/input.blade.php`
- `resources/views/components/enterprise/select.blade.php`
- `resources/views/components/enterprise/checkbox.blade.php`

The screenshots define **where things go**.
Enterprise components define **how the controls look**.

## Approved design

### Modal shell behavior

Fix the modal shell so it can safely host taller filter layouts.

Expected behavior:

- modal should fit within the viewport height
- header stays visible
- footer actions stay reachable
- body content scrolls inside the modal when necessary
- no large blank area below the visible content block
- no clipped lower body when tab content is tall

Preferred implementation direction:

- treat the modal card as a viewport-bounded container
- give the content body its own scrollable region
- keep the shell feeling stable while tab content changes

If the current shared `x-modal` can be improved safely without harming other call sites, do it there. If not, apply the minimum scoped adjustment needed for this filter modal.

### Tab set

Keep these tabs only:

- `Functional Location`
- `Properties`
- `Part Information`
- `Customers Information`
- `Flight OPS`

No `Result` tab.

### Functional Location tab

Follow the screenshot layout closely:

- serial number at top-left
- registration directly below
- large type grid/table occupying the left main area
- right-side vertical control stack:
  - Maintenance Plan
  - Status
  - Load Types
  - Qualifications
  - Positions

The right stack should read like compact filter toggles beside the main type grid, not like equal-weight cards.

### Properties tab

Follow the screenshot layout closely:

- compact fields concentrated near the top
- left side:
  - Mission Type
  - Environment Type
  - Oil Type
  - anomaly checkbox below
- right side:
  - Date of Purchase
  - Purchase Price
  - Cum. Flight Time > M

Leave the lower body visually open as in the reference, rather than forcing unnecessary filler panels.

### Part Information tab

Follow the screenshot layout closely:

- narrow stacked field block
- top-to-bottom flow
- fields:
  - Serial Number
  - Item No.
  - Part Description
  - Engine Variant
  - Category Part

This tab should feel restrained and left-anchored like the screenshot.

### Customers Information tab

Follow the screenshot layout closely:

- owner section first near the top
- operator section below with visible separation
- do not force side-by-side grouping if the screenshot reads vertically

Fields:

- Customer Owner Code
- Customer Owner Name
- Customer Operator Code
- Customer Operator Name

### Flight OPS tab

Follow the screenshot layout closely:

- MTOW row across the top
- Scheduled block below
- date/time matrix arranged like the screenshot instead of a generic equal-width grid

Fields:

- MTOW Min
- MTOW Max
- Status
- Departure Date From / To with time fields
- Arrival Date From / To with time fields

### Visual direction

The premium feel should come from:

- stricter alignment
- cleaner whitespace discipline
- more intentional grouping
- stronger hierarchy in labels and section boundaries
- a calmer, more resolved dialog shell

Not from:

- decorative gradients
- oversized cards
- loose spacing
- unrelated visual flourishes

## Implementation shape

Expected file changes:

- `resources/views/livewire/fleet/functional-location-search-page.blade.php`
- `docs/modules/fleet-management.md`

Possible shared-shell touch if needed for the viewport bug:

- `resources/views/components/modal.blade.php`

Implementation should:

- rebuild tab internals to mirror the SAP layout more closely
- preserve existing Alpine state and button behavior
- fix the overflow/clipping issue either in the shared modal shell or with a safe scoped adjustment

## Acceptance

- modal opens from the existing `Filter` button
- five-tab structure remains
- each tab layout visibly follows the SAP screenshots more closely than the current version
- modal no longer shows the clipped / blank lower-half problem from the review screenshot
- header, body, and footer remain usable on a typical laptop viewport
- `Apply`, `Reset`, and `Cancel` keep current mock behavior

## Risks

- **Shared modal regression.** Adjusting the shell could affect other modals. Mitigation: keep changes minimal and verify common behavior.
- **Over-literal layout on small screens.** A 1:1 desktop-inspired arrangement can become brittle. Mitigation: preserve screenshot structure on desktop while allowing safe vertical collapse on smaller widths.
- **Premium drift.** Following SAP too literally could feel dated if styling is not carefully modernized. Mitigation: preserve ATP control styling and tighten hierarchy rather than copying raw legacy visuals.

## Verification

- Open `/fleet/functional-location`
- Click `Filter`
- Confirm modal fits in viewport without clipped lower space
- Confirm footer stays reachable
- Switch through all five tabs
- Compare each tab layout against the SAP screenshots for structural fidelity
- Click `Reset`, `Cancel`, and `Apply` to confirm the existing mock workflow still behaves correctly
