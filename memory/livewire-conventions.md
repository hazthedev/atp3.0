# Livewire Conventions

These conventions define how `Livewire` should be introduced into ATP 3.0.

## Core Approach

- Prefer `Livewire` for server-driven interactivity, not for static page replication.
- Keep the existing `Blade + Tailwind + Flowbite + Alpine` foundation.
- Use `Livewire` for the behavior layer on qualifying screens, not as a reason to replace reusable Blade UI components.

## When To Use Livewire

- searchable/filterable tables
- paginated lists
- validated forms
- modal workflows
- dependent selects
- attach/detach/apply/remove actions
- inline edits or row actions
- multi-step workflows driven by Laravel state

## When To Avoid Livewire

- purely static pages
- read-heavy detail pages with little or no server interaction
- simple tabs, dropdowns, and local UI state already handled well by Alpine
- pages that are still frontend-only placeholders with no real data behavior yet

## Component Rules

- Keep page shells and shared presentational elements in Blade components where possible.
- Use `Livewire` components for stateful sections, not for every small visual fragment.
- Favor one meaningful page/component boundary over many tiny components.
- Use clear names like:
  - `FunctionalLocationSearch`
  - `BusinessPartnerTable`
  - `AttachEquipmentModal`

## Alpine Interop

- ATP uses the official manual ESM setup for `Livewire` and `Alpine`.
- Register Alpine plugins and Alpine data in `resources/js/app.js`.
- Use Alpine for local-only UI behavior.
- Use Livewire for server-backed state and actions.
- Reinitialize Flowbite on `livewire:initialized` and `livewire:navigated`.

## Tables And Filters

- Use query-string backed filters when the state should survive refresh/share/bookmark.
- Keep filter state close to the table component that owns the result set.
- Use pagination, sorting, and search inside the same Livewire component when they affect the same dataset.

## Forms

- Use Livewire validation for server-truth forms.
- Keep labels, inputs, selects, and helper text on shared Blade form components where practical.
- Avoid duplicating Tailwind classes in each Livewire view when shared components already exist.

## Modals

- If the modal performs a server action or contains validated form state, it is a good Livewire candidate.
- If the modal is only open/close UI with static content, keep it in Alpine/Blade.

## Build Notes

- The app uses the official manual bundling path:
  - `../../vendor/livewire/livewire/dist/livewire.esm`
- After changing JS or CSS, rebuild with `npm run build` or `npm run dev`.
- After installing or upgrading Livewire, verify the layout still includes:
  - `@livewireStyles`
  - `@livewireScriptConfig`
