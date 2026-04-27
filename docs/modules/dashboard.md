# Dashboard — module state

First L1 in `config/navigation.php`. Landing experience when a user signs
into ATP 3.0.

## Scope

### L2 entries under Dashboard

| L2 | Purpose |
|---|---|
| User Dashboard | Per-user widgets (TBD) |
| Fleet Dashboard | Filter → matrix → details flow (relocated from Fleet Synthesis on 2026-04-27) |

### DB tables owned by Dashboard

None yet — dashboard reads from other L1s' data.

### Livewire components owned here

None yet.

## Current state

### Shipped
- Sidebar links present.
- Fleet Dashboard L2 routes to the relocated synthesis filter / matrix / details flow.

### Stubbed
- User Dashboard → `pages.stub`

### Not started
Everything substantive. Dashboard widgets need a spec first.

## SAP / Weststar reference

No spec received yet. Request screenshots from user before starting the first real sprint on this L1.

## Design decisions

None yet.

## Cross-L1 touchpoints

- Dashboard widgets will pull from every other L1's data. Treat cross-L1 reads as explicit dependencies and note them here when implemented.

## Outstanding

- TBD — awaiting user direction on what Dashboard should show.

## Last updated

- 2026-04-25 — module file created as placeholder. No substantive work yet.
- 2026-04-27 — Fleet Synthesis content relocated under Fleet Dashboard. Sidebar Fleet Synthesis entry removed. Routes/URLs renamed `dashboard.fleet[.matrix|.details]`. See spec `2026-04-27-fleet-dashboard-relocate-synthesis-design.md`.
