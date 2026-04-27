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
   → `variant="disabled"` — [screenshot](screenshots/input-variants/disabled.png)
   *Use when the screenshot shows the field as read-only greyed out and it's
   rendered that way regardless of edit state.*

2. **Field has a small LEFT-side arrow/chevron button AND a small colored
   dot/circle inside-or-adjacent-right**
   → `variant="arrow-indicator"` with `tone="<color>"` — [screenshot](screenshots/input-variants/arrow-indicator.png)
   where color is `green` / `amber` / `red` based on the dot colour.
   *Example: "Maintenance Plan" with an orange chevron on the left and a
   green circle on the right → `variant="arrow-indicator" tone="green"`.*

3. **Field has a LEFT-side arrow/chevron button AND a RIGHT-side
   magnifying-glass / lookup icon button**
   → `variant="arrow-lookup"` — [screenshot](screenshots/input-variants/arrow-lookup.png)
   *Example: "Type" with orange left arrow and right lookup → arrow-lookup.*

4. **Field has ONLY a RIGHT-side chevron that looks like a tree / hierarchy
   toggle (down-chevron or stacked-rows glyph), NO magnifying glass, NO colored
   dot**
   → `variant="tree"` — [screenshot](screenshots/input-variants/tree.png)
   *Example: "Serial no" with a small down-chevron on the right.*

5. **Field has ONLY a RIGHT-side magnifying-glass / lookup icon, NO left
   arrow**
   → `variant="lookup"` — [screenshot](screenshots/input-variants/lookup.png)
   *Example: "Country" that opens a search dialog on click. Sometimes shown
   alongside a red dot for "required" — the red dot is a separate required
   marker rendered at the label, NOT part of the variant.*

6. **Field has ONLY a small colored dot/circle at the right edge with NO
   button decorations**
   → `variant="indicator"` with `tone="<color>"` — [screenshot](screenshots/input-variants/indicator.png)
   where color is `green` / `amber` / `red` based on the dot colour.
   *Example: "Code" with a green circle → `variant="indicator" tone="green"`.*

7. **Borderless field inside a `<td>` in an inline-edit grid** (Category Part,
   Counter Refs, Measure Units, MRO Status, Item Groups accounting grid,
   Warehouses accounting grid)
   → `variant="cell"` — *(reference screenshot pending — see Counter Refs manager in edit mode for the live example)*
   *Use when the screenshot shows a compact table with no visible field borders
   — only the table's own row/column grid lines. The field's editability flips
   with an `@readonly` / `@disabled` attribute driven by an `$isEditing` row
   flag; the cell variant paints the same `read-only:` / `disabled:` tone on
   both states.*

8. **None of the above**
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

{{-- Borderless <td>-sized cell input / select (inline-edit grid) --}}
<x-enterprise.input wire:model="rows.{{ $index }}.code" variant="cell" @readonly(! $isEditing) />
<x-enterprise.select wire:model="rows.{{ $index }}.status" variant="cell" @disabled(! $isEditing)>
    <option value=""></option>
    @foreach ($statusOptions as $option)
        <option value="{{ $option['name'] }}">{{ $option['code'] }} - {{ $option['name'] }}</option>
    @endforeach
</x-enterprise.select>
```

## Sibling bare components

These are the non-input enterprise primitives that parallel the bare
`<x-enterprise.input>` (no built-in label column — the caller owns the label).
Use them when the label is already rendered above the field (e.g. in a
`space-y-1.5` stacked-label block) or not needed at all.

| Component | Purpose | Variants |
|---|---|---|
| `<x-enterprise.select>` | Bare `<select>` styled to match `.input-field`. Use for filter selects above a list, stacked-label detail selects, and (with `variant="cell"`) inline-edit grid cells. | `null`, `cell` |
| `<x-enterprise.textarea>` | Bare `<textarea>` styled to match `.input-field min-h-[64px] resize-none rounded-lg px-3 py-2`. Parallel to the bare `<x-enterprise.input>`. `<x-enterprise.textarea-row>` stays as the label+field composite and now delegates to this internally. | — |

```blade
{{-- Bare select above a list (label rendered separately) --}}
<x-enterprise.select wire:model.live="filterType">
    @foreach ($groupTypes as $type)
        <option value="{{ $type }}">{{ $type }}</option>
    @endforeach
</x-enterprise.select>

{{-- Bare textarea in a stacked-label detail block --}}
<x-form.label for="ug_description">Description</x-form.label>
<x-enterprise.textarea id="ug_description" wire:model="description" rows="2" />
```

## Radio — `<x-enterprise.radio>`

Parallel of the bare `<x-enterprise.checkbox>`. Use for single-select radio groups — the caller wires the group together by sharing a `wire:model` / `x-model` across the group's radios and giving each its own `value`.

| Prop | Default | Notes |
|---|---|---|
| `value` | (required) | The radio's `value` attribute — what the bound model becomes when this option is selected. |
| `label` | `null` | Text rendered in the `<span>` next to the radio. When `null` or `''`, the component emits a bare `<input type="radio">` — no wrapping `<label>` or `<span>`. Use the bare mode for call sites that already own the outer `<label>` (e.g. the item-master-data status group inside an `attach-checkbox-inline` wrapper). |
| `labelClass` | `'inline-flex items-center gap-3 text-sm text-gray-700'` | Override the outer `<label>` class. Fleet / maintenance pages use `labelClass="mel-radio-option"` to pick up the shared `mel-radio-option` styling already defined in `resources/css/app.css` (inline-flex, gap-2, gray-700). |

The default inner-input class is `h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500`. `$attributes` pass through to the `<input>`, so `wire:model`, `wire:model.live`, `x-model`, `disabled`, etc. all work exactly as on a raw `<input type="radio">`.

```blade
{{-- Simple labelled radio group (default label styling) --}}
<x-enterprise.radio value="all" label="View all hierarchy of equipments" wire:model="viewMode" />
<x-enterprise.radio value="sons" label="View only son equipments" wire:model="viewMode" />

{{-- Use the shared mel-radio-option style (Fleet / Maintenance pages) --}}
<x-enterprise.radio value="equipment" label="Equipment" labelClass="mel-radio-option" wire:model.live="scope" />
<x-enterprise.radio value="functional-location" label="Functional location" labelClass="mel-radio-option" wire:model.live="scope" />

{{-- Bare mode: caller owns the outer <label> (e.g. attach-checkbox-inline) --}}
<label class="attach-checkbox-inline">
    <x-enterprise.radio value="active" x-model="item.status" />
    <span>Active</span>
</label>
```

## Checkbox — `labelClass` / `inputClass` props and unlabeled mode

`<x-enterprise.checkbox>` accepts:

| Prop | Default | Notes |
|---|---|---|
| `label` | `null` | Text rendered in the `<span>` next to the checkbox. When `null` or `''`, the component emits a bare `<input type="checkbox">` — no wrapping `<label>` or `<span>`. Use this for table-cell checkboxes where the `<th>` is the label, or for call sites that already own the outer `<label>` (see below). |
| `inline` | `false` | `gap-2` (inline) vs `gap-3` (stacked). |
| `labelClass` | `'flex items-center text-sm text-gray-600'` | Override to change tone or weight. Example: `labelClass="flex items-center text-sm font-medium text-gray-700"` for page-header flags; `labelClass="flex items-center text-sm text-gray-400"` for permanently-disabled checkboxes. The `gap-*` token is still appended automatically from `inline`. |
| `inputClass` | `'h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500'` | Override the class on the inner `<input>`. Use when the caller needs a non-default size (e.g. `h-3.5 w-3.5` for a dense grid-cell checkbox in the FL counters modal). Passing `class=""` through `$attributes` does NOT reliably override Tailwind size utilities — the generated CSS source order wins, not the HTML class order — so a dedicated prop is the supported hook. |

### Caller-owned label wrapper (Option A)

The item-master-data mock preview already has five `<label class="attach-checkbox-inline">` wrappers that stack checkboxes with their text. For those sites we use the bare mode of `<x-enterprise.checkbox>` (no `label` prop) nested inside the caller's existing `<label>`. The outer `<label>` implicitly labels the wrapped `<input>`, and the `.attach-checkbox-inline input` rule in `resources/css/app.css` already styles the nested input identically to the component default — so the migration is a 1:1 drop-in with no visual change.

```blade
{{-- item-master-data: caller owns the wrapper; checkbox is bare --}}
<label class="attach-checkbox-inline">
    <x-enterprise.checkbox x-model="item.inventory_item" />
    <span>Inventory Item</span>
</label>
```

Prefer this pattern over adding a `wrapperClass` prop when the caller already has a meaningful `<label>` (e.g. a page-level utility class like `attach-checkbox-inline`). It keeps the component minimal and avoids duplicating layout conventions that already live in CSS.

```blade
{{-- Default --}}
<x-enterprise.checkbox label="Active" inline wire:model="active" />

{{-- Header-tone flag --}}
<x-enterprise.checkbox
    label="Superuser"
    inline
    labelClass="flex items-center text-sm font-medium text-gray-700"
    wire:model="is_superuser"
/>

{{-- Muted / locked --}}
<x-enterprise.checkbox
    label="Drop-Ship"
    inline
    labelClass="flex items-center text-sm text-gray-400"
    disabled
    data-edit-locked="true"
/>

{{-- Bare (cell checkbox — the <th> is the label) --}}
<td><x-enterprise.checkbox wire:model="rows.{{ $i }}.enforce_default_bin" /></td>
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
