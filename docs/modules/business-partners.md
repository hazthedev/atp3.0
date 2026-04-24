# Business Partners — module state

Third L1 in `config/navigation.php`. Customer / vendor / operator master
data for the ATP workspace.

## Scope

### L2 entries

| L2 | Purpose |
|---|---|
| Business Partner Master Data | BP list + create/edit form |

### DB tables owned here

None with dedicated schema yet — BP edit form renders mock data from the
partial (`system/business-partner-master-data/partials/form.blade.php`).

### Livewire components owned here

None yet. Pages are plain Blade with inline Alpine state.

## Current state

### Shipped
- List index at `/crm/business-partner` (reference mock data)
- Create / edit pages at `/crm/business-partner/create` and `/{id}/edit`
- System-level BP Master Data routes (`/system/business-partner-master-data`) — parallel set for the Administration vocabulary
- Edit Record toggle works on the edit form

### Stubbed / mocked
The partial has a large default `$defaults` array that populates every field with hard-coded sample values when `$isEdit` is true. No real persistence.

### Not started
- Real `business_partners` table + model
- Save wiring
- Lookup used by Fleet Management's FL Owner Code / Operator Code (currently free string)

## SAP / Weststar reference

No concrete spec received yet. When the first real BP sprint starts, request the SAP B1 "Business Partner Master Data" form screenshots (General / Contact Persons / Addresses / Payment Terms / Accounting tabs).

## Design decisions

None yet.

## Cross-L1 touchpoints

- **Fleet Management** FL / Equipment Owner Code, Operator Code → will become FK to BP when built.
- **Inventory** Item Master Data might reference BPs as manufacturers / preferred vendors.

## Outstanding

- Create `business_partners` table + model
- Real BP CRUD replacing the mocked form
- BP picker component reusable across Fleet / Inventory

## Last updated

- 2026-04-25 — module file created. Pages exist but data is mocked.
