# Weststar / SAP reference screenshots

This directory holds the SAP Business One and Aero One screenshot batches
that drive design decisions across the app — variant choices in
`docs/ui-variants.md`, layout decisions in `docs/modules/<l1>.md`, and the
spec-driven decisions captured in commit messages and PR descriptions.

**Why this exists.** The variant catalog and module docs reference specific
SAP / Aero One screens as authoritative sources (e.g. *"Customer Functional
Location top-card screenshot"*, *"SAP Penalty configuration form"*, *"Update
Counters modal"*). Without the actual pixels in the repo, future maintainers
can't verify a variant decision against the original intent — and bus-factor
risk grows whenever the screenshots live only in chat history or someone's
laptop.

## Naming convention

```
<l1-slug>-<screen-slug>-<batch>.png
```

Examples:

```
fleet-management-fl-customer-card.png
fleet-management-update-counters-modal.png
administration-users-setup-general-tab.png
administration-users-setup-services-tab.png
administration-user-groups-master-detail.png
administration-authorizations-permission-tree.png
administration-item-groups-general-tab.png
administration-item-groups-accounting-tab.png
administration-warehouses-general-tab.png
administration-warehouses-accounting-tab.png
inventory-item-master-data-list.png
inventory-item-master-data-edit-form.png
fleet-management-sap-penalty-config.png
fleet-management-fl-revamp-brief.png
```

Use `kebab-case` throughout. PNG preferred. Crop to the relevant screen
region — full desktop captures with browser chrome, taskbar, etc. just add
noise.

## Cross-referencing from docs

In `docs/ui-variants.md` and the module docs, link by relative path
whenever a decision references a specific screen:

```markdown
- **Code** field → `variant="indicator"` with `tone="green"` per
  [FL Customer card](screenshots/fleet-management-fl-customer-card.png).
```

This way a future maintainer reviewing a variant choice can click straight
through to the pixels.

## What goes in here vs what doesn't

**In here:**
- Reference screens for shipped or planned UI
- Spec briefs from Weststar for revamp / trim work
- Annotated SAP reference screens with red-circle callouts

**Not in here:**
- Our own UI screenshots — those go in PR descriptions or `docs/modules/<l1>.md`
  if they capture a shipped state
- General product marketing material
- Anything sensitive (customer data, internal pricing, etc.) — strip or
  redact before committing

## Provenance

Most screens originate from **Weststar's existing SAP B1 + Aero One
deployment**. Spec briefs come from the Weststar product team via chat
turns and design reviews.

If you have screenshots referenced in `docs/ui-variants.md` or any module
doc but not yet committed here, drop them in following the naming
convention and open a PR. Update the cross-references in the same PR.

## Currently referenced but not yet committed

Inferred from `docs/ui-variants.md` and the module docs as of 2026-04-27:

- FL Customer Functional Location top-card — primary source for the
  `tree`, `arrow-lookup`, `arrow-indicator`, `indicator (tone=green)` input
  variants
- Update Counters modal — Items / Equipment / FL variants
- SAP Penalty configuration form — 6 master penalty types
- FL revamp brief — fields marked for removal / keep
- Users – Setup, 3 tabs (General / Services / Display)
- User Groups master-detail with Group Type filter
- Authorizations Users/Groups tabs + subject tree + level actions
- Item Groups Setup, 2 tabs (General / Accounting)
- Warehouses Setup, 2 tabs (General / Accounting)
- Item Master Data 17-column list
- Category Part list (SAP Category Part List window)

These are the sources behind real variant decisions. Adding them turns
loose textual references into linkable design artefacts.
