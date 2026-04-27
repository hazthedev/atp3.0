# Item Master Data Restructure — Design

**Date:** 2026-04-27
**Module:** Inventory (L1 #4) → Item Master Data
**Related:** Same playbook as PR #90 (FL trim) and PR #91 (Equipment Card trim). View-layer + Livewire bindings only; no DB schema change.

## Goal

Apply a user-authored kill list to the Item Master Data detail page. The page is structured as two stacked renderings: an **Identity card** (Livewire `ItemMasterDataForm`, persists to the `items` table) and a larger **Alpine preview** below it (mock data, SAP-style layout). The kill list spans both renderings plus four full tab deletions.

## Out of scope

- DB schema changes. `items.item_type` and `items.uom_group` columns stay (sweep showed they're set by `ItemSeeder` and `ItemFactory`; values still flow into models, even though no UI will mutate them after this PR).
- Any feature work on the surviving tabs (counter wiring, save persistence on Aero One / Inventory Data / Remarks / Attachments — those remain in the module file's Outstanding list).
- Filling in SAP-faithful General-tab fields ("Service Attributes", "Warranty Templates") that the user mentioned but which never existed in the codebase. Those would need a separate "fill in missing fields" PR before any trim work could touch them.

## Kill list — exact targets

| # | Where | Target |
|---|---|---|
| 1 | Identity card Livewire blade (`resources/views/livewire/system/item-master-data-form.blade.php` lines 22-29) + `app/Livewire/System/ItemMasterDataForm.php` | `item_type` row + `uom_group` row + their `public string` properties + `loadFromDb()` assignments + `update()` payload entries |
| 2 | Alpine preview top form (lines 272-273) | `foreign_name` field-row |
| 3 | Alpine preview top form (lines 275-277) | `item_type` field-row |
| 4 | Alpine preview top form (lines 289-298) | `uom_group` field-row, including its nested `bar_code` placeholder input |
| 5 | Alpine preview top form (lines 299-311) | `price_list` field-row, including its nested `unit_price` + `unit_currency` inputs |
| 6 | Alpine preview Item Classification panel (lines 314-332) | **Entire panel** — Inventory Item / Sales Item / Purchase Item / Tool Item checkboxes (per Section 1 design call: degenerate single-checkbox panel is worse than removing the panel) |
| 7 | Main tab nav (line 340) + panel (~line 416) | `Purchasing Data` tab entry + entire panel |
| 8 | Main tab nav (line 342) + panel (~line 561) | `Sales Data` tab entry + entire panel |
| 9 | Main tab nav (line 344) + panel (~line 676) | `Planning Data` tab entry + entire panel |
| 10 | Main tab nav (line 345) + panel (~line 686) | `Properties` tab entry + entire panel + `selectAllProperties()` / `clearPropertySelection()` Alpine methods + `$properties` mock array (line 170) |
| 11 | General tab — `Do Not Apply Discount Groups` checkbox (lines 355-358) | label + checkbox |
| 12 | General tab — `Additional Identifier` field-row (lines 367-369) | row |
| 13 | General tab — `Shipping Type` field-row (lines 370-376) | row |
| 14 | General tab — `Item Code Aerospace Defense` field-row (lines 387-389) | row |

**Final main tab order after deletions:** General · Aero One · Inventory Data · Remarks · Attachments. (5 tabs, down from 9.)

**Identity card after deletions:** Code · Description · Manufacturer · Item Group · Item Class. (5 fields, down from 7.)

## Ancillary cleanup

- Strip the now-orphan keys from the `$item` Alpine mock state object near the top of the partial (the `@js(...)` block at line 13 onward and its empty-state mirror at line 74 onward): `foreign_name`, `bar_code`, `price_list`, `unit_price`, `unit_currency`, `inventory_item`, `sales_item`, `purchase_item`, `tool_item`, plus the keys that fed the 4 deleted tabs (`preferred_vendor`, `mfr_catalog_no`, `purchasing_uom_name`, `items_per_purchase_unit`, `packaging_uom_name`, `quantity_per_package`, `length`, `width`, `height`, `volume`, `weight`, `factor_1`/2/3/4, `customs_group`, `tax_group`, all sales-tab keys, all planning-tab keys), plus the 4 deleted General-tab keys (`do_not_apply_discount_groups`, `additional_identifier`, `shipping_type`, `item_code_aerospace_defense`).
- Strip the orphan `selectAllProperties()` / `clearPropertySelection()` Alpine methods + `properties:` declaration from the Alpine `x-data` block (around line 205-216).
- Strip the `$properties` PHP mock array (line 170).

## Livewire / behavioural notes

After this PR, **no UI in the Item Master Data flow mutates `items.item_type` or `items.uom_group`.** (The admin/stock `ItemGroupForm` has a `default_uom_group` field, but that's on the separate `item_groups` table — a different column entirely.) Unlike FL (`ChangeCustomerInformationPage`) or Equipment (`ChangeEquipmentCustomerInformationPage` + `AttachEquipmentPage`), the Item module has no canonical fallback mutator for these columns. Their values on existing rows will be set only by the seeder and factory going forward. This is consistent with the user's "delete from top form" direction (the kill list applies to user-visible page real estate, and leaving the fields half-visible on the Identity card defeats the purpose), but worth flagging as a downstream consequence.

The Identity card itself stays (5 surviving fields — Code, Description, Manufacturer, Item Group, Item Class — still need a persistence path).

## File touch list

| File | Change |
|---|---|
| `resources/views/pages/system/item-master-data/partials/form.blade.php` | All 14 deletion targets + Alpine state cleanup. Estimated net diff: ~400 lines deleted, ~0 added (no new content). |
| `resources/views/livewire/system/item-master-data-form.blade.php` | Drop `item_type` + `uom_group` input rows. |
| `app/Livewire/System/ItemMasterDataForm.php` | Drop `item_type` + `uom_group` properties + `loadFromDb()` assignments + `update()` payload entries. |
| `docs/modules/inventory.md` | Last-updated entry per CLAUDE.md. |

No migration. No seeder/factory changes. No new files outside docs. No tests to update (`ItemMasterDataFormTest` doesn't exist).

## Acceptance

- Item Master Data create page (`/system/item-master-data/create`) and edit page (`/system/item-master-data/{id}/edit`) render with the 14 trimmed targets gone.
- Main tab order is exactly: General · Aero One · Inventory Data · Remarks · Attachments.
- Identity card on the edit page shows 5 fields (Code, Description, Manufacturer, Item Group, Item Class).
- Edit Record toggle still works on the surviving Identity card fields.
- Saving the Identity card via Livewire still persists `code`, `description`, `manufacturer`, `item_group`, `item_class`. (`item_type` / `uom_group` persistence drops; columns retain whatever the seeder/factory wrote.)
- Aero One tab still launches the counter-template modal via right-click → Define Counters.
- No console / Livewire / PHP errors when navigating between surviving tabs in both create and edit modes.

## Risks

- **`item_type` / `uom_group` un-editability** is the only behavioural change. Documented in module file. If a future workflow needs to mutate these, a new mutator page (or restoring the bindings) is the path.
- **Alpine state object mass-strip** — any orphan key reference left in the surviving markup will throw at runtime. Mitigation: grep the partial after edits for any `item.<deleted_key>` references and ensure none survive.
- **Mock-data array branches** — the `@js(...)` block has a primary state at line 13 and an empty-state mirror at line 74. Both need the orphan-key strips applied in lockstep, or the empty-state branch will diverge.

## Branch + PR

- Branch: `refactor/item-master-data-trim` (already created off `origin/master`).
- One PR. Auto-merge squash per the user's standing preference for `refactor/*` branches.
- Commit lead: `refactor(inventory): restructure item master data per 2026-04-27 user kill list`.
- PR body should cross-link the FL trim (PR #90) and Equipment Card trim (PR #91) as the playbook precedent.
