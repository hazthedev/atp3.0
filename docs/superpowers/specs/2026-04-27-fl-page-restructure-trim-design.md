# FL Page Restructure — Trim Design

**Date:** 2026-04-27
**Module:** Fleet Management (L1 #7) → Functional Location detail page
**Related history:** PR #41 (`feat: trim FL show page per revamped spec`) merged 2026-04-22, reverted in PR #42 the same day. The module file flagged trim as "still pending user direction" — this spec is that direction.

## Goal

Trim the FL detail page (`/fleet/functional-location/{id}`) per a fresh user-authored kill list. The list is **deliberately narrower than PR #41's General-tab trim** (4 fields PR #41 removed are now kept) and **adds new targets** (top-form Owner/Operator Code, Counter table columns, Properties anomaly section, Events sub-tabs).

## Out of scope

- DB schema changes. No migration is written.
- Any feature work on the surviving fields/tabs (counters wiring, persistence on read-only tabs, Counter History button, etc.).
- The Equipment side of `customer-equipment-card-page.blade.php` — that file independently uses `mission_type` / `environment_type` keys for its own Properties tab and is not touched.

## Kill list — exact targets

| # | Location | Target |
|---|---|---|
| 1 | Top identity card (`$summaryFields`) | `owner_code` row, `operator_code` row |
| 2 | General tab (`$generalFields`) | `mission_type` row, `environment_type` row, `oi_type` row |
| 3 | Counters tab — both top table (around line 462) **and** below table (around line 500) | `Residual` column header + cell, `Equi. ID` column header + cell |
| 4 | Properties tab | Entire `Installed Base Data Anomaly` section (header at line 627 plus its body) |
| 5 | Events tab | Remove `repairs` entry from `$eventTabs` and delete the `x-show="activeTab === 'repairs'"` panel (line 697 area) |
| 6 | Events tab | Remove `others` entry from `$eventTabs` and delete the `x-show="activeTab === 'others'"` panel (line 790 area) |

Final Events tab order after trim: **Workpackages, Installed Base, Technical Log, Work Orders.**

## Cleanup performed alongside the deletions

To keep the partial self-consistent (matches PR #41's housekeeping; this is not "extra refactoring"):

- Delete now-orphan keys from the `$selectedRecord` array literal at the top of the partial: `mission_type`, `environment_type`, `oi_type`, `owner_code`, `operator_code`. (All five are used only by the rows we're removing. The DB-side persistence of `owner_code` / `operator_code` is unaffected because the Livewire form is independent of `$selectedRecord` — see "Livewire form changes" below.)
- Delete the now-unused `$eventRepairRows` array.
- Delete the now-unused `$eventOtherRows` array.
- Delete the matching empty-state branches that re-zero those arrays inside `if ($emptyState) { … }`.
- Strip `'mission_type'`, `'environment_type'`, `'oi_type'` keys from `app/Support/FunctionalLocationCatalog.php` defaults (lines 38, 41, 42).

## Livewire form changes

**`app/Livewire/Fleet/FunctionalLocationShowForm.php`:**

The user asked to delete Owner Code / Operator Code from the top form, which is rendered by this Livewire blade. We strip the bindings entirely (rather than hide the inputs and keep silent no-op writes) — the user signalled deletion, not hide. `ChangeCustomerInformationPage` already owns the canonical write path for these columns, so removing them here just collapses a duplicate entry point. The DB columns themselves stay; future BP FK work is unaffected.

Strip:
- `public string $owner_code = '';`
- `public string $operator_code = '';`
- The two matching `loadFromDb()` assignments
- The two matching keys in the `update()` payload
- Any `wire:model` references to those two fields in `resources/views/livewire/fleet/functional-location-show-form.blade.php`

DB columns remain untouched. ChangeCustomerInformationPage continues to write them.

## File touch list

| File | Change |
|---|---|
| `resources/views/pages/partials/functional-location-show-page.blade.php` | All 6 deletions + mock-array housekeeping |
| `resources/views/livewire/fleet/functional-location-show-form.blade.php` | Drop owner_code + operator_code input rows |
| `app/Livewire/Fleet/FunctionalLocationShowForm.php` | Drop properties + load + save payload entries |
| `app/Support/FunctionalLocationCatalog.php` | Strip 3 mock keys from defaults |
| `docs/modules/fleet-management.md` | Last-updated entry noting the trim shipped (per CLAUDE.md "update module file before merging") |

No other files touched. No migration. No seeder changes.

## Acceptance

- FL show page renders with the 6 trimmed targets gone.
- Edit Record toggle still works on the surviving top-card and General-tab fields.
- Saving the top card via Livewire still persists `code`, `serial_no`, `registration`, `type`, `status`, `maintenance_plan`, `owner_name`, `operator_name`, `mel`. (Owner/Operator **Code** persistence moves exclusively to ChangeCustomerInformationPage, which already owns it.)
- Counters tab tables render without the two dropped columns; existing column widths reflow naturally.
- Properties tab shows the user-defined properties panel only.
- Events tab has 4 sub-tabs in order: Workpackages, Installed Base, Technical Log, Work Orders.
- No console / Livewire / PHP errors when navigating between tabs in both edit and read-only modes.

## Risks

- **Owner/Operator Code unbinding** is the only behavioural change. If any test or fixture asserts the FL show form persists those columns, it will break and need updating. Quick sweep before implementation:
  - `tests/Feature/Livewire/Fleet/` — check for `FunctionalLocationShowForm` tests touching owner_code/operator_code.
  - `tests/Fixtures/PenaltyEngineFixtures.php` — already references owner_code; only matters if it goes through the show form, which it shouldn't.
- **Counter table column widths** may reflow oddly if any `<th>` widths are hard-pinned in the partial. Visual check after delete; adjust the existing Tailwind utility classes on the surviving `<th>` elements if needed. Not a hand-roll of a new component — just trimming widths on existing markup.
- **Empty-state branch** must be edited in lockstep with the array deletions or PHP will throw on undefined variable when `$emptyState` is true.

## Branch + PR

- New branch off `master`: `refactor/fl-page-trim`.
- One PR. Auto-merge on green per the user's standing preference for `refactor/*` branches.
- Commit message lead: `refactor(fleet): trim FL show page per 2026-04-27 user kill list`.
- PR body should call out: "supersedes the reverted PR #41; trim is narrower (keeps Maint. Center Code/Name + A/C weights) and adds top-form + counter-column + properties-anomaly targets."
