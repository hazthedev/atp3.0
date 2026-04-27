# Customer Equipment Card Restructure — Design

**Date:** 2026-04-27
**Module:** Fleet Management (L1 #7) → Customer Equipment Card
**Related:** Same playbook as the FL trim (PR #90 / spec `2026-04-27-fl-page-restructure-trim-design.md`). View-layer + Livewire bindings only; no DB schema change.

## Goal

Apply a user-authored kill list to the customer equipment card detail page (`resources/views/pages/partials/customer-equipment-card-page.blade.php`) and add a new **Maintenance** tab modeled on two SAP modal screenshots provided in the brief. The Maintenance tab ships with mock data only — real wiring depends on Maintenance Plan Administration which is still stubbed.

## Out of scope

- DB schema changes. No migration. `equipments.owner_code`, `equipments.operator_code`, `equipments.mel` columns stay (sweep showed 31 / 31 / 14 file references respectively, including `ChangeEquipmentCustomerInformationPage` as the canonical mutator and a future BP-FK migration target).
- Real wiring of the Maintenance tab to a `task_lists` / `task_list_history` schema — those tables don't exist yet.
- Any feature work on the surviving tabs (Counters wiring, Bill of Material persistence, Modifications mutators, etc.).

## Kill list — exact targets

| # | Location | Target |
|---|---|---|
| 1 | Top form (`$summaryRightFields` + `EquipmentShowForm.php` Livewire bindings) | `owner_code`, `operator_code`, `mel` rows |
| 2 | Top form actions (lines 326 / 329 of the partial) | `Change References` button (both enabled and disabled variants) |
| 3 | Counters tab — top table "Standard Counters" (~line 597) | `Residual` + `Equi. ID` columns (header + cells) |
| 4 | Counters tab — bottom table "Calendar Counters" (~line 651) | `Residual` + `Equi. ID` columns (header + cells) |
| 5 | Events tab | Drop `repairs` from `$eventTabs` + delete the `x-show="activeTab === 'repairs'"` panel (~line 805) |
| 6 | Events tab | Drop `others` from `$eventTabs` + delete the `x-show="activeTab === 'others'"` panel (~line 883) |
| 7 | Properties → Properties1 (`$propertiesTopLeftFields` + `$propertiesOperationalFields` + `$propertiesTopRightFields`) | 9 field rows: `manufacturer_item_code`, `configuration_standard`, `mission_type`, `external_key`, `environment_type`, `contract_type`, `oil_type`, `purchase_cost_of_engine`, `remark_text` |
| 8 | Properties → Properties1 (~line 1089) | `Installed Base Data Anomaly` section |
| 9 | Properties tab structure | Delete Properties2 panel (~line 1135) **and** collapse the Properties1/Properties2 subtab nav. Properties tab folds back to a single un-tabbed pane (matches FL Properties pattern). |
| 10 | Main `$tabs` + matching panel (~line 1142) | Delete `address` tab entry + panel |
| 11 | Main `$tabs` + matching panel (~line 1198) | Delete `trans` tab entry + panel |
| 12 | Main `$tabs` + matching panel (~line 1234) | Delete `remark` tab entry + panel |

## Ancillary cleanup (matching FL trim housekeeping)

- Strip orphan keys from `$selectedRecord` defaults at the top of the partial: `owner_code`, `operator_code`, `mel`, plus the 9 Properties1 mock keys (`manufacturer_item_code`, `configuration_standard`, `mission_type`, `external_key`, `environment_type`, `contract_type`, `oil_type`, `purchase_cost_of_engine`, `remark_text`), plus the 8 Address keys (`address_name`, `street`, `block`, `city`, `zip_code`, `county`, `state`, `country`), plus the 4 Anomaly keys (`anomaly_on_data`, `lock_flag`, `updated_by`, `update_date`).
- Delete now-orphan PHP arrays: `$addressFields`, `$propertiesTabs`, `$propertiesTopRightFields`.
- `EquipmentShowForm.php`: drop `owner_code`, `operator_code`, `mel` properties + their `loadFromDb()` assignments + their entries in the `update()` payload.
- `equipment-show-form.blade.php`: drop the matching three input rows.

## Livewire / behavioural notes

The user asked to delete Owner Code / Operator Code / MEL from the **top form**, which is rendered by the `EquipmentShowForm` Livewire blade. We strip the bindings entirely (rather than hide the inputs and keep silent no-op writes) — the user signalled deletion, not hide.

`ChangeEquipmentCustomerInformationPage` already owns the canonical write path for `owner_code` / `operator_code`, so removing them here just collapses a duplicate entry point. `mel` is also writable from `AttachEquipmentPage` during the equipment-attach flow — that path is untouched. DB columns themselves stay; future BP FK work is unaffected.

## New Maintenance tab — full structure

**Position:** Tab #7 in the main `$tabs` list (last position, after Properties).

**Tab order after deletions and addition:**
1. General
2. Bill of Material
3. Counters
4. Modif.
5. Events
6. Properties
7. **Maintenance** ← new

**Subtab pattern:** Mirror the existing `$eventTabs` / `$propertiesTabs` Alpine pattern. Add `$maintenanceTabs = [['id' => 'task-list-sub-equipment', 'label' => 'Task List on sub equipment'], ['id' => 'task-list-history', 'label' => 'Task List History of equipment']]`.

### Subtab 1 — Task List on sub equipment

**Top panel: "Maintenance Plan Applied To"** card (4 enterprise inputs in a two-column grid):
- Functional Location — `<x-enterprise.input variant="arrow-lookup">`, value `9M-WAA`
- Serial Number — plain `<x-enterprise.input>`, value `31324`
- FL Type — `<x-enterprise.input variant="arrow-lookup">`, value `AW139`
- Registration — plain `<x-enterprise.input>`, value `M104-04`

The equipment identity panel from the SAP screenshot is **not** repeated — the parent customer-equipment-card already shows that data above the tabs.

**Filter:** A single `<x-form.select>` labelled "Filter on Maintenance Plan" with three mock plan options matching what's already in the codebase: `AW139 AMP ISS 7 REV 4 / GOCOM` (the canonical default), `AW139 AMP ISS 6 REV 8 / GOCOM`, `EC225 AMP ISS 4 REV 2 / GOCOM`. Decorative; no backing logic. Matches codebase precedent for unwired controls (e.g. Counter Reading / Counter Hierarchy buttons elsewhere on this page).

**Three stacked tables**, each preceded by an `<h4>` section title:

- **Linked Task Lists** — 8 columns: `Reference` (arrow), `Short Description`, `Mod. Ref.` (arrow), `Status`, `On Condition` (checkbox), `Condition Monitoring` (checkbox), `Initialized` (checkbox), `Comment`. Mock 5 rows from screenshot 1.
- **Standard Counters** — 16 columns: `!` (status dot), `Description`, `Reading Date`, `Obj. Value`, `Next Appli.`, `Interval`, `Remaining`, `Last Appli.`, `Sub Eq. Reading Date`, `Sub Eq. Value`, `Sub Eq. Next Appli.`, `Sub Eq. Remaining`, `Sub Eq. Last Appli.`, `Interval Ori.`, `Tolerance`, `Alarm`. Mock the single TSN row visible in screenshot 1.
- **Calendar Counters** — 11 columns: `Description`, `Obj Next Appli.`, `Interval`, `Remaining`, `Last Appli.`, `Sub Eq. Next Appli.`, `Sub Eq. Remaining`, `Sub Eq. Last Appli.`, `Interval Ori.`, `Tolerance`, `Alarm`. Plus an inline disabled `<x-enterprise.input>` labelled "Unit of Measure" reading "Days". Mock empty table (matches screenshot).

### Subtab 2 — Task List History of equipment

No top panel. (Screenshot 2 shows the equipment identity panel which we agreed to drop; no FL panel is shown in screenshot 2.)

**Three stacked tables:**

- **Task Lists Applied** — 3 columns: `Reference` (arrow), `Short Description`, `Mod. Ref.` (arrow). Mock 3 rows from screenshot 2.
- **Task List Application History** — 7 columns: `Application Date`, `Work Order` (visual arrow chevron without href, matching the existing pattern in the Events › Work Orders subtab on this same partial — there is no `fleet.work-order.show` route, only the static `work-order.detail` MRO route which doesn't accept an ID), `Repair ID`, `Comment`, `Maintenance Plan`, `Object Code`, `Object Information`. Mock 1 row.
- **Scheduling Information recorded during the application** — 3 columns: `Description`, `Value (dec.)`, `Value (hh:mm)`. Mock 4 rows (`TSN`, `CSN`, `START`, `E#1CC`) with both value columns blank (matches screenshot).

### Maintenance tab behaviour

- Respects the parent `editMode()` toggle the same way every other tab does — `$readonly` flips inputs to `variant="disabled"`. Tables are display-only regardless of edit mode (consistent with existing tables on this page).
- No new Livewire component, no new routes, no new components in `resources/views/components/enterprise/`.
- Empty-state branch: clear all Maintenance mock arrays to `[]` inside the existing `if ($emptyState) { … }` block, consistent with how `$eventWorkpackageRows` etc. behave today.

## File touch list

| File | Change |
|---|---|
| `resources/views/pages/partials/customer-equipment-card-page.blade.php` | All 12 deletions + ancillary mock-array cleanup + new Maintenance tab markup (~180 lines added). Net diff likely close to neutral or modestly negative. |
| `resources/views/livewire/fleet/equipment-show-form.blade.php` | Drop owner_code, operator_code, mel input rows |
| `app/Livewire/Fleet/EquipmentShowForm.php` | Drop 3 properties + 3 loadFromDb assignments + 3 entries in update() payload |
| `tests/Feature/Livewire/Fleet/EquipmentShowFormTest.php` | Drop assertions on owner_code / operator_code / mel (lines 25, 27, 39, 41, 53, 58, 65, 75, 80, 83, 89). Other assertions stay. |
| `docs/modules/fleet-management.md` | Last-updated entry per CLAUDE.md |

No migration. No seeder changes. No new files outside docs.

## Acceptance

- Customer Equipment Card renders with the 12 trimmed targets gone.
- Tab order is exactly: General · Bill of Material · Counters · Modif. · Events · Properties · Maintenance.
- Properties tab no longer has a Properties1/Properties2 sub-tab nav — single un-tabbed pane.
- Edit Record toggle still works on the surviving fields (top card + General-tab + remaining Properties1 fields).
- Saving the top card via Livewire still persists `equipment_no`, `serial_number`, `category_part`, `variant`, `status`, `owner_name`, `operator_name`, `maintenance_plan`. (Owner/Operator **Code** persistence moves exclusively to ChangeEquipmentCustomerInformationPage. MEL persistence moves exclusively to AttachEquipmentPage.)
- Maintenance tab renders both subtabs without console / Alpine / PHP errors.
- `EquipmentShowFormTest` passes after the assertion trim.

## Risks

- **Top-form binding strip** is the only behavioural change. Caught at test level by `EquipmentShowFormTest`; updated assertions in the same PR.
- **Counter table column widths** may reflow oddly if `<th>` widths are hard-pinned. Visual check after delete; adjust existing Tailwind utility classes on the surviving `<th>` elements if needed.
- **Properties tab subtab collapse** removes Alpine state for `properties-1` / `properties-2` `activeTab`. Confirm no other code listens for those values (sweep during impl).
- **Empty-state branch** must be edited in lockstep with the array deletions or PHP will throw on undefined variable when `$emptyState` is true.
- **Mock data fidelity** — the screenshots show specific values. Mock data should track them so the page is recognisably "the SAP view we discussed", not random placeholder content.

## Branch + PR

- Branch: `refactor/equipment-card-trim` (already created off `origin/master`).
- One PR. Auto-merge squash per the user's standing preference for `refactor/*` branches.
- Commit message lead: `refactor(fleet): restructure customer equipment card per 2026-04-27 user kill list`.
- PR body should call out: "applies the same playbook as PR #90 (FL trim) to the customer equipment card; adds a new mock Maintenance tab structured to match two SAP screenshots provided in the brief."
