# Human Resources — module state

Fifth L1. Employee records and HR master data.

## Scope

### L2 entries

| L2 | Purpose |
|---|---|
| Employee Master Data | Employee list + 8-tab detail card |

### DB tables owned here

- `employees` — wide flat header (~75 columns) covering name, employment, contact, work address, home address, administration, personal, finance, flight ops home base, remarks
- `employee_roles` — Membership tab → Roles
- `employee_teams` — Membership tab → Teams
- `employee_crew_positions` — Flight Ops → Crew Management positions list
- `employee_assignments` — Flight Ops → Employee Assignment
- `employee_attachments` — Attachments tab

### Livewire components owned here

- `App\Livewire\Hr\EmployeeIndexPage` — list view
- `App\Livewire\Hr\EmployeeMasterDataForm` — full detail form (Edit Record toggle, mount/save/cancel pattern matching FL show form and Equipment Card)

### Models owned here

- `App\Models\Employee` (with `manager` self-reference + `reports`, `roles`, `teams`, `crewPositions`, `assignments`, `attachments` relationships)
- `App\Models\EmployeeRole`
- `App\Models\EmployeeTeam`
- `App\Models\EmployeeCrewPosition`
- `App\Models\EmployeeAssignment`
- `App\Models\EmployeeAttachment`

## Current state

### Shipped

- **Employee list** (`/hr/employee-master-data`) — `<x-data-table>` with chevron-linked Employee No., Name, Position, Department, Status pills.
- **Employee detail / edit** (`/hr/employee-master-data/{id}/edit`) — full SAP Employee Master Data shell:
  - Header card: First/Middle/Last Name, Employee No., Ext. Employee No., Active flag, Job Title, Position, Department, Branch, Manager, User Code, Sales Employee, Cost Center, Office Phone + Ext, Mobile Phone, Pager, Home Phone, Fax, E-Mail, Linked Vendor (`variant="lookup"`), photo placeholder
  - 8 tabs: Address (Work + Home), Membership, Administration, Personal, Finance, Flight Ops, Remarks, Attachments
  - Edit Record toggle: read-only by default, fields unlock on Edit Record click; Save / Cancel dispatch save-edit-form / cancel-edit-form events
  - Status / Gender / Marital Status / Period dropdowns driven by static option arrays on the component
- **EmployeeSeeder** — 2 sample employees (`WS-001` / `WS-002`)
- 6 feature tests covering mount / save / cancel / null-coercion / full-name concatenation

### Stubbed / pending follow-up PRs

- **Membership tab** — Roles + Teams row management. Tables exist but no editor UI yet; tab renders an empty-state placeholder.
- **Flight Ops Crew Management positions list** + **Employee Assignment list** — same status: tables exist, editor UI deferred.
- **Attachments tab** — table exists; Browse / Display / Delete UI deferred.
- **Photo upload** — placeholder div in the header. Upload + storage to be wired when the file-upload pattern is decided across the app.
- **Reference data** — Position, Department, Branch, Manager, User Code, Sales Employee, Cost Center, Bank, Country fields are free strings. Will become dropdown-driven once their reference tables ship.
- **Required-field affordance** — SAP shows red bold labels + yellow background for required fields (First Name, Last Name, Employee No., Ext. Employee No., Cost Center, Start Date, Status, Termination Date, Termination Reason, all Address fields, Mission Type, Maint. Center Code, Maint. Center Name, etc.). Catalog gap shared with Equipment Card; tracked under `feature/required-field-affordance`.

### Not started

- HR-specific reports
- Bulk operations (mass status change, bulk seniority update, etc.)
- Termination workflow
- Qualification / Medical Visits / Education / Reviews modules referenced by Administration tab buttons (rendered disabled)

## SAP / Weststar reference

Screenshots received and mapped (`/hr/employee-master-data` shell):
- Employee Master Data top form — header layout + Find/Cancel footer
- Address tab — Work + Home blocks, 9 fields each, all red labels (required)
- Membership tab — Roles + Teams tables side-by-side, Set Role as Default button
- Administration tab — Start Date / Status / Termination Date / Termination Reason + 5 right-side action buttons + Reference 1 / Reference 2 with From/To + Remarks + Work Profile + Qualification / Medical Visits buttons
- Personal tab — Gender / Date of Birth / Country of Birth / Marital Status / No. of Children / ID No. + Citizenship / Passport No. / Passport Expiration Date / Passport Issue Date / Passport Issuer
- Finance tab — Salary [Month] / Employee Costs [Month] + Bank Details (Bank / Account No. / Branch)
- Flight Ops tab — Crew Management sub-tab (Home base + Positions list + Synthesis); Employee Assignment sub-tab (textarea-style list + New / Remove)
- Remarks tab — single yellow textarea
- Attachments tab — Target Path / File Name / Attachment Date table + Browse / Display / Delete

## Design decisions

- **One Livewire component per page**, header + all 8 tabs in one component (matches Customer Equipment Card scope). Child-table tabs (Membership / Crew Positions / Assignments / Attachments) deferred to follow-up components rather than splitting the form prematurely.
- **Address fields inline on `employees`** with `work_*` / `home_*` prefixes — same pattern Warehouse uses for its inline address columns. Avoids a polymorphic addresses abstraction at this stage.
- **Manager self-reference unconstrained** — `manager_id` is a nullable `unsignedBigInteger` without an FK constraint to keep the create migration self-contained. Constraint can be added in a follow-up migration if/when the cycle becomes a problem.

## Cross-L1 touchpoints

- **Administration > User Management** — `User.employee` field is a free string today; will become FK to Employee when the Employee picker ships.
- **Business Partners** — `Employee.linked_vendor` is a free string with `variant="lookup"`; becomes FK to BPs once the BP table lands.
- **Fleet Management** — `Employee.home_base` is a free string with `variant="lookup"`; becomes FK to FunctionalLocation when an FL picker ships.

## Outstanding (next-sprint candidates)

In rough priority order:

1. **Membership tab** — Roles + Teams row editor (pencil-launched modal pattern)
2. **Required-field affordance** — cross-cutting; unblocks SAP red-label rendering across HR + Equipment Card + others
3. **Photo upload** — header card photo placeholder needs a file-upload mechanism
4. **Reference data tables** — Position, Department, Branch, Cost Center, Bank, Marital Status (etc.) promote to lookup tables

## Last updated

- 2026-04-25 — placeholder created.
- 2026-04-27 — Employee Master Data foundation (PR opening this version): 6 tables migration, 6 models, EmployeeIndexPage + EmployeeMasterDataForm Livewire components, 8-tab shell, EmployeeSeeder, 6 feature tests. Child-table tabs render empty-state placeholders pending follow-up PRs.
