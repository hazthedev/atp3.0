# Technical Data — module state

Sixth L1. Configuration management, technical publications, and maintenance
program templates. Carved out of the Administration L1 during the sidebar
redesign (PR #39) to separate template-level definitions from runtime use.

## Scope

### L2 entries

| L2 | L3 |
|---|---|
| Configuration Management | Family, Type, Variant, Applicable Configuration |
| Technical Publications | Single page |
| Maintenance Program | Visit, Task, Maintenance Program Administration |

### DB tables owned here

- **Visits** — seeded by `VisitSeeder`
- **Task Types** — seeded by `TaskTypeSeeder`
- **Utilization Models** — seeded by `UtilizationModelSeeder` (consumed by Fleet Management's Maintenance Plan)
- **Aircraft Variants** — seeded by `AircraftVariantSeeder`
- **Category Part** — seeded by `CategoryPartSeeder`
- **MEL Categories** — seeded
- **Technical Log Types** — seeded
- **Workflow Groups** — seeded

### Livewire components owned here

Not yet formalised — reference pages exist as routes to `pages.reference.*`
views. Need to check whether those are Livewire-backed or plain Blade.

## Current state

### Shipped
- Routes for all L3 items (mostly stub views)
- `technical-data.maintenance-program.visit` → `pages.reference.visits` (real reference data page)
- `technical-data.maintenance-program.task` → `pages.reference.task-types` (real reference data page)
- Seeders for all the reference tables

### Stubbed
- Configuration Management → Family, Type, Variant, Applicable Configuration
- Technical Publications (standalone page under this L1)
- Maintenance Program Administration

### Not started
- CRUD UIs for Family / Type / Variant / Applicable Configuration
- Technical Publications catalog
- Maintenance Program Administration screen

## SAP / Weststar reference

No detailed spec received yet for the CRUD screens. When starting, request SAP screenshots for:
- Aircraft Variants list + edit
- Functional Location Family setup
- Functional Location Type setup
- Applicable Configuration catalog
- Technical Publications catalog

## Design decisions

- **Reference data split** between the **templates** (Technical Data L1) and the **runtime instances** (Fleet Management L1). Aircraft Variants define types; Functional Locations ARE of a type.
- The sidebar had this L1 added specifically to separate template ownership.

## Cross-L1 touchpoints

- **Fleet Management** — FL and Equipment both reference Aircraft Variants and Category Part.
- **Inventory** — Items reference Category Part.
- **Maintenance Plan** (in Fleet Management) — uses Utilization Models defined here.

## Outstanding

- CRUD for Configuration Management leaves
- Technical Publications index + detail
- Maintenance Program Administration — this is where visits + tasks compose into a full program; likely the highest-value next sprint

## Last updated

- 2026-04-25 — module file created. Reference tables seeded; most CRUD is stubbed.
