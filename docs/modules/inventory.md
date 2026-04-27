# Inventory — module state

Fourth L1. Item master data and inventory management.

## Scope

### L2 entries

| L2 | Purpose |
|---|---|
| Item Master Data | Item list + create/edit detail page |

### DB tables owned here

- `items` — 42 seeded rows including the PT6C-67C engine and 41 parts from the Weststar SAP import
- `item_counters` — template counter definitions per item (ref `PT6C-67C` and `AW139`)
- `item_calendar_counters` — per-item calendar limit templates

### Livewire components owned here

- `App\Livewire\System\ItemMasterDataForm` — save persistence on the Identity card
- `App\Livewire\Fleet\ItemCountersManager` — "List of Counters" modal (Aero One right-click launch)

## Current state

### Shipped
- Item list at `/system/item-master-data` with 17-column SAP-style table
- Item detail / edit at `/system/item-master-data/{id}/edit`
- Edit Record toggle on the Identity card (persists code / description / manufacturer / item_class / item_type / uom_group)
- Counter template management via right-click context menu → List of Counters modal
- Seeder: 42 items from Weststar SAP export; PT6C-67C and AW139 both have seeded counter templates

### Stubbed / mocked
- Most of the big form outside the Identity card is an Alpine preview with mock data (`$item` array via `@js(...)`). Only the Identity block is persisted; everything else is cosmetic.

### Not started
- Save wiring for the rest of the Item MD form tabs (Aero One tab beyond counters, Purchasing, Sales, Inventory, Planning, Properties, Remarks, Attachments)
- Item picker component for other L1s

## SAP / Weststar reference

- Item Master Data edit form — 17-column SAP list screenshot was received; form structure matches that vocabulary.

## Design decisions

- **Counter templates live on Items** (via `item_counters`), then inherited when Equipment / Functional Locations are seeded / created. Deliberate choice vs introducing a separate `functional_location_types` table.
- Items table schema is very wide (17 extra columns) — SAP-literal to avoid losing fidelity.

## Cross-L1 touchpoints

- **Fleet Management** — `Equipment.item_id` and `FunctionalLocation.item_id` both FK to Items.
- **Administration > Stock Management** — future Item Groups / Category Part / Warehouses reference tables will join against Items.
- **Counter module** — Items are the template source for equipment + FL counter rollouts.

## Outstanding

- Wire save persistence on Aero One tab, Purchasing, Sales, Inventory, Planning, Properties, Remarks, Attachments
- Item picker component
- Real Category Part + Item Group + Warehouses lookup tables (overlaps with Admin > Stock Management scope)

## Last updated

- 2026-04-27 — `refactor/item-master-data-trim` (same playbook as the FL trim PR #90 and Equipment Card trim PR #91). Restructured the Item Master Data create + edit page per a user-authored kill list. View-layer + Livewire bindings only; no DB schema change. Removed: top-form `foreign_name`, `item_type`, `uom_group`, `price_list`, `bar_code`, `unit_price`, `unit_currency` rows + Item Classification panel (Inventory/Sales/Purchase/Tool Item checkboxes); General-tab `Do Not Apply Discount Groups`, `Additional Identifier`, `Shipping Type`, `Item Code Aerospace Defense` fields; 4 full tabs — Purchasing Data, Sales Data, Planning Data, Properties. Final main tab order: General · Aero One · Inventory Data · Remarks · Attachments. **Behavioural change:** `ItemMasterDataForm` no longer binds `item_type` / `uom_group`. Unlike FL/Equipment, the Item module has no canonical fallback mutator for these columns — values on `items.item_type` / `items.uom_group` will now only be set by the seeder/factory. Identity card surviving fields: code, description, manufacturer, item_group, item_class. Spec at `docs/superpowers/specs/2026-04-27-item-master-data-restructure-design.md`.
- 2026-04-25 — module file created. Identity card persists; rest is mock.
- 2026-04-24 — PR #63 `refactor/adoption-inventory` (Phase A3 of the enterprise-components adoption campaign) — 3 files migrated to enterprise components: `system/item-master-data-form` (Livewire Identity card, 7 raw text inputs → `<x-enterprise.input>`), `fleet/item-counters-manager` (counter-modal grid with cell inputs/selects), `pages/system/item-master-data/partials/form` (Alpine mock preview — 11 text inputs, 11 selects, 1 textarea, 5 inline-label checkboxes via Option-A bare mode). Counter-template modal pattern preserved; `wire:model` and `@readonly`/`@disabled` intact. Deferred: 3 status radios (no enterprise radio at the time — closed by PR #65).
