# Enterprise Components Progress

Last updated: 2026-04-27 (post #87)

Purpose: cross-cutting tracker for enterprise-component adoption.

Per-module shipped/stubbed state belongs in `docs/modules/<l1>.md`.
This file tracks only shared migration rules, catalog gaps, and repo-wide
priority order.

## Ownership Boundary

- [x] Per-L1 module state lives in `docs/modules/<l1>.md`.
- [x] This file is not second module tracker.
- [x] Use this file for foundation work, shared rules, and migration order only.

## Foundation

### Catalog primitives

- [x] `x-enterprise.input` exists with variant system.
- [x] `x-enterprise.select` exists.
- [x] `x-enterprise.textarea` exists.
- [x] `x-enterprise.checkbox` exists, including `inputClass` hook.
- [x] `x-enterprise.radio` exists.
- [x] `x-enterprise.label` exists.
- [x] `x-enterprise.panel` exists.
- [x] `x-enterprise.field-row` exists.
- [x] `x-enterprise.table-shell` exists.
- [x] `x-enterprise.action-bar` exists.
- [x] `x-enterprise.input variant="cell"` exists.

### Shared conventions

- [x] `enterprise` is base vocabulary for SAP-style detail forms.
- [x] `form/*` already has documented role in `CLAUDE.md`.
  Use `form/*` for auth/composite label+input+error forms.
  Use `enterprise/*` for SAP dense detail forms.
- [x] Edit Record toggle pattern is standard.
  Alpine `editMode()` + `[data-edit-scope]` / `[data-editing]`.
- [x] Compiled assets in `public/build/` must be rebuilt and committed when Tailwind / Vite-imported JS changes.
- [x] CI discipline exists.
  PHPUnit failures are merge blockers.

### Active foundation work

- [x] Fix `x-enterprise.field-row` API mismatch.
  Resolved in #83 — `field-row` now accepts and applies `columns` prop.
- [ ] Standardize modal layer.
  Shared `<x-modal>` exists, but most real modals still use custom shells.
- [ ] Fill required-field affordance catalog gap.
  Red bold label + yellow field background pattern tracked in `feature/required-field-affordance`.
- [ ] Consolidate remaining `x-form.*` callsites where they no longer fit the documented rule.
  Current repo count: `54` `x-form.input` callsites, `122` total `x-form.*` callsites.
- [ ] Stop adding new raw `.input-field` markup except true catalog-gap exceptions.

## Cross-Cutting Findings

- [ ] Business Partner forms are biggest mismatch.
  Enterprise outer shell, but controls inside still mostly raw HTML.
- [ ] Flight pages have many `field-row columns=` callsites.
- [ ] MRO pages have many `field-row columns=` callsites.
- [ ] Custom modal shells remain common in Fleet, Maintenance, Reports, and partials.

## Module References

Use module docs for per-L1 state:

- [x] Dashboard → `docs/modules/dashboard.md`
- [x] Administration → `docs/modules/administration.md`
- [x] Business Partners → `docs/modules/business-partners.md`
- [x] Inventory → `docs/modules/inventory.md`
- [x] Human Resources → `docs/modules/human-resources.md`
- [x] Technical Data → `docs/modules/technical-data.md`
- [x] Fleet Management → `docs/modules/fleet-management.md`
- [x] Flight Recording → `docs/modules/flight-recording.md`
- [x] MRO Management → `docs/modules/mro-management.md`
- [x] Reports → `docs/modules/reports.md`

Non-L1 URL prefixes:

- [x] `pages/operations/*` is not separate L1. Treat under owning L1, usually MRO / Fleet runtime flows.
- [x] `pages/services/*` is not separate L1. Treat as cross-cutting sub-domain, not top-level module.

## Priority Order

- [ ] 1. Foundation cleanup.
  Fix `field-row` prop mismatch, standardize modal pattern, close required-field affordance gap.
- [ ] 2. Business Partners.
  Biggest live mismatch between enterprise shell and raw controls.
- [ ] 3. Flight Recording.
  Heavy `field-row` usage, many raw controls, many future workflow forms.
- [ ] 4. MRO Management.
  Similar cleanup shape after Flight.
- [ ] 5. Fleet / Administration audit pass.
  Stronger already; focus on modal standardization and leftover raw control cleanup.
- [ ] 6. Stub-first modules.
  Human Resources, Technical Data, and untouched report leaves should start enterprise-first when built.

## Candidate PRs

- [x] `fix/enterprise-field-row-columns-prop` — shipped as #83.
- [ ] `refactor/enterprise-modal-standardize`
- [ ] `feature/required-field-affordance`

## Working Rules

- [ ] New SAP-style screen: use `enterprise/*` first.
- [ ] New auth/composite error form: use `form/*` only when label+input+error must travel together.
- [ ] New lookup UI: use enterprise variant or extend enterprise catalog first.
- [ ] New modal: use shared modal pattern, or upgrade shared modal before adding another custom shell.
- [ ] Update this file when shared migration rules change.
- [ ] Update `docs/modules/<l1>.md` when per-module adoption state changes.
