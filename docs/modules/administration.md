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

### Livewire components owned here

- `App\Livewire\System\UserIndexPage`
- `App\Livewire\System\UserForm` (3-tab SAP Users – Setup form)
- `App\Livewire\Admin\UserGroupsPage` (master-detail)
- `App\Livewire\Admin\AuthorizationsPage` (tabs + permission tree + level actions)

### Models owned here

- `App\Models\User` (extended)
- `App\Models\UserGroup`
- `App\Models\Permission`
- `App\Models\Authorization`

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

### Stubbed (route exists, view is `pages.stub`)

Everything else under Administration:

- Stock Management → Item Groups, Category Part, Warehouses
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

## Design decisions

- **Groups field is single-picker** (SAP-literal) on the User form; multi-group memberships must be added via the User Groups page members table. Chose this over the earlier multi-select chip UI (user picked "A" initially, then reversed when the "layout exactly like images" rule was applied).
- **`subject_type` morph alias** — `'user'` / `'user_group'`, registered in `AppServiceProvider::boot()` via non-enforcing morph map.
- **Permission tree** — ATP-specific subject catalog (44 nodes mirroring our sidebar), NOT SAP B1's generic subject categories (Financials, MRP, etc.). Reviewed as the correct call for an aviation-MRO app.
- **Password storage** — simple Hash::make on `password_input`; SAP's `...` picker button is a stub (opens nothing yet). Future work: a set-password modal.
- **Authorization default** — when no row exists for a (subject, permission) pair, the UI shows "No Authorization". No inherit-from-group computation yet.
- **Employee field** — free string with `variant="lookup"`; will become a real Employee picker when the Human Resources module ships.

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

- 2026-04-25 — session f3681b7 / PR #52 — variant catalog passed over all three User Management pages; module file created.
