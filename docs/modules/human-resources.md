# Human Resources — module state

Fifth L1. Employee records and HR master data.

## Scope

### L2 entries

| L2 | Purpose |
|---|---|
| Employee Master Data | Employee list / detail (TBD) |

### DB tables owned here

None yet.

### Livewire components owned here

None yet.

## Current state

### Shipped
- Sidebar link
- Route: `/hr/employee-master-data` → `pages.stub`

### Stubbed / mocked
All of HR. No table, no model, no real form.

### Not started
Everything.

## SAP / Weststar reference

No spec received yet.

## Design decisions

None yet.

## Cross-L1 touchpoints

- **Administration > User Management** — `User.employee` field is a free string today; will become FK to Employee when this L1 is built.
- **Business Partners** — employees may also be modelled as internal BPs in SAP. Clarify the relationship when spec arrives.

## Outstanding

- Awaiting spec from user.

## Last updated

- 2026-04-25 — placeholder created.
