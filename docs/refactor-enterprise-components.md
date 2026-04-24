# Enterprise Components Refactor — Progress Tracker

**Started:** 2026-04-24
**Orchestrator / reviewer:** Claude (Opus 4.7)
**Scope:** apply all five refactor targets identified in the component audit.

**Cross-reference:**
- [docs/ui-variants.md](ui-variants.md) — variant catalog (update at the end of each phase that changes component API)
- [docs/modules/](modules/) — per-L1 module docs (update Phase A entries)

**Legend:** `[ ]` pending · `[~]` in progress · `[x]` done · `[!]` blocked

---

## Phase D — CSS conflict cleanup  `[x]`
Lowest-risk starter. Removes the overridden `.pending-base-table` ruleset.

- **Target:** [resources/css/app.css](../resources/css/app.css)
- **Branch:** `fix/app-css-table-conflict` (pushed, commit `b60b3c6`)
- **Result:** 19 lines removed. Kept the shared ruleset that styles `.enterprise-static-table`, `.pending-base-table`, `.min-w-full.border-collapse` uniformly (slate palette, `px-4 py-3`, `blue-50/40` hover). Kept the unique `min-w-full border-collapse` declaration and `td { white-space: nowrap }`.

- [x] Subagent: identify authoritative ruleset — *subagent picked the wrong one; orchestrator corrected*
- [x] Orchestrator: reset branch, apply surgical fix, force-push
- [x] PR URL: https://github.com/hazthedev/atp3.0/pull/new/fix/app-css-table-conflict (open manually — `gh` CLI not installed locally)
- [ ] Merge to master (awaiting user)

**Lesson logged:** when a "duplicate" CSS block actually has a broader selector list, the later block usually wins the cascade — don't delete it without checking who else depends on the aliased selectors.

---

## Phase C — Remove dead component  `[x]`
**Rescoped.** Original audit was wrong: `table-shell` has **46 direct callers** (198 occurrences) across Fleet, Maintenance, Reports, CRM, MRO, Flight, Services; `action-bar` has **40 callers** (80 occurrences). Both are active architectural primitives, not dead code. Only `mini-button` is truly dead (0 callers).

**Architectural note:** `table-shell` is the raw table primitive; `data-table` is the enriched variant adding search/pagination. Several callers use `:datatable="false"` which `data-table` doesn't expose. Keep the separation.

- **Target:** [resources/views/components/enterprise/mini-button.blade.php](../resources/views/components/enterprise/mini-button.blade.php) → delete
- **Branch:** `refactor/enterprise-remove-mini-button`

- [x] Re-confirm 0 direct callers — ripgrep found 0 across `resources/` and `app/`
- [x] Delete `mini-button.blade.php`
- [x] Commit (`30cec2b`)
- [x] Push — PR URL: https://github.com/hazthedev/atp3.0/pull/new/refactor/enterprise-remove-mini-button
- [ ] Merge to master (awaiting user)

**Lesson logged:** usage audits based on grepping `<x-enterprise.X>` must distinguish "used directly" from "used via wrapper component" — the first Explore agent conflated the two, leaving `table-shell` looking orphaned when it's actually the primitive.

---

## Phase E — Consolidate rare input variants  `[x]`
`tree`, `arrow-lookup`, `arrow-indicator`, `indicator` variants — each used only in `functional-location-show-form.blade.php`.

- **Targets:** [input.blade.php](../resources/views/components/enterprise/input.blade.php), [functional-location-show-form.blade.php](../resources/views/livewire/fleet/functional-location-show-form.blade.php), [docs/ui-variants.md](ui-variants.md)
- **Branch:** `refactor/enterprise-input-variants`
- **Decision:** KEEP. All four variants are documented in the visual decision tree (rules 2, 3, 4, 6) with explicit Weststar FL screenshot cues, and the FL show form is the canonical reference implementation. Consolidating into generic props (e.g. `lookup` + `chevron` + `tone`) would flatten the SAP decision-tree vocabulary that teaches readers to recognise each cue as a distinct variant. Per CLAUDE.md bias ("DO NOT delete variants that are already in the catalog with a screenshot reference") — preserve as FL-specific vocabulary.

- [x] Subagent: cross-check against [docs/modules/fleet-management.md](modules/fleet-management.md) — these variants are backed by the FL Customer Functional Location top-card screenshot referenced on line 92 of that file.
- [x] Subagent: DECISION — **keep**; documented as FL-specific in variant catalog.
- [x] Subagent: apply decision; update variant catalog (added "Variant scope & usage" table)
- [x] Subagent: commit
- [ ] Orchestrator: review
- [ ] Merge

---

## Phase B — Row-family extraction  `[x]`
Extract `<x-enterprise.label>`; expose `columns` prop on `date-row` and `textarea-row`.

- **Branch:** `refactor/enterprise-row-family` (pushed, commit `55e7497`)
- **Result:** new `label.blade.php` (props: `for`, `labelClass`); `field-row`, `control-row`, `date-row`, `textarea-row` delegate to it; `columns` prop added to `date-row` and `textarea-row`. Lookup-row already delegated to field-row (no change). Checkbox intentionally unchanged (different markup role).

- [x] Create label component
- [x] Refactor six components to use label (4 actually needed changes; 2 were no-ops)
- [x] Add `columns` prop to date-row and textarea-row
- [x] Backward-compat verified: all 453 `field-row` callers produce byte-identical HTML
- [x] Minor flag: `textarea-row` outer `<div>` class token *order* differs (cosmetic only, same CSS)
- [x] Commit + push
- [x] Orchestrator reviewed diff — clean
- [ ] Merge to master (awaiting user) — PR URL: https://github.com/hazthedev/atp3.0/pull/new/refactor/enterprise-row-family

---

## Phase A — Livewire adoption campaign (per L1)  `[ ]`
Replace raw `<input>`/`<select>`/`<textarea>` with `<x-enterprise.*>` in Livewire views. ~131 instances.

**Scope convention** (per [CLAUDE.md](../CLAUDE.md)): one L1 per PR. Each L1 gets its own branch + line in this tracker.

### A1 — Administration  `[~]` (pilot)
Branch: `refactor/adoption-administration`
- [x] Subagent: enumerate raw-input sites under `resources/views/livewire/admin/`, `system/`, and the reference-data managers (`counter-ref-manager`, `measure-units-manager`, `user-groups-page`)
- [x] Subagent: replace with enterprise components (preserve pencil-modal edit pattern) — 16 checkbox sites migrated to `<x-enterprise.checkbox inline>`
- [x] Subagent: visual check — User Management, User Groups, Authorizations, Category Parts, Item Groups, Warehouses
- [x] Subagent: commit
- [ ] Orchestrator: review
- [ ] Merge
- [ ] Update [docs/modules/administration.md](modules/administration.md)

#### A1 follow-up log (deferred sites)

Each entry names the file, line(s), the reason the site was left as raw HTML,
and what we would need in the catalog / components before it can migrate
cleanly. Any A2–A4 implementer hitting a similar case should reference or
extend this list.

**Table-cell inline-edit grids (no component fit).** The `<x-enterprise.input>`
component emits a bordered, padded `.input-field` box that is fine in a
form-row context but wrong inside a tight table cell (which wants
`border-0 bg-transparent` so only the row grid lines show). Rows sit at
`text-xs`, forms at `text-sm`. Proposed fix: add a `variant="cell"` (or a new
`<x-enterprise.cell-input>`) that renders borderless/transparent and sized
for a `<td>`.

- `resources/views/livewire/admin/counter-ref-manager.blade.php:55-119` —
  17 inline inputs/selects across Code / Name / Status / Measure Unit /
  Incr-Decr / Allow Incr-Decr / Min Value / Max Value / Initial Value /
  Propagation flag / Used 4 Residual / Allow auto-incr / Orange light Limit /
  Sort order / Log instance / Linked counter / Propagation on linked
  counter. Uses a per-file `$inputClass` string.
- `resources/views/livewire/admin/measure-unit-manager.blade.php:38-59` —
  3 inline inputs (Code / New Code / Designation).
- `resources/views/livewire/admin/mro-status-object-manager.blade.php:42-51` —
  3 inline inputs + 1 inline checkbox (Code / Name / Description / Locked).

**Bare filter select above a list.** `<x-form.select>` is a label + field
combo that doesn't compose when the label is already rendered above, and
`<x-enterprise.input>` has no select variant. A bare `<x-enterprise.select>`
would unblock these.

- `resources/views/livewire/admin/user-groups-page.blade.php:16` — Group
  Type filter (`<select class="input-field">`).

**Account Code grid cells (table-cell select).** Same as the inline-edit
grids. Would migrate to the same hypothetical `<x-enterprise.select variant="cell">`.

- `resources/views/livewire/admin/stock/item-group-form.blade.php:131` —
  Accounting tab, 21 rows.
- `resources/views/livewire/admin/stock/warehouse-form.blade.php:175` —
  Accounting tab, 21 rows.

**Textarea without the label-column layout.** `<x-enterprise.textarea-row>`
bakes in a 112px-label column that doesn't match the current `space-y-1.5`
stacked-label layout used on the User Groups detail. Migrating would
visually regress.

- `resources/views/livewire/admin/user-groups-page.blade.php:80` —
  Description textarea. Proposed fix: bare `<x-enterprise.textarea>`
  parallel to how `<x-enterprise.input>` is bare (no built-in label column).

**Checkboxes with non-default tone / weight.** The `<x-enterprise.checkbox>`
component hard-codes `text-sm text-gray-600` on its label. Three clusters
need a different tone and are left as raw HTML:

- `resources/views/livewire/system/user-form.blade.php:29,33,37` — header
  flags (Superuser, Mobile User, Group). Use `text-sm font-medium text-gray-700`
  to read as page-header metadata.
- `resources/views/livewire/admin/stock/warehouse-form.blade.php:79` —
  Drop-Ship. Uses `text-sm text-gray-400` because the checkbox is
  permanently disabled (SAP accounting-package gated). Also carries
  `data-edit-locked="true"` so the Edit Record toggle won't flip it.

Proposed fix: a `labelClass` prop (or named `label` slot) on
`<x-enterprise.checkbox>`.

**Table-cell checkbox without a label.**

- `resources/views/livewire/admin/stock/item-group-form.blade.php:97` —
  Enforce Default Bin Location inside a `<td>`. The existing component
  always emits a label wrapper + span; here the column header IS the label
  and the cell should contain a bare checkbox.

Proposed fix: allow `<x-enterprise.checkbox>` to render unlabeled when the
`label` prop is omitted, OR add a bare `<x-enterprise.cell-checkbox>`.

### A2 — Fleet Management  `[ ]`
Branch: `refactor/adoption-fleet-management`
- [ ] Subagent: enumerate raw-input sites in `resources/views/livewire/fleet/` and `resources/views/livewire/maintenance/`
- [ ] Subagent: replace — **preserve** Edit Record toggle (`[data-edit-scope]`), arrow-chevron semantics on list tables
- [ ] Subagent: special attention to `change-equipment-customer-information-page.blade.php` (inline grid hack) and `maintenance-plan-administration-page.blade.php` (raw `<select>` filters)
- [ ] Subagent: visual check — FL search/show, Equipment detail, Maintenance Plan admin
- [ ] Subagent: commit
- [ ] Orchestrator: review
- [ ] Merge
- [ ] Update [docs/modules/fleet-management.md](modules/fleet-management.md)

### A3 — Inventory  `[ ]`
Branch: `refactor/adoption-inventory`
- [ ] Subagent: enumerate raw-input sites in `resources/views/livewire/system/` that belong to Item/Counter management
- [ ] Subagent: replace; preserve counter-template modal pattern
- [ ] Subagent: visual check — Item Master Data, Counter Refs
- [ ] Subagent: commit, review, merge
- [ ] Update [docs/modules/inventory.md](modules/inventory.md)

### A4 — MRO Management  `[ ]`
Branch: `refactor/adoption-mro`
- [ ] Subagent: enumerate raw-input sites under MRO work-order detail views
- [ ] Subagent: replace; preserve 7-tab structure
- [ ] Subagent: visual check — Work Order detail
- [ ] Subagent: commit, review, merge
- [ ] Update [docs/modules/mro-management.md](modules/mro-management.md)

### A5 — Technical Data / Flight Recording / Reports / HR / BP / Dashboard  `[ ]`
Mostly stubbed. Run a single audit sweep across all six to confirm no raw-input migration is needed.
- [ ] Subagent: audit sweep under `technical-data/`, `flight-recording/`, `reports/`, `hr/`, `business-partners/`, `dashboard/` livewire views
- [ ] Subagent: if findings, open a follow-up PR per L1; if none, mark this line complete

---

## Completion
- [ ] All phases merged
- [ ] [docs/ui-variants.md](ui-variants.md) fully reflects the new API
- [ ] Per-L1 module docs updated where Phase A landed
- [ ] This tracker archived (rename to `docs/archive/refactor-enterprise-components-2026-04.md`)
