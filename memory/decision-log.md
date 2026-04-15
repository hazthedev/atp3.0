# Decision Log

## 2026-03-30

### Reusable Enterprise Component Set

- Added a shared `enterprise` component layer for dense ATP workflow pages:
  - `panel`
  - `field-row`
  - `lookup-row`
  - `control-row`
  - `table-shell`
  - `action-bar`
- Started refactoring recurring fleet pages onto these shared components to improve consistency and reduce one-off layout duplication.

### Approved Design Preference Summary

- The approved ATP frontend direction is:
  - legacy workflow structure
  - current ATP visual design
- Keep the old information architecture and operational reading order where it matters.
- Do not recreate the old desktop-app skin.
- Prefer dense enterprise layouts for operational screens.
- Prefer two text inputs per row for dense forms when practical.
- Use modernization to improve clarity, not to invent a new workflow.
- Keep meaningful legacy interaction patterns when they still serve the workflow.

## 2026-03-27

### Functional Location ID Drill-In Style

- The legacy arrow in the Functional Location `ID` column was intentionally modernized.
- Approved style:
  - small blue circular chip
  - `chevron-right` icon
  - bold clickable ID text
- Keep this pattern as the reusable drill-in affordance for similar tables.
- The table may still include a separate action column at the far right.

### Memory Folder

- Created `memory/` as the repo-level place for durable coding/style/implementation decisions.
- Going forward, explicit "remember this" requests should be written here.

### Livewire Adoption Default

- Approved implementation rule:
  - use `Livewire` for ATP modules that are CRUD-heavy, filterable, searchable, form-heavy, or workflow-oriented
  - keep `Blade + Alpine` for static/detail/read-heavy screens
  - only consider `Inertia` for future highly interactive workspace-style pages
- Added rollout tracker at `memory/livewire-adoption-checklist.md`.

### Livewire Foundation Installed

- Installed `livewire/livewire` into the Laravel app.
- Integrated Livewire using the official manual ESM bundling pattern in `resources/js/app.js`.
- Added `@livewireStyles` and `@livewireScriptConfig` to the shared layouts.
- Added supporting docs:
  - `memory/livewire-conventions.md`
  - `memory/livewire-manual-verification.md`

### Functional Location Livewire Rollout

- Converted these Functional Location screens to Livewire:
  - `Search Functional Locations`
  - `Customer Functional Location`
  - `Attach equipment to functional location`
  - `Detach equipment from functional location`
  - `Change customer information`
  - `Pending Installed Base updates from Work Orders`
- Converted `Equipment` list to Livewire.
- `Search Functional Locations` now uses a Livewire-backed searchable and paginated table.
- `Customer Functional Location` now uses a Livewire-backed record shell for both:
  - empty sidebar entry state
  - filled detail view reached from the ID drill-in
- `Attach equipment to functional location` now uses a Livewire two-pane workspace for:
  - selecting the target functional location
  - selecting installed and candidate equipment rows
  - attach, detach, and swap preview actions
- `Detach equipment from functional location` now uses a Livewire single-table workspace for:
  - loading a functional location by code
  - searching by equipment code
  - selecting installed equipment rows for detachment
  - entering uninstallation metadata and return reasons
- `Change customer information` now uses a Livewire compact form workspace for:
  - loading a functional location by ID/code
  - editing owner and operator fields
  - toggling force owner propagation
  - capturing date-of-change and comment input
- `Pending Installed Base updates from Work Orders` now uses a Livewire review table for:
  - toggling the open-work-order view
  - reviewing wide install-base update rows
  - confirming selected rows before later backend integration
- `Equipment` now uses a Livewire table for:
  - legacy column layout adapted to the ATP table system
  - ID drill-in navigation
  - live filtering by item, serial, operator, or owner
