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
- Configuration Control, Airworthiness Review (FL)
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
5. **FL trim per revamped spec** — the reverted PR #41 changes (decide keep/discard before re-applying)
6. **Installed-base hierarchy table** — fixes the naive lookup in PenaltyEngine, unblocks sub-equipment targeting
7. **subject_type enum** — centralise the 17 string literals per advisor recommendation
8. **Counter history UI** — the "Counter History" button on FL exists but isn't wired

## Last updated

- 2026-04-25 — module file created. Substantial work shipped; input pipeline (flights) not yet started.
