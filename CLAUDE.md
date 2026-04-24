# ATP 3.0 — Claude Code project notes

When building or modifying UI in this repo, always consult the visual vocabulary
catalog before choosing HTML for text inputs.

## Must-read docs

- `docs/ui-variants.md` — the **text-input variant catalog**. Maps SAP / Weststar
  screenshot visual cues to the `<x-enterprise.input variant="...">` variants
  supported by `resources/views/components/enterprise/input.blade.php`. Read this
  any time the user hands you a screenshot of a Weststar or SAP form — pick the
  correct variant before writing Blade.
- `docs/modules/<l1>.md` — the **per-L1 module state file**. One file per
  top-level sidebar entry. Tells you what's shipped, stubbed, and outstanding
  inside that L1; what cross-L1 dependencies exist; and what design decisions
  have already been made.

## Session scope convention

**Every session is scoped to ONE L1 sidebar entry and its children.** On the
first turn, if the user hasn't said which L1, ask them.

Before making any code change:
1. Read `docs/modules/<l1>.md` for the in-scope module.
2. Read `docs/ui-variants.md` for any UI work.

**Update the module file at the end of a session or before merging a PR** with
what shipped, what's outstanding, and any new decisions. Durable state for the
next session lives in that file — don't leave it stale.

If a task requires touching two L1s (e.g. adding a FK from Fleet Management's
FL to Business Partners), note it explicitly: *"this change crosses <L1a> →
<L1b>; proceeding with user confirmation"* and confirm before proceeding. Then
update **both** module files.

The 10 L1s (matching `config/navigation.php`):

| # | L1 | Module file |
|---|---|---|
| 1 | Dashboard | `docs/modules/dashboard.md` |
| 2 | Administration | `docs/modules/administration.md` |
| 3 | Business Partners | `docs/modules/business-partners.md` |
| 4 | Inventory | `docs/modules/inventory.md` |
| 5 | Human Resources | `docs/modules/human-resources.md` |
| 6 | Technical Data | `docs/modules/technical-data.md` |
| 7 | Fleet Management | `docs/modules/fleet-management.md` |
| 8 | Flight Recording | `docs/modules/flight-recording.md` |
| 9 | MRO Management | `docs/modules/mro-management.md` |
| 10 | Reports | `docs/modules/reports.md` |

## Conventions already agreed with the user

- **Edit Record toggle** — detail pages are read-only by default, editable after
  clicking Edit Record. Implemented via the Alpine `editMode()` component and
  the `[data-edit-scope]` / `[data-editing]` attributes on a wrapper div.
- **Arrow chevron on list tables** (`<x-enterprise.table-cell variant="arrow">`)
  is reserved for list views whose source spec calls for it (e.g. the FL search
  page). Plain text list views (User Management) use a plain linked column.
- **Index pages** use the shared `<x-data-table ... datatable>` pattern — search,
  sort, and pagination come from simple-datatables on the client side. See
  `resources/views/livewire/fleet/functional-location-search-page.blade.php`
  for the reference implementation.
- **Auto-merge** squash-merge PRs without asking, per the user's durable preference.
  Branches named `feature/*`, `fix/*`, `refactor/*`, `docs/*` are expected.
- **Reference data CRUD** uses the pencil-launched Livewire modal pattern (see
  MeasureUnitsManager / CounterRefsManager). Rows read-only until the yellow
  pencil is clicked.

## Where to look first

- `routes/web.php` — all page URLs
- `config/navigation.php` — sidebar tree
- `resources/views/components/enterprise/` — reusable SAP-style input/table
  components
- `app/Livewire/` — grouped by domain (Fleet, System, Admin, Maintenance,
  Reports). Pages live here; reusable modals are here too.
- `app/Services/PenaltyEngine.php` — the cascade engine for counters.

## Deploy flow (cPanel)

```bash
git pull
composer install --no-dev --optimize-autoloader   # only when composer.lock changed
php artisan migrate --force                        # only when migrations added
php artisan db:seed --class=XxxSeeder --force      # only when seeders added
php artisan view:clear
php artisan config:cache
php artisan route:cache                            # only when routes changed
```

Note: faker is dev-only. On prod, `php artisan db:seed` without `--class=`
will fail on the UserFactory fake() call — always target individual seeders.
