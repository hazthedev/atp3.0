# Source Of Truth

This file captures the current implementation rules and approved UI patterns for the ATP 3.0 Laravel frontend.

## UI Patterns

### Design Direction

- Preserve the legacy workflow structure and information architecture when users already understand that flow.
- Do not preserve the legacy visual styling.
- Use the current ATP design system for:
  - inputs
  - tables
  - buttons
  - spacing
  - cards
  - borders
  - tabs and subtabs
- Prefer operationally faithful modernization:
  - keep the original screen layout logic
  - improve clarity and consistency with the new system styling
  - avoid creative redesigns that change how the screen is mentally read
- Prefer dense enterprise layouts over spacious marketing-style layouts for data-heavy modules.
- Prefer two text inputs per row on dense forms when it improves scanability.
- Keep drill-in and workflow interactions recognizable when they are meaningful to the old system.
- Use modern controls only when they improve the workflow; do not replace meaningful legacy interaction patterns just to look newer.
- Avoid unnecessary accent colors unless they communicate real meaning.
- Empty workspace pages are preferred for customer-card style modules; populate them only after the user selects a record from search.
- Sidebar and module arrangement should follow the real business structure and preserve workflow continuity.

### Drill-In Arrow Pattern

- Use the approved modern drill-in pattern for row identifiers in tables when the ID is the primary navigation affordance.
- Render the ID cell as a clickable link with:
  - bold ID text
  - a small blue circular icon chip
  - a `chevron-right` icon inside the chip
- The visual intent is "go deeper into this record", not "legacy tree-grid arrow".
- Avoid legacy yellow arrow styling or old desktop-app icon treatment.
- This drill-in pattern can coexist with a standard action column at the end of the row.

### Enterprise Component Layer

- Reuse the shared `enterprise` Blade components for dense ATP workflow pages whenever the screen matches these patterns:
  - `x-enterprise.panel`
  - `x-enterprise.field-row`
  - `x-enterprise.lookup-row`
  - `x-enterprise.control-row`
  - `x-enterprise.table-shell`
  - `x-enterprise.action-bar`
- Prefer these components before introducing new one-off layout wrappers for:
  - compact lookup forms
  - label/value row grids
  - dense operational table shells
  - wizard and action footers
- Keep page-specific layout helpers only when the legacy workflow shape genuinely needs a tighter custom arrangement.

## Implementation Rules

### Memory Workflow

- When the user explicitly says to remember a style, code approach, or implementation rule, store it in this folder.
- Update this file for active rules that should guide future work.
- Add a dated note to `decision-log.md` for traceability.

### Livewire Adoption Rule

- Use `Livewire` by default for ATP modules that are server-driven and interaction-heavy:
  - CRUD screens
  - searchable/filterable tables
  - paginated lists
  - modal workflows
  - multi-step or validated forms
  - attach/detach/apply/remove actions
- Keep `Blade + Alpine` for:
  - static or mostly static pages
  - read-heavy detail views
  - layout/navigation-only interactions
  - pages that do not yet have real backend behavior
- Only consider `Inertia` for future screens that become true application workspaces with heavy client-side state, rich drag/drop, or deeply interactive dashboards.
- Track Livewire rollout progress in `memory/livewire-adoption-checklist.md`.
- The current approved Livewire module pages are:
  - `Search Functional Locations`
  - `Customer Functional Location`
  - `Attach equipment to functional location`
  - `Detach equipment from functional location`
  - `Change customer information`
  - `Pending Installed Base updates from Work Orders`
  - `Equipment`
