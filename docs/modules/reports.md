# Reports — module state

Tenth L1. Fleet commercial and fleet management reports plus time tracking.

## Scope

### L2 entries

| L2 | L3 |
|---|---|
| Fleet Commercial Report | Equipment Reliability (Aero One), Equipment Utilization (Aero One), Monthly Aircraft Report (Aero One), Monthly Engine Report (Aero One) |
| Fleet Management Report | Due List Report (CAMP), Life Limit / Overhaul Report (CAMP), Time Controlled Items Report (CAMP), Status Report (CAMP), Status Check (Aero One), ADSB Status (Aero One), Monthly Flight Hour (Aero One) |
| Time Tracking → Personal experience | Per-user hour tracking |

Plus two legacy top-level reports still routed:
- `reports.fleet-synthesis` (exposed via Dashboard L1)
- `reports.fleet-report`
- `reports.time-tracking` (legacy top-level)

### DB tables owned here

None — reports are read-only views of other L1s' data.

### Livewire components owned here

None yet.

## Current state

### Shipped
- All routes registered (PR #39)
- Legacy pages for `fleet-synthesis`, `fleet-report`, `time-tracking`, `historical-equipment-hierarchy`, `view-modification-on-equipment` have existing Blade views

### Stubbed (pages.stub)
- All 12 Fleet Commercial + Fleet Management report variants
- Personal experience under Time Tracking

### Not started
Report generation logic for any of the stubs. Most likely needs:
- Aggregation queries over `counter_history` / `equipment_counters` / `functional_location_counters` / `work_orders` / `technical_logs`
- Date range filters
- Exportable formats (PDF / Excel)

## SAP / Weststar reference

No specs for the individual report layouts received yet. Suggested when
starting: request Weststar samples for at least:
- Due List Report (CAMP format)
- Monthly Aircraft Report
- Equipment Utilization

## Design decisions

- Reports are grouped by **consumer** (Commercial vs Management), not by data source.
- Legacy (`fleet-synthesis`, etc.) routes kept for backwards compatibility with existing pages.

## Cross-L1 touchpoints

- **Every L1** — reports read aggregated data. When implementing, note which tables are queried and which L1 owns them.
- **Fleet Management** — heaviest data source (counters, equipment, FL).

## Outstanding

Everything. Priority list needs user direction. Candidate starting points:
- **Monthly Flight Hour (Aero One)** — simple aggregation over `counter_history` for time-class counters
- **Due List Report (CAMP)** — cross joins `item_counters` limits with `equipment_counters` readings
- **Status Report (CAMP)** — Work Order status by date range

## Last updated

- 2026-04-25 — module file created. All stubbed; no real reports yet.
