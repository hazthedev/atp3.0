# Flight Recording — module state

Eighth L1 (renamed from "Flight Operations" during the sidebar redesign,
PR #39). Input pipeline for flight-by-flight data that feeds the counter
system.

## Scope

### L2 entries

| L2 | Purpose |
|---|---|
| Flight Details | Per-flight record entry |
| Technical Log | Per-flight technical log (formerly Daily Flight Log) |
| Defects | Defect list |

### DB tables owned here

- `technical_logs` — seeded
- Flight-records table does NOT yet exist

### Livewire components owned here

None yet — routes point at existing `pages.flight.*` views.

## Current state

### Shipped
- Routes:
  - `flight.flight-details` → `pages.flight.flight-record.create`
  - `flight.technical-log` → `pages.flight.daily-flight-log` (same view as daily-flight-log; renamed link)
  - `flight.defects` → `pages.stub`
- `technical_logs` table + seeder

### Stubbed
- Defects page

### Not started
- Actual Flight record creation flow
- Integration with PenaltyEngine — the *advisor's* next-sprint candidate after the penalty engine shipped

## SAP / Weststar reference

No form-level spec received yet. Advisor notes:
- Daily Flight Log is the per-aircraft-per-day aggregator
- Daily Flight Log is the first real caller of `PenaltyEngine::cascade()` with a non-empty `$selectedPenaltyIds` filter (matching SAP's "Apply Penalties to a Flight" behaviour)

## Design decisions

- Renamed Daily Flight Log → Technical Log in the sidebar (PR #39); route still serves the same view for now.

## Cross-L1 touchpoints

- **Fleet Management** — flight records will mutate `functional_location_counters` via PenaltyEngine.
- **Administration > User Management** — flight records created by a user → `counter_history.user_id`.

## Outstanding

Per the advisor's roadmap:

1. **Flights table + minimal Flight Details CRUD** — the atomic unit of flight data.
2. **Daily Flight Log** — aggregator with per-flight penalty selection.
3. **Daily Updates** — reconciliation screen that commits to FL counters.

These three sprints together form the input pipeline that makes the
Fleet Management counter system receive real data.

## Last updated

- 2026-04-25 — module file created. Input pipeline not yet started.
