# My Workspace Sidebar — Design Spec

**Date:** 2026-04-17
**Status:** Approved

---

## Overview

Remove the Lookups sidebar entry and replace it with a "My Workspace" section. Users can right-click any leaf sidebar item to pin it to My Workspace. Pins are stored in `localStorage` — no database, no server round-trips.

---

## Scope

- Remove Lookups from `config/navigation.php`
- Add My Workspace section (bottom of sidebar)
- Right-click context menu on leaf sidebar items: Add / Remove from My Workspace
- Alpine.js store backed by `localStorage`
- Six files changed, no migrations, no new routes, no Livewire components

---

## Data & Storage

An Alpine store named `workspace` is registered in `app.js` before `Alpine.start()`. It is the single source of truth for pinned items.

**Schema** (per item in `localStorage`):
```json
{ "label": "Customer Functional Location", "route": "fleet.functional-location.index", "icon": "building-office-2", "url": "/fleet/functional-location" }
```

`url` is the resolved Laravel route URL, captured at pin-time server-side. `route` (the named route) is kept for deduplication checks via `has(route)`.

**localStorage key:** `workspace_items` (JSON array)

**Store API:**
```js
Alpine.store('workspace', {
    items: JSON.parse(localStorage.getItem('workspace_items') || '[]'),
    add(item)    { if (!this.has(item.route)) { this.items.push(item); this._persist(); } },
    remove(route){ this.items = this.items.filter(i => i.route !== route); this._persist(); },
    has(route)   { return this.items.some(i => i.route === route); },
    _persist()   { localStorage.setItem('workspace_items', JSON.stringify(this.items)); },
});
```

**Constraints:**
- Leaf items only (items with a `route`, no `children`)
- No duplicate routes — `add` is a no-op if route already pinned
- Order is fixed (insertion order); no drag-to-reorder
- Items persist until explicitly removed or `localStorage` is cleared

---

## Navigation Config

**`config/navigation.php`:**
- Remove the `Lookups` entry
- Add at the bottom:

```php
[
    'label'     => 'My Workspace',
    'icon'      => 'star',
    'workspace' => true,
],
```

The `workspace: true` flag is the signal used by `sidebar.blade.php` to delegate rendering to the workspace partial instead of `sidebar-node`.

---

## Sidebar Loop Branch

**`sidebar.blade.php`** — replace the existing `@foreach` inner body with:

```blade
@if ($item['workspace'] ?? false)
    @include('components.sidebar-workspace', ['item' => $item])
@else
    @include('components.sidebar-node', ['item' => $item, 'level' => 0, 'isItemActive' => $isItemActive])
@endif
```

---

## Context Menu (sidebar-node.blade.php)

Applied only to leaf items (`isset($item['route'])` and `!isset($item['children'])`). The existing link element is wrapped in a small Alpine `x-data` block that manages `ctxOpen` state.

**Behavior:**
- Right-click → show context menu
- Click outside → dismiss
- Menu shows "Add to My Workspace" if route is not pinned, "Remove from My Workspace" if it is
- Uses `x-if` (not `x-show`) on `<template>` tags so Alpine re-evaluates store reactivity correctly

```blade
<div x-data="{ ctxOpen: false }" @click.outside="ctxOpen = false" class="relative">
    <a href="..." @contextmenu.prevent="ctxOpen = !ctxOpen">
        ...existing link content...
    </a>
    <div x-show="ctxOpen"
         class="absolute left-full top-0 z-50 ml-1 min-w-44 rounded-lg border border-gray-200 bg-white py-1 shadow-lg text-sm">
        <template x-if="!$store.workspace.has('{{ $item['route'] }}')">
            <button class="w-full px-3 py-1.5 text-left hover:bg-gray-50"
                    @click="$store.workspace.add(@js(['label' => $item['label'], 'route' => $item['route'], 'icon' => $item['icon'] ?? '', 'url' => route($item['route'])])); ctxOpen = false">
                Add to My Workspace
            </button>
        </template>
        <template x-if="$store.workspace.has('{{ $item['route'] }}')">
            <button class="w-full px-3 py-1.5 text-left hover:bg-gray-50"
                    @click="$store.workspace.remove('{{ $item['route'] }}'); ctxOpen = false">
                Remove from My Workspace
            </button>
        </template>
    </div>
</div>
```

---

## My Workspace Partial (sidebar-workspace.blade.php)

New file: `resources/views/components/sidebar-workspace.blade.php`

**Three states:**
1. Collapsed — header only (chevron rotated)
2. Expanded, empty — header + muted "No items added yet" hint text
3. Expanded, populated — header + list of pinned links

**Active state:** Each workspace link checks if its route matches the current URL using `window.location.pathname` compared against the Laravel-generated route URL (computed server-side into a JS object keyed by route name — or via string matching).

**Icons:** Workspace item icons cannot be rendered server-side (items are dynamic). A single neutral `document` icon is used for all workspace links. This is intentional — avoiding shipping the full icon switch to JS.

**Removal:** Right-clicking a workspace link shows a context menu with "Remove from My Workspace" only.

```blade
<div x-data="{ open: true }">
    {{-- Header --}}
    <button @click="open = !open"
            class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
        <x-icon name="{{ $item['icon'] }}" class="h-5 w-5 shrink-0" />
        <span x-show="!$store.sidebarCollapsed" class="flex-1 truncate text-left">{{ $item['label'] }}</span>
        <x-icon name="chevron-down" x-show="!$store.sidebarCollapsed"
                class="h-4 w-4 shrink-0 transition-transform"
                :class="open ? '' : '-rotate-90'" />
    </button>

    {{-- Item list --}}
    <ul x-show="open" class="mt-0.5 space-y-0.5 pl-4">
        <template x-if="$store.workspace.items.length === 0">
            <li class="px-3 py-2 text-xs text-gray-400">No items added yet</li>
        </template>
        <template x-for="wsItem in $store.workspace.items" :key="wsItem.route">
            <li x-data="{ ctxOpen: false }" @click.outside="ctxOpen = false" class="relative">
                <a :href="wsItem.route"
                   @contextmenu.prevent="ctxOpen = !ctxOpen"
                   class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-gray-100">
                    <x-icon name="document" class="h-5 w-5 shrink-0 text-gray-400" />
                    <span x-text="wsItem.label" x-show="!$store.sidebarCollapsed" class="truncate"></span>
                </a>
                <div x-show="ctxOpen"
                     class="absolute left-full top-0 z-50 ml-1 min-w-44 rounded-lg border border-gray-200 bg-white py-1 shadow-lg text-sm">
                    <button class="w-full px-3 py-1.5 text-left hover:bg-gray-50"
                            @click="$store.workspace.remove(wsItem.route); ctxOpen = false">
                        Remove from My Workspace
                    </button>
                </div>
            </li>
        </template>
    </ul>
</div>
```

**Note on `wsItem.url`:** The resolved URL is stored at pin-time via `route($item['route'])` in the server-side `@js(...)` payload. The `:href` binding in the workspace link uses `wsItem.url` directly.

---

## Icon Addition

**`icon.blade.php`** — add a `star` case:

```blade
@case('star')
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
    @break
```

---

## Files Changed

| File | Type | Change |
|---|---|---|
| `config/navigation.php` | Config | Remove Lookups; add My Workspace entry |
| `resources/js/app.js` | JS | Add `Alpine.store('workspace', {...})` |
| `resources/views/components/sidebar.blade.php` | Blade | Branch `@foreach` for workspace flag |
| `resources/views/components/sidebar-node.blade.php` | Blade | Right-click context menu on leaf items |
| `resources/views/components/sidebar-workspace.blade.php` | Blade | New partial — My Workspace section |
| `resources/views/components/icon.blade.php` | Blade | Add `star` icon case |

---

## Out of Scope

- Drag-to-reorder within My Workspace
- Database persistence (can be added later without changing the store API — just swap `_persist` to POST to a route)
- Role-based workspace visibility
- Workspace item limit / max count enforcement
