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
