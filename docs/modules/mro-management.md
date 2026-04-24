# MRO Management — module state

Ninth L1. Work orders, work packages, time tracking, defects for the
maintenance-repair-overhaul workflow.

## Scope

### L2 entries

| L2 | Purpose |
|---|---|
| Work Package | Aggregate maintenance task grouping |
| Work Order | Single work order execution |
| Time Tracking → Time Sheet | Man-hour recording |
| Defects | Defect list |

### DB tables owned here

- `work_orders` — seeded

### Livewire components owned here

Not yet formalised — pages are plain Blade.

## Current state

### Shipped
- Work Order detail page (`/mro/work-order/detail`) with 7-tab layout (General / Details / Properties / General / References / Action / Summary)
- Technical Log detail page (`/mro/work-order/technical-logs/{log}`)
- Edit Record toggle on both
- `work_orders` table + seeder

### Stubbed
- Work Package standalone page → `pages.stub`
- Time Sheet page exists but logic minimal
- Defects page → `pages.stub`

### Not started
- Work Package composition logic
- Real time entry + approval flow

## SAP / Weststar reference

Partial. Work Order form screenshots received earlier in the codebase
exploration phase (pre-module-doc system). Need to re-request if
detailed spec needed.

## Design decisions

- MRO Management was heavily pruned during the sidebar redesign (PR #39). Removed: standalone Repair Information Cockpit, Task list, Start/End Operation. Work Order and Time Sheet kept.

## Cross-L1 touchpoints

- **Fleet Management** — Work Orders attach to Equipment / FL; mutate counter state via their outcome.
- **Administration > MRO Management** — Work Order Type, Defect Type, Status Management & Workflow reference tables (all stubbed).
- **Inventory** — Work Orders consume Items (parts).

## Outstanding

- Work Package page implementation
- Real time-tracking flow (Time Sheet → approval)
- Defects catalog + list
- Integration with Work Order Type / Defect Type reference tables (under Admin)

## Last updated

- 2026-04-25 — module file created. Work Order detail page shipped; Work Package and Defects stubbed.
