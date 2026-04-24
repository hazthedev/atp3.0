# Text-input variant catalog (SAP visual → variant hook)

Every text-input field in an SAP / Weststar mock-up maps to one of the variants
of `<x-enterprise.input>` (source: `resources/views/components/enterprise/input.blade.php`).

When the user pastes a screenshot, **walk the decision tree below** to pick the
correct variant for each field, then write the Blade with that variant. Never
default to a plain `<input class="input-field">` unless the decision tree says
`null`.

## Visual decision tree

Check these in order — stop at the first match.

1. **Field text is grey, background is grey, looks non-interactive**
   → `variant="disabled"`
   *Use when the screenshot shows the field as read-only greyed out and it's
   rendered that way regardless of edit state.*

2. **Field has a small LEFT-side arrow/chevron button AND a small colored
   dot/circle inside-or-adjacent-right**
   → `variant="arrow-indicator"` with `tone="<color>"`
   where color is `green` / `amber` / `red` based on the dot colour.
   *Example: "Maintenance Plan" with an orange chevron on the left and a
   green circle on the right → `variant="arrow-indicator" tone="green"`.*

3. **Field has a LEFT-side arrow/chevron button AND a RIGHT-side
   magnifying-glass / lookup icon button**
   → `variant="arrow-lookup"`
   *Example: "Type" with orange left arrow and right lookup → arrow-lookup.*

4. **Field has ONLY a RIGHT-side chevron that looks like a tree / hierarchy
   toggle (down-chevron or stacked-rows glyph), NO magnifying glass, NO colored
   dot**
   → `variant="tree"`
   *Example: "Serial no" with a small down-chevron on the right.*

5. **Field has ONLY a RIGHT-side magnifying-glass / lookup icon, NO left
   arrow**
   → `variant="lookup"`
   *Example: "Country" that opens a search dialog on click. Sometimes shown
   alongside a red dot for "required" — the red dot is a separate required
   marker rendered at the label, NOT part of the variant.*

6. **Field has ONLY a small colored dot/circle at the right edge with NO
   button decorations**
   → `variant="indicator"` with `tone="<color>"`
   where color is `green` / `amber` / `red` based on the dot colour.
   *Example: "Code" with a green circle → `variant="indicator" tone="green"`.*

7. **None of the above**
   → no variant prop (omit `variant=`). Renders as the plain `.input-field`.

## Tone mapping

| Dot / background colour | `tone` prop |
|---|---|
| Green | `green` |
| Amber / yellow / orange | `amber` |
| Red | `red` |

Applies to: `indicator`, `arrow-indicator`.

## Customisable action slots

When you need the button on the left arrow, right lookup, or tree chevron to do
something specific, override via named slots on `<x-enterprise.input>`:

| Slot | Replaces button in | Usage |
|---|---|---|
| `arrowAction` | arrow-lookup, arrow-indicator | jump to referenced record |
| `lookupAction` | lookup, arrow-lookup | open search modal |
| `treeAction` | tree | open hierarchy dialog |

If the slot is omitted, a default non-functional button renders.

## Variant scope & usage

Not every variant is common vocabulary — some map to cues that only appear on
specific SAP screens. Keep this table current as new screens land; it tells you
at a glance whether a variant is broadly applicable or a single-screen
affordance.

| variant | Scope | Currently used in |
|---|---|---|
| *(none)* | ubiquitous | every form |
| `disabled` | ubiquitous | Warehouse "Drop-Ship" and any forced-greyed field |
| `lookup` | ubiquitous | User form (Employee, Groups, Password), Warehouse (Country), FL (Country in address block) |
| `indicator` (with `tone`) | **FL-specific** — SAP shows a coloured circle only on Fleet's identity fields | `functional-location-show-form.blade.php` (Code, MEL) |
| `tree` | **FL-specific** — SAP shows the hierarchy-toggle chevron only on FL's Serial No. | `functional-location-show-form.blade.php` (Serial No.) |
| `arrow-lookup` | **FL-specific** — left-jump arrow + right lookup combo is the Fleet card's navigation affordance | `functional-location-show-form.blade.php` (Owner Code, Type, Operator Code) |
| `arrow-indicator` (with `tone`) | **FL-specific** — left-jump arrow + status dot only appears on FL "Maintenance Plan" | `functional-location-show-form.blade.php` (Maintenance Plan) |

The four FL-specific variants are intentional design vocabulary backed by the
Weststar FL screenshot. Do not consolidate them into a generic `lookup` +
`chevron`/`tone` API — the decision tree teaches readers to recognise each
visual cue as a distinct variant, and flattening them would erase that
mapping. If a future screenshot batch surfaces the same cue outside Fleet,
move the row out of "FL-specific" and note the new home — don't redesign the
prop surface.

## Catalog: Weststar SAP examples already mapped

From the FL Customer Functional Location top card (seeded reference implementation):

| Field | Visual | Variant call |
|---|---|---|
| Code | green circle at right edge | `variant="indicator" tone="green"` |
| Status | plain dropdown | `<x-form.select>` (not an input variant) |
| Serial No. | right chevron (tree) | `variant="tree"` |
| Maintenance Plan | left arrow + green indicator | `variant="arrow-indicator" tone="green"` |
| Registration | plain | *(no variant)* |
| Owner Code | left arrow + right lookup | `variant="arrow-lookup"` |
| Type | left arrow + right lookup | `variant="arrow-lookup"` |
| Owner Name | plain | *(no variant)* |
| MEL | green circle at right | `variant="indicator" tone="green"` |
| Operator Code | left arrow + right lookup | `variant="arrow-lookup"` |
| Operator Name | plain | *(no variant)* |
| Country (address block) | right lookup only | `variant="lookup"` |

Reference implementation: `resources/views/livewire/fleet/functional-location-show-form.blade.php`.

## Catalog: User Management — Users – Setup form (from SAP B1)

All fields on the Users – Setup form were walked through the decision tree.
No variants beyond `lookup` appeared; no indicators, no tree, no arrows.

| Field | Tab | Visual | Variant call |
|---|---|---|---|
| User Code | header | plain (yellow highlight = required) | *(no variant)*, label marked `:required="true"` |
| User Name | header | plain | *(no variant)* |
| Defaults | header | plain | *(no variant)* |
| Bind with Microsoft Windows Account | General | plain | *(no variant)* |
| Employee | General | right picker icon | `variant="lookup"` |
| E-Mail / Mobile Phone / Mobile Device ID / Fax | General | plain | *(no variant)* |
| Branch / Department | General | SAP shows dropdown | `<x-form.select>` (not an input) |
| Groups | General | SAP shows text fields + `...` picker | `variant="lookup"` with custom `lookupAction` slot that opens a group-picker modal |
| Password | General | masked + `...` picker | `variant="lookup"` + `type="password"` |
| Update Messages / Screen Locking Time | Services | plain number | *(no variant)* |
| Open Postdated Credit Vouchers Window | Services | dropdown | `<x-form.select>` |
| Skin Style / Color / Language / Font / Font Size / Background / Image Display / Ext. Image Processing | Display | dropdowns | `<x-form.select>` |

Reference implementation: `resources/views/livewire/system/user-form.blade.php`.

## Catalog: User Management — User Groups form (from SAP B1)

All inputs on the User Groups form are plain — no picker buttons, no tree chevrons, no coloured indicators. Every text field resolves to `null` variant; dropdowns resolve to `<x-form.select>`.

| Field | Visual | Variant call |
|---|---|---|
| Name | plain | *(no variant)* |
| Description | plain textarea | `<textarea class="input-field">` (no enterprise variant; textarea isn't supported by `<x-enterprise.input>`) |
| Group Type (detail form) | dropdown | `<x-form.select>` |
| Active From / Active To | plain date inputs | *(no variant)* via `<x-enterprise.input type="date">` |
| Group Type filter (top of list) | dropdown | `<x-form.select>` |
| Member search box | plain | *(no variant)* |
| Members table cells (User Code, User Name, Department, From, To) | SAP shows inline-editable grid | rendered as read-only display text; inline editing is a later scope decision |

Reference implementation: `resources/views/livewire/admin/user-groups-page.blade.php`.

### Gaps vs SAP (noted, not fixed in this pass)
- SAP's members table is an inline-editable grid (type User Code directly). Current ATP implementation uses a separate "search-and-add" picker below the table.
- "Create Group" button currently sits in the header; SAP puts it next to the OK/Cancel bottom bar.

## Catalog: User Management — Authorizations form (from SAP B1)

All inputs on the Authorizations form are plain. The complexity is in the subject tree and the action bar, neither of which are input variants.

| Field | Visual | Variant call |
|---|---|---|
| Filter (left rail) | plain | *(no variant)* |
| Find (top of tree) | plain — **not yet implemented** | would be *(no variant)* |
| Max. Discount — Sales / Purchase / General | plain numeric — **not yet implemented** | would be *(no variant)* |
| Max. Cash Amount for Incoming Payments | checkbox — **not yet implemented** | not an input variant |

Reference implementation: `resources/views/livewire/admin/authorizations-page.blade.php`.

### Gaps vs SAP (noted, not fixed in this pass)
- "Find" text input above the permission tree is missing.
- Max. Discount Sales / Purchase / General numeric inputs are missing.
- Max. Cash Amount for Incoming Payments checkbox is missing.
- "Copy Authorizations" button (bottom-left) is missing.
- Global "Expand" and "Collapse" buttons are missing; only per-node chevrons exist.
- OK / Cancel bottom action bar is missing (actions currently apply live).

These are feature-completeness gaps, not variant-choice gaps — the catalog still says `null` for each of those text inputs once they are added.

## Catalog: Stock Management — Item Groups – Setup (from SAP B1)

Two-tab setup form. Only two fields would conceptually be lookups in a mature build (UoM Group, Account Code); neither shows an icon in the screenshot so they resolve to plain.

| Field | Tab | Visual | Variant call |
|---|---|---|---|
| Item Group Name | header | plain (yellow = required marker, not a variant) | *(no variant)*, label marked `:required="true"` |
| Default UoM Group | General | plain | *(no variant)* — will become `variant="lookup"` when UoM Groups ship |
| Lead Time (Days) | General | plain number | *(no variant)* |
| Default Valuation Method | General | dropdown | `<x-form.select>` |
| Default Bin Location (grid cell) | General | plain inline input | *(no variant)* |
| Enforce Default Bin Loc. (grid cell) | General | checkbox | not an input variant |
| Account Code (grid cell) | Accounting | SAP shows inline code with picker | rendered as `<select class="input-field">` dropdown (resolves to Account Name beside it) |

Reference implementation: `resources/views/livewire/admin/stock/item-group-form.blade.php`.

### Gaps vs SAP (noted, not fixed in this pass)
- Default UoM Group is plain text; SAP has a lookup button. Catalog decision tree says no variant when no icon is visible in the screenshot; revisit once a UoM Groups table exists.
- Accounting's Account Code is a plain HTML select (`<select class="input-field">`). SAP shows a code-lookup-plus-search-button combo; swap to `variant="lookup"` with a picker modal when the real Chart of Accounts lands.
- The "#" / row-numbers and the small arrow-dropdown top-right of each grid are decorative-only in our implementation.

## Catalog: Stock Management — Category Part List (from SAP B1)

Simple inline-editable master list. All inputs are plain; the pencil/x-circle row actions are not input variants.

| Field | Visual | Variant call |
|---|---|---|
| Code (grid cell) | plain inline input, yellow background when editing | *(no variant)* — rendered as a bare `<input>` inside the cell |
| New Code (grid cell) | plain inline input | *(no variant)* |
| Name (grid cell) | plain inline input | *(no variant)* |

Reference implementation: `resources/views/livewire/admin/stock/category-parts-page.blade.php`.

### Gaps vs SAP (noted, not fixed in this pass)
- SAP shows the currently-edited row with a yellow background; we match with `bg-amber-50` on the `tr` when that row is the `editingIndex`.
- Double-click to edit (SAP behaviour) — we use an explicit pencil button instead, matching the rest of the ATP reference-data pages.

## Catalog: Stock Management — Warehouses – Setup (from SAP B1)

Two-tab form. Most address-block fields are plain. Country is the only field with a visible lookup decoration in the screenshot.

| Field | Tab | Visual | Variant call |
|---|---|---|---|
| Warehouse Code | header | plain (yellow = required marker) | *(no variant)*, label marked `:required="true"` |
| Warehouse Name | header | plain | *(no variant)*, label marked `:required="true"` |
| Inactive / Nettable / Issue part for maintenance / Enable Bin Locations | General | checkboxes | not input variants |
| Drop-Ship | General | greyed checkbox (disabled) | `disabled` + `data-edit-locked="true"` |
| Location | General | dropdown | `<x-form.select>` |
| Street/PO Box, Street No., Block, Building/Floor/Room, Zip Code, City, County, State, Federal Tax ID, GLN, Tax Office, Address Name 2, Address Name 3 | General | plain | *(no variant)* |
| Country | General | right lookup | `variant="lookup"` |
| Show Location in Web Browser | General | blue text link | plain `<a>` (not an input) |
| Account Code (grid cell) | Accounting | same as Item Groups | `<select class="input-field">` |

Reference implementation: `resources/views/livewire/admin/stock/warehouse-form.blade.php`.

### Gaps vs SAP (noted, not fixed in this pass)
- "Show Location in Web Browser" is a stubbed link; no geocoding integration.
- Country lookup opens a stub — no country picker modal wired.
- Drop-Ship is permanently disabled (mirroring SAP's accounting-package gating). If the gating needs to be dynamic later, wire it to a settings flag.

## Cheatsheet — visual → call snippet

```blade
{{-- Plain --}}
<x-enterprise.input wire:model="foo" />

{{-- Indicator dot --}}
<x-enterprise.input wire:model="foo" variant="indicator" tone="green" />
<x-enterprise.input wire:model="foo" variant="indicator" tone="amber" />
<x-enterprise.input wire:model="foo" variant="indicator" tone="red" />

{{-- Tree chevron --}}
<x-enterprise.input wire:model="foo" variant="tree" />

{{-- Lookup (magnifying glass) --}}
<x-enterprise.input wire:model="foo" variant="lookup" />

{{-- Arrow + lookup --}}
<x-enterprise.input wire:model="foo" variant="arrow-lookup" />

{{-- Arrow + indicator dot --}}
<x-enterprise.input wire:model="foo" variant="arrow-indicator" tone="green" />

{{-- Forced-disabled look (regardless of edit state) --}}
<x-enterprise.input wire:model="foo" variant="disabled" />
```

## Interaction with the Edit Record toggle

The Alpine `editMode()` component adds / removes the HTML `disabled` attribute
on form elements inside `[data-edit-scope]`. Variant decorations (coloured
background, picker buttons) **stay visible in both states**. The input's
editability changes; its decoration does not. This matches SAP behaviour:
variants are field-type affordances, not state indicators.

If you want a field to look muted regardless of edit state, use
`variant="disabled"` explicitly.

## When a screenshot doesn't match any variant cleanly

1. **Required-field markers** (red asterisk, red external dot) → handled at the
   `<x-form.label>` level, not on the input. Still pick the variant based on
   the input's own decoration.
2. **Currency / unit suffix** (e.g. "kg", "USD" glyph inside the input) →
   not currently supported. Flag it to the user and propose extending the
   component before shipping.
3. **Combined lookup + indicator** that doesn't match any variant on this page
   → propose a new variant before inventing one ad-hoc. Update this catalog in
   the same PR that adds the variant.

## Updating this catalog

Whenever the user hands over a new SAP screenshot batch with new visual
patterns, add a new row to the examples table AND the cheatsheet so the
mapping stays current. Changes to this file should land in the same PR that
wires the new pattern into pages.
