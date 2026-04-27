# Administration — module state

Second L1 in `config/navigation.php`. Houses system-wide reference data
setup, user lifecycle, and utilities that cross-cut several domains.

## Scope

### L2 entries under Administration

| L2 | Purpose |
|---|---|
| User Management | Users, User Groups, User Authorizations |
| Stock Management | Item Groups, Category Part, Warehouses |
| Fleet Management | Technical Publication Type, Status Management & Workflow, Task Type, Counters, Penalties |
| Flight Operations | Departure / Arrival Locations |
| MRO Management | Work Order Type, Defect Type, Status Management & Workflow |
| Utilities | Counter Synchronization, Max Value Bulk Update, FL Counters Bulk Update, Customer Equipment Card Status Bulk Update, Change Customer Information, Equipment Reference Evolution |
| Settings | Single page |

### DB tables owned by Administration

- `users` (extended with SAP-profile columns)
- `user_groups` + `user_group_user` pivot
- `permissions` (self-referencing tree, 44 seeded nodes)
- `authorizations` (polymorphic pivot keyed on subject_type `user` | `user_group`)
- `item_groups`
- `warehouses`
- `item_group_warehouse_defaults` pivot (default bin location per warehouse per item group)
- `gl_accounts` (placeholder chart of accounts; to be replaced when Finance module lands)
- `gl_account_assignments` (polymorphic; `assignable_type` = `App\Models\ItemGroup` | `App\Models\Warehouse`, keyed by `account_type_key`)
- `category_parts` (shared with MRO — extended with `new_code` column by `2026_04_26_010000_add_new_code_to_category_parts.php`)

### Livewire components owned here

- `App\Livewire\System\UserIndexPage`
- `App\Livewire\System\UserForm` (3-tab SAP Users – Setup form)
- `App\Livewire\Admin\UserGroupsPage` (master-detail)
- `App\Livewire\Admin\AuthorizationsPage` (tabs + permission tree + level actions)
- `App\Livewire\Admin\Stock\ItemGroupIndexPage`
- `App\Livewire\Admin\Stock\ItemGroupForm` (2-tab SAP Item Groups – Setup form)
- `App\Livewire\Admin\Stock\WarehouseIndexPage`
- `App\Livewire\Admin\Stock\WarehouseForm` (2-tab SAP Warehouses – Setup form)
- `App\Livewire\Admin\Stock\CategoryPartsPage` (inline-editable grid — Code / New Code / Name)

### Models owned here

- `App\Models\User` (extended)
- `App\Models\UserGroup`
- `App\Models\Permission`
- `App\Models\Authorization`
- `App\Models\ItemGroup`
- `App\Models\Warehouse`
- `App\Models\GlAccount`
- `App\Models\GlAccountAssignment` (polymorphic; 21 fixed account slots in `ACCOUNT_TYPES`)

## Current state

### Shipped

- **User list** (`/system/user-management`)
  - Shared `<x-data-table ... datatable>` pattern matching the FL search page
  - Client-side search / sort / pagination via simple-datatables
  - First column is a plain linked User Code (no arrow chevron per the list convention)
  - Status pills (Active / Locked / Superuser)

- **User detail / edit** (`/system/user-management/{id}/edit`)
  - 3-tab SAP-style layout: **General / Services / Display**
  - Header row with Superuser / Mobile User / Group flags and User Code (required, red asterisk) / User Name / Defaults
  - Edit Record toggle pattern (read-only until Edit Record clicked)
  - **Variants applied per catalog** (PR #51):
    - Employee → `variant="lookup"`
    - Password → `variant="lookup"` + `type="password"`
    - Groups → `variant="lookup"` with custom `lookupAction` slot opening a modal picker (single-group SAP-literal; additional memberships via the User Groups page)
    - Branch / Department → `<x-form.select>` with seeded option lists
  - Services tab: 9 session checkboxes + 3 config fields + 3 keyboard checkboxes
  - Display tab: 8 dropdowns + font preview
  - Save persists via Livewire; `user->groups()->sync([selectedGroupId])` on save

- **User Groups page** (`/admin/user-management/user-groups`)
  - Split layout: group-type filter + numbered group list on the left, detail card + members table on the right
  - Edit Record toggle on the detail card
  - Live member-picker below the members table (search user code / name, click to add)
  - Variants per catalog (PR #52): all plain inputs, no decorations

- **Authorizations page** (`/admin/user-management/user-authorizations`)
  - Left rail tabs: Users / Groups
  - Subject tree (44 nodes mirroring sidebar), colored level badges
  - Action bar: Full Authorization / Read Only / No Authorization — cascades to descendants
  - Variants per catalog (PR #52): plain filter input

- **Item Groups** (`/admin/stock-management/item-groups`)
  - Index (list) + detail (2 tabs: General / Accounting)
  - Edit Record toggle on the detail page
  - General tab: Item Group Name (required), Default UoM Group (plain; UoM Group picker will wire up when UoM Groups ship), Lead Time (days), Default Valuation Method dropdown (FIFO / Moving Average / Standard), Default Bin Locations grid — one row per seeded warehouse with inline Default Bin Location input and Enforce checkbox
  - Accounting tab: 21 fixed account-type rows from `GlAccountAssignment::ACCOUNT_TYPES`, Account Code dropdown resolved from `gl_accounts`, Account Name auto-filled from the selected row
  - Seeded with 4 example groups (`ItemGroupSeeder`)

- **Warehouses** (`/admin/stock-management/warehouses`)
  - Index + detail (2 tabs: General / Accounting), Edit Record toggle
  - General tab: Warehouse Code (required) + Warehouse Name (required) in header; Inactive / Drop-Ship (disabled, per SAP) / Nettable / Issue part for maintenance checkboxes; Location dropdown (Subang / Dili / Namibia / Kuching / Miri); full address block (Street/PO Box through Address Name 3) with Country as `variant="lookup"`; Enable Bin Locations checkbox; "Show Location in Web Browser" link (stub)
  - Accounting tab: same 21-row grid as Item Groups via the shared `GlAccountAssignment` polymorphic table
  - Seeded with 6 example warehouses matching the screenshot's bin-location grid (`WarehouseSeeder`)

- **Category Parts** (`/admin/stock-management/category-part`)
  - Full-page inline-editable grid matching the SAP Category Part List window
  - Columns: # / Code / New Code / Name with per-row pencil + remove actions
  - Add row / OK / Cancel bottom action bar; Save button toggles to "Update" when the grid is dirty
  - Follows the `MeasureUnitManager` row-ops pattern but rendered as a standalone page (it owns its own route, so no modal wrapper)
  - Migration `2026_04_26_010000_add_new_code_to_category_parts.php` adds `new_code` (nullable) to the existing `category_parts` table (16 rows already seeded via `CategoryPartSeeder`)

### Stubbed (route exists, view is `pages.stub`)

- Fleet Management → Technical Publication Type, Status Management & Workflow, Task Type, Penalties (Counters points at the existing `/system/counter` reference page)
- Flight Operations → Departure / Arrival Locations
- MRO Management → Work Order Type, Defect Type, Status Management & Workflow
- Utilities → Counter Synchronization, Max Value Bulk Update, FL Counters Bulk Update, CEC Status Bulk Update, Change Customer Information, Equipment Reference Evolution

### Not started (sidebar entry needs a concrete spec)

None — every L3 has at least a stub route.

## SAP / Weststar reference

Screenshots received so far (from earlier chat turns — not committed to the repo yet; descriptions only in `docs/ui-variants.md`):

- **Users – Setup** (3 tabs: General / Services / Display) — fully mapped, catalog updated.
- **User Groups** (master-detail with Group Type filter) — fully mapped.
- **Authorizations** (Users/Groups tabs + subject tree + level actions) — mapped; several features flagged as missing (see Gaps below).

### Shipped in the current sprint (PR open)

- Item Groups + Warehouses pages (see above).
- `GlAccount` / `GlAccountAssignment` polymorphic mini–chart-of-accounts, seeded with 25 placeholder rows; intended to be swapped out when a real Finance module lands.

## Design decisions

- **Groups field is single-picker** (SAP-literal) on the User form; multi-group memberships must be added via the User Groups page members table. Chose this over the earlier multi-select chip UI (user picked "A" initially, then reversed when the "layout exactly like images" rule was applied).
- **`subject_type` morph alias** — `'user'` / `'user_group'`, registered in `AppServiceProvider::boot()` via non-enforcing morph map.
- **Permission tree** — ATP-specific subject catalog (44 nodes mirroring our sidebar), NOT SAP B1's generic subject categories (Financials, MRP, etc.). Reviewed as the correct call for an aviation-MRO app.
- **Password storage** — simple Hash::make on `password_input`; SAP's `...` picker button is a stub (opens nothing yet). Future work: a set-password modal.
- **Authorization default** — when no row exists for a (subject, permission) pair, the UI shows "No Authorization". No inherit-from-group computation yet.
- **Employee field** — free string with `variant="lookup"`; will become a real Employee picker when the Human Resources module ships.
- **Shared Accounting tab** — both Item Groups and Warehouses use the same polymorphic `gl_account_assignments` table plus the fixed `GlAccountAssignment::ACCOUNT_TYPES` catalog of 21 account slots. Keeps the two forms in sync and avoids duplicating the row list.
- **GL accounts are placeholder** — `gl_accounts` is seeded with 25 rows covering the account types referenced on the Accounting tabs. When a real Finance/GL module ships, the Account Code dropdown should swap to its canonical source; assignments carry only an FK, so the migration is cheap.
- **UoM Group on Item Groups** — rendered as a plain text input (no visible decoration in the SAP screenshot). When a real UoM Groups table ships, switch to `variant="lookup"` with a picker modal.
- **Location on Warehouses** — dropdown with a 5-entry hard-coded enum (Subang / Dili / Namibia / Kuching / Miri), derived from the Weststar warehouse seed set. Promote to a real `locations` table if the operations team needs CRUD over it.
- **Drop-Ship checkbox** — rendered disabled per the SAP screenshot (the toggle is SAP-B1 accounting-package gated). Bound to `drop_ship` but not editable through this UI.
- **Category Part grid** — promoted from read-only to inline-editable per SAP screenshot. Uses the `MeasureUnitManager` pencil-edit row pattern but as a standalone page (owns its own L3 route, so the modal wrapper is unnecessary). `work_scope` remains on the model as an ATP-specific flag but is not exposed in the UI; the SAP screen only has Code / New Code / Name.

## Cross-L1 touchpoints

- **Users → Business Partners**: none yet. Eventually the Employee field may link to an employee record in HR; business-partner linkage isn't needed.
- **Permissions tree ↔ all L1s**: the permissions catalog references every L1 by code. When new L1s ship, `PermissionSeeder` needs new entries. Update both this file AND the target L1's module file.
- **Authorizations enforcement → middleware**: enforcement is NOT implemented. When middleware is added, route groups across all L1s will read from `authorizations` table. Flag this as a repo-wide cross-L1 change.
- **Admin > Utilities → Fleet Management / CRM**: Change Customer Information and Equipment Reference Evolution routes live under Admin but touch Fleet Management and CRM data. When built, note the cross-L1 dependency.

## Outstanding (next-sprint candidates)

In rough priority order, discuss with user before starting:

1. **Stock Management CRUD** — Item Groups (simple list), Category Part (enum), Warehouses. Reference-data tables, likely pencil-launched modal pattern.
2. **Admin > Fleet Management reference types** — Technical Publication Type, Status Management & Workflow, Task Type, Penalties. Seed data + CRUD.
3. **Admin > MRO Management reference types** — Work Order Type, Defect Type, Status Management & Workflow.
4. **Utilities** — bulk update forms. Highest value: FL Counters Bulk Update and CEC Status Bulk Update. These are wizard-style flows, bigger scope than reference-data CRUD.
5. **Auth middleware** — enforce `authorizations` table on route access. Cross-L1 change; should land after at least one L1 has a real consumer.
6. **User form "set password" modal** — wire up the lookup picker on the Password field to a dedicated set-password dialog.

### Known UI feature-completeness gaps (flagged, not fixed)

From the variant catalog pass on User Groups and Authorizations:

**User Groups**
- Inline-editable members grid (SAP pattern). Current UI uses a separate search-and-add picker.
- "Create Group" button sits in the header; SAP has it next to the OK/Cancel bar.

**Authorizations**
- Find text input above the permission tree.
- Max. Discount Sales / Purchase / General numeric inputs.
- Max. Cash Amount for Incoming Payments checkbox.
- Copy Authorizations button (bottom-left).
- Global Expand / Collapse buttons.
- OK / Cancel bottom action bar.

## Last updated

- 2026-04-24 — branch `claude/admin-module-setup-6F0Zk` — Stock Management → Item Groups and Warehouses setup pages shipped (index + 2-tab detail with Edit Record toggle), `GlAccount` + polymorphic `GlAccountAssignment` tables added, seeders + placeholder chart of accounts. Category Part still read-only pending Fadzly's spec.
- 2026-04-25 — session f3681b7 / PR #52 — variant catalog passed over all three User Management pages; module file created.
- 2026-04-24 — branch `refactor/adoption-administration` (Phase A1 pilot of the enterprise-components adoption campaign) — migrated 16 raw checkbox sites to `<x-enterprise.checkbox inline>` in `user-form.blade.php` (13) and `warehouse-form.blade.php` (3, Inactive / Nettable / Issue part / Enable Bin Locations — Drop-Ship left as raw because it uses `text-gray-400` tone). Deferred sites logged for A1-redux below.
- 2026-04-24 — PR #61 `refactor/adoption-administration-redux` — completed the A1 deferred sites: 33 migrations across 7 files (counter-ref-manager, measure-unit-manager, mro-status-object-manager, item-group-form, warehouse-form, user-groups-page, user-form). Used the new `<x-enterprise.input variant="cell">`, bare `<x-enterprise.select>`, bare `<x-enterprise.textarea>`, and `labelClass` / nullable-label modes on `<x-enterprise.checkbox>` (added in PR #59 Phase F catalog gap-fill). Drop-Ship migrated with `labelClass="text-sm text-gray-400"`; data-edit-locked preserved. All `wire:model` bindings + edit-mode toggle scopes intact.
