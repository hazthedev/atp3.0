# Fleet Management — module state

Seventh L1. The largest module by code weight. Covers aircraft-level records,
installed equipment, technical publications application, maintenance
planning, and operational inputs.

## Scope

### L2 entries

| L2 | L3 |
|---|---|
| Functional Location | Functional Location Card, Attach equipment, Detach equipment, Configuration Control, Airworthiness Review |
| Equipment | Equipment Card, Attach Equipment, Detach Equipment, Swap Equipment |
| Technical Publications | Administration, Application |
| Maintenance Plan | Maintenance Plan Administration, Utilisation Model, Maintenance Planning, Work Package |
| Operational Inputs | Daily Updates, Fleet Management Cockpit, Defects |
| Initialization | Apply Maintenance Program, Structure Duplication |

### DB tables owned here

- `functional_locations`
- `functional_location_counters` + `functional_location_calendar_counters`
- `equipments` (uncountable noun workaround — `protected $table = 'equipments'` on model)
- `equipment_counters` + `equipment_calendar_counters`
- `counter_history` — audit trail, polymorphic subject
- `counter_info_sources` — 6-row lookup
- `penalties` + `penalty_rules`

### Livewire components owned here

- `Fleet\CustomerEquipmentCardPage` + `EquipmentShowForm`
- `Fleet\FunctionalLocationSearchPage`
- `Fleet\FunctionalLocationShowForm` (save persistence for the top card)
- `Fleet\FunctionalLocationCountersManager` (3-tab modal: General / Penalties / Specific)
- `Fleet\EquipmentCountersManager`
- `Fleet\ItemCountersManager` (lives here because it's Fleet-context, even though the template itself is Inventory)
- `Fleet\AttachEquipmentPage`, `DetachEquipmentPage`, `ChangeCustomerInformationPage`
- `Fleet\GenerateEquipmentCardPage`
- `Fleet\ModificationSearchPage`
- `App\Services\PenaltyEngine` + `PenaltyCascadeResult` DTO

### Models owned here

- `FunctionalLocation`, `FunctionalLocationCounter`, `FunctionalLocationCalendarCounter`
- `Equipment`, `EquipmentCounter`, `EquipmentCalendarCounter`
- `CounterHistory`
- `CounterInfoSource`
- `Penalty`, `PenaltyRule`

## Current state

### Shipped

- **FL Search** (`/fleet/functional-location`) — shared `<x-data-table datatable>` pattern.
- **FL Show** (`/fleet/functional-location/{id}`) — full 7-tab detail page with Edit Record toggle, variants restored (PR #47, #49), trimmed per spec (PR #41 reverted — original kept). Top card uses `FunctionalLocationShowForm` Livewire for save persistence.
- **Equipment list + detail** — including Customer Equipment Card page with Edit Record and save persistence on the summary card.
- **Counter module** — three tiers fully wired. Item templates → Equipment readings → FL readings with `counter_history` audit trail on every write.
- **PenaltyEngine** — cascade service with recursion depth-5 guard, naive installed-base lookup, HH:MM→decimal-minutes derivation at save time so time-class counters fire cascades (PR #38). Integrated into FL + Equipment counters managers.
- **Counter info sources** lookup (6 seeded).
- **Tone as computed accessor** on counters.
- **linked_equi_id → linked_equipment_id** refactor (FK with naive lookup).

### Partial / known issues

- **Naive installed-base lookup** inside `PenaltyEngine::resolveTarget()` — `Equipment::where('item_id', $target)->where('status', 'On Aircraft')` finds any engine of the right type, not necessarily the one on this aircraft. Fine for single-aircraft dev seed; ambiguous once a real fleet has multiple AW139s.
- **firstOrCreate on missing target counter** — when a cascade targets an equipment that has no row for the target counter, the engine creates the row on the fly. Defensible, but means cascades never fail loudly.
- **E#n vs per-engine CC semantics** — the seeded rule conflates aircraft-side E#1CC with the engine's own CC. Needs re-authoring once Weststar provides real penalty rules.
- **`subject_type` string drift risk** — 17 literals scattered across the codebase; advisor flagged for a future `App\Enums\CounterSubject` centralisation sprint.
- **FL save persistence only covers the top identity card** — everything below (General / Counters / Equipment / Modifications / Properties / Events / Attachments) is still read-only with mocked data.

### Stubbed

- Attach / Detach Equipment flows (pages exist, logic partial)
- Modification module (Apply to FL / Apply to Equipment / Equipment Reference Evolution)
- Configuration Control, Airworthiness Review (FL) — Configuration Control should match the "Equipment Tree" feature in SAP Aero One
- Technical Publications Administration / Application (under Fleet Management L2)
- Maintenance Plan Administration / Utilisation Model / Maintenance Planning
- Operational Inputs — Defects specifically

### Not started

- Work Package construction logic
- Component Monitoring / Maintenance Item Monitoring (pages exist, shell only)
- Repair Information Cockpit functionality
- Initialization flows (Apply Maintenance Program, Structure Duplication)

## SAP / Weststar reference

Screenshots received and mapped:

- **FL Customer Functional Location** top card + 7 tabs — canonical variant mapping in `docs/ui-variants.md` (Code / Status / Serial No / Maintenance Plan / Owner Code / Type / Owner Name / MEL / Operator Code / Operator Name)
- **Update Counters modal** — for Items, Equipment, and FL
- **SAP Penalty configuration form** — 6 master penalty types
- **FL revamp brief** — fields marked for removal / keep (General tab trimmed in PR #41 but reverted in PR #42; trim is still pending user direction)

## Design decisions

- **Edit Record toggle** pattern applied to all detail pages.
- **Counter three-tier** architecture: Item (template) → Equipment / FL (readings). No `functional_location_types` layer (deliberate call per advisor).
- **Tone computed**, not stored.
- **linked_equipment_id** is FK to the specific installed equipment; not a hierarchy lookup.
- **Penalty rules are polymorphic** — attach to FL or Item.
- **`equipments` plural** — Laravel uncountable-noun workaround; documented on the model.

## Cross-L1 touchpoints

- **Inventory** → Fleet: `Equipment.item_id`, `FunctionalLocation.item_id`.
- **Technical Data** → Fleet: Aircraft Variants, Category Part, Utilization Models all referenced by FL / Equipment.
- **Business Partners** → Fleet: `FunctionalLocation.owner_code / operator_code` + `Equipment.owner_code / operator_code` — free strings today, future FK to BP.
- **Administration > User Management** → Fleet: `counter_history.user_id` FK to users; who made each counter edit.
- **Administration > Utilities** → Fleet: Change Customer Information and Equipment Reference Evolution routes live under Admin but mutate Fleet data.
- **Flight Recording** → Fleet (future): Flight Details will write to FL counters via the PenaltyEngine with selectedPenaltyIds.

## Outstanding

Huge. In rough priority order:

1. **Flight → Daily Flight Log → Daily Updates** input pipeline (the next-sprint candidate flagged by the advisor after the penalty engine shipped)
2. **Attach / Detach Equipment** end-to-end — ties into installed-base hierarchy
3. **Modification** module (Technical Publications Administration / Application)
4. **Maintenance Plan Administration** — compose visits + tasks into programs
5. **Installed-base hierarchy table** — fixes the naive lookup in PenaltyEngine, unblocks sub-equipment targeting
6. **subject_type enum** — centralise the 17 string literals per advisor recommendation
7. **Counter history UI** — the "Counter History" button on FL exists but isn't wired

## Last updated

- 2026-04-28 - Equipment index (`/fleet/equipment`) now follows the recent FL-derived actions pattern by adding a non-sortable `Actions` column with `View | Edit`, while intentionally preserving the Equipment-specific chevron-circle `ID` lead cell as a user-approved exception. `View` uses the canonical Equipment show route and `Edit` reuses the existing customer-equipment-card flow because Fleet Equipment still edits through the in-page `Edit Record` toggle rather than a dedicated `equipment.edit` route. Spec: `docs/superpowers/specs/2026-04-28-equipment-index-actions-parity-design.md`.
- 2026-04-28 - FL Search (`/fleet/functional-location`) table aligned to a user-provided SAP sample. The page now shows only the three screenshot rows (`9M-WAA`, `9M-WAB`, `9M-WAD`) and removes the visible `Op. Code` / `Ow. Code` columns while preserving the shared datatable shell, arrow-linked ID cell, and `View | Edit` actions. Kept page-specific by narrowing `FunctionalLocationSearchPage` instead of changing the shared `FunctionalLocationCatalog`. Spec: `docs/superpowers/specs/2026-04-28-functional-location-search-table-sap-content-design.md`.

- 2026-04-27 — `refactor/equipment-card-trim` (same playbook as the FL trim). Restructured the customer equipment card detail page per a user-authored kill list, plus added a new mock **Maintenance** tab. View-layer + Livewire bindings only; no DB schema change. Removed: top-card `owner_code` / `operator_code` / `mel` rows; Change References button; Counters tab `Residual` + `Equi. ID` columns from both tables; Events sub-tabs `Repairs` and `Others`; Properties1 fields `manufacturer_item_code`, `configuration_standard`, `mission_type`, `external_key`, `environment_type`, `contract_type`, `oil_type`, `purchase_cost_of_engine`, `remark_text`; Properties tab `Installed Base Data Anomaly` section; Properties tab subtab nav (collapsed to single un-tabbed pane); Address tab; Trans. tab; Remark tab. New Maintenance tab with two subtabs ("Task List on sub equipment" + "Task List History of equipment"), modeled on two SAP modal screenshots; mock data only. `EquipmentShowForm` no longer binds `owner_code` / `operator_code` / `mel` (DB columns stay; ChangeEquipmentCustomerInformationPage and AttachEquipmentPage remain the canonical mutators). `EquipmentShowFormTest` assertions trimmed accordingly (25 assertions still passing). Spec at `docs/superpowers/specs/2026-04-27-equipment-card-restructure-design.md`.
- 2026-04-27 — `refactor/fl-page-trim` (supersedes the reverted PR #41). Trimmed the FL show page per a fresh user-authored kill list. View-layer + Livewire bindings only; no DB schema change. Removed: top-card `owner_code` / `operator_code` rows; General-tab `mission_type` / `environment_type` / `oi_type` rows; Counters tab `Residual` + `Equi. ID` columns from both tables; Properties tab `Installed Base Data Anomaly` section; Events sub-tabs `Repairs` and `Others`. `FunctionalLocationShowForm` no longer binds `owner_code` / `operator_code` (DB columns stay; ChangeCustomerInformationPage remains the canonical mutator). Stripped the 3 General-tab mock keys from `FunctionalLocationCatalog`. Spec at `docs/superpowers/specs/2026-04-27-fl-page-restructure-trim-design.md`. Trim item is now resolved — the "FL trim per revamped spec" entry under Outstanding can be considered done.
- 2026-04-25 — module file created. Substantial work shipped; input pipeline (flights) not yet started.
- 2026-04-24 — PR #62 `refactor/adoption-fleet-management` (Phase A2 of the enterprise-components adoption campaign) — 10 Fleet/Maintenance Livewire views migrated to enterprise components. Hot spots fixed: `change-equipment-customer-information-page` (inline `style="grid-template-columns"` hack removed in favour of `<x-enterprise.field-row>`); `maintenance-plan-administration-page` (6 filter selects → bare `<x-enterprise.select>`, 5 readonly display fields → `<x-enterprise.input variant="disabled">`). Edit Record toggle scopes, arrow-chevron list-table semantics, and the FL show-form's spec-driven variants (`tree`, `arrow-lookup`, `arrow-indicator`, `indicator` with `tone="green"`) all preserved. Radio inputs left raw (no `<x-enterprise.radio>` at the time).
- 2026-04-25 — PR #65 `refactor/enterprise-catalog-followups` — added `<x-enterprise.radio>` component, then migrated radios in `minimum-equipment-list-page`, `maintenance-plan-administration-page`, `simulation-on-fleet-page`. Migrated the `functional-location-counters-manager` modal: 11 cell inputs to `variant="cell"`, 3 dense h-3.5 checkboxes preserved via the new `inputClass` prop on `<x-enterprise.checkbox>`. Penalties-tab inputs deliberately not migrated (use `.input-field`, not the cell pattern).
