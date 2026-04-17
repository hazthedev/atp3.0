# My Workspace Sidebar — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remove the Lookups sidebar entry and add a "My Workspace" section where users can right-click any leaf sidebar item to pin it; pins persist in `localStorage`.

**Architecture:** Six files changed, no backend. An `Alpine.store('workspace')` in `app.js` holds pinned items and syncs to `localStorage`. `sidebar.blade.php` detects the `workspace: true` flag in the nav config and delegates to a new `sidebar-workspace.blade.php` partial instead of the normal `sidebar-node` include. Right-click context menus in `sidebar-node.blade.php` call store methods to pin/unpin.

**Tech Stack:** Laravel 11, Blade, Alpine.js v3 (`@alpinejs/collapse`), Tailwind CSS, `localStorage`

---

## File Map

| File | Action | Responsibility |
|---|---|---|
| `resources/views/components/icon.blade.php` | Modify | Add `star` icon SVG case |
| `config/navigation.php` | Modify | Remove Lookups entry; add My Workspace entry with `workspace: true` |
| `resources/js/app.js` | Modify | Register `Alpine.store('workspace', {...})` before line 488 (`Livewire.start()`) |
| `resources/views/components/sidebar.blade.php` | Modify | Branch `@foreach` to detect `workspace` flag |
| `resources/views/components/sidebar-workspace.blade.php` | Create | Render My Workspace section from Alpine store |
| `resources/views/components/sidebar-node.blade.php` | Modify | Wrap leaf `<a>` in context menu `<div>` |

---

### Task 1: Add star icon

**Files:**
- Modify: `resources/views/components/icon.blade.php`

The icon component is a `@switch($name)` block. The star case must be added before `@default`.

- [ ] **Step 1: Add the star case**

In `resources/views/components/icon.blade.php`, find the last `@case` block and add the following immediately before `@default`:

```blade
        @case('star')
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
            @break
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/components/icon.blade.php
git commit -m "feat: add star icon for My Workspace sidebar entry"
```

---

### Task 2: Update navigation config

**Files:**
- Modify: `config/navigation.php`

- [ ] **Step 1: Remove Lookups, add My Workspace**

In `config/navigation.php`, the last entry in the return array is currently:

```php
    [
        'label' => 'Lookups',
        'route' => 'lookups.index',
        'icon' => 'book-solid',
    ],
```

Replace it with:

```php
    [
        'label'     => 'My Workspace',
        'icon'      => 'star',
        'workspace' => true,
    ],
```

- [ ] **Step 2: Verify with Artisan**

```bash
php artisan tinker --execute="collect(config('navigation'))->pluck('label')->toArray();"
```

Expected — `My Workspace` present, `Lookups` absent:
```
["Dashboard","Administration","Business Partners","Human Resources","Fleet Management","Flight Operations","MRO Management","Reports","My Workspace"]
```

```bash
php artisan tinker --execute="collect(config('navigation'))->last();"
```

Expected:
```
["label" => "My Workspace", "icon" => "star", "workspace" => true]
```

- [ ] **Step 3: Commit**

```bash
git add config/navigation.php
git commit -m "feat: replace Lookups with My Workspace entry in navigation config"
```

---

### Task 3: Register Alpine workspace store

**Files:**
- Modify: `resources/js/app.js`

The store must be registered before `Livewire.start()` on line 488 (which also starts Alpine). Insert it directly above that line.

- [ ] **Step 1: Add store before Livewire.start()**

In `resources/js/app.js`, insert the following block immediately before `Livewire.start();`:

```js
Alpine.store('workspace', {
    items: JSON.parse(localStorage.getItem('workspace_items') || '[]'),

    add(item) {
        if (!this.has(item.route)) {
            this.items.push(item);
            this._persist();
        }
    },

    remove(route) {
        this.items = this.items.filter(i => i.route !== route);
        this._persist();
    },

    has(route) {
        return this.items.some(i => i.route === route);
    },

    _persist() {
        localStorage.setItem('workspace_items', JSON.stringify(this.items));
    },
});

```

After the edit, the bottom of the file should read:

```js
Alpine.store('workspace', {
    items: JSON.parse(localStorage.getItem('workspace_items') || '[]'),

    add(item) {
        if (!this.has(item.route)) {
            this.items.push(item);
            this._persist();
        }
    },

    remove(route) {
        this.items = this.items.filter(i => i.route !== route);
        this._persist();
    },

    has(route) {
        return this.items.some(i => i.route === route);
    },

    _persist() {
        localStorage.setItem('workspace_items', JSON.stringify(this.items));
    },
});

Livewire.start();
queueMicrotask(bootFlowbite);
queueMicrotask(startDatatableMutationObserver);
```

- [ ] **Step 2: Build assets**

```bash
npm run build
```

Expected: exits 0, no errors in output.

- [ ] **Step 3: Verify store in browser**

Start the app (`php artisan serve`). Load any page. Open DevTools console and run:

```js
Alpine.store('workspace')
```

Expected: object with `items`, `add`, `remove`, `has`, `_persist` properties. `items` should be `[]` on a fresh browser.

- [ ] **Step 4: Commit**

```bash
git add resources/js/app.js
git commit -m "feat: register Alpine workspace store backed by localStorage"
```

---

### Task 4: Branch sidebar foreach + create workspace partial

**Files:**
- Modify: `resources/views/components/sidebar.blade.php`
- Create: `resources/views/components/sidebar-workspace.blade.php`

These are done together — the branch in sidebar.blade.php is a no-op without the partial it delegates to.

- [ ] **Step 1: Branch the sidebar foreach**

In `resources/views/components/sidebar.blade.php`, find:

```blade
                    @foreach ($items as $item)
                        @include('components.sidebar-node', [
                            'item' => $item,
                            'level' => 0,
                            'isItemActive' => $isItemActive,
                        ])
                    @endforeach
```

Replace with:

```blade
                    @foreach ($items as $item)
                        @if ($item['workspace'] ?? false)
                            @include('components.sidebar-workspace', ['item' => $item])
                        @else
                            @include('components.sidebar-node', [
                                'item' => $item,
                                'level' => 0,
                                'isItemActive' => $isItemActive,
                            ])
                        @endif
                    @endforeach
```

- [ ] **Step 2: Create sidebar-workspace.blade.php**

Create `resources/views/components/sidebar-workspace.blade.php`:

```blade
<li x-data="{ open: true }" class="space-y-1">
    {{-- Section header --}}
    <div class="sidebar-link justify-between" style="padding-left: 0.75rem;">
        <button type="button"
                class="flex min-w-0 flex-1 items-center gap-3 text-left"
                @click="open = !open"
                title="{{ $item['label'] }}">
            <x-icon :name="$item['icon'] ?? 'star'" class="h-5 w-5 shrink-0" />
            <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
        </button>
        <button type="button"
                class="ml-2 shrink-0 rounded-md p-1 text-gray-400 transition hover:bg-white hover:text-gray-700"
                @click.stop="open = !open"
                x-cloak x-show="!sidebarCollapsed"
                aria-label="Toggle My Workspace">
            <x-icon name="chevron-down"
                    class="h-4 w-4 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
        </button>
    </div>

    {{-- Item list --}}
    <ul x-cloak x-show="open && !sidebarCollapsed" x-collapse class="ml-4 space-y-1 border-l border-gray-200 pl-2">
        <template x-if="$store.workspace.items.length === 0">
            <li class="px-3 py-2 text-xs text-gray-400">No items added yet</li>
        </template>
        <template x-for="wsItem in $store.workspace.items" :key="wsItem.route">
            <li x-data="{ ctxOpen: false }" @click.outside="ctxOpen = false" class="relative">
                <a :href="wsItem.url"
                   @contextmenu.prevent="ctxOpen = !ctxOpen"
                   class="sidebar-link"
                   style="padding-left: 0.75rem;"
                   :title="wsItem.label">
                    <x-icon name="document" class="h-5 w-5 shrink-0" />
                    <span x-text="wsItem.label" class="truncate"></span>
                </a>
                <div x-show="ctxOpen"
                     class="absolute left-full top-0 z-50 ml-1 min-w-44 rounded-lg border border-gray-200 bg-white py-1 text-sm shadow-lg">
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-700 hover:bg-gray-50"
                            @click="$store.workspace.remove(wsItem.route); ctxOpen = false">
                        Remove from My Workspace
                    </button>
                </div>
            </li>
        </template>
    </ul>
</li>
```

- [ ] **Step 3: Verify My Workspace section appears**

Load the app in a browser. Confirm:
- "My Workspace" appears at the bottom of the sidebar with a star icon
- Clicking the header toggles the section open/closed (chevron rotates)
- When expanded and empty: "No items added yet" appears in muted small text
- When sidebar is collapsed to icon-only mode: only the star icon shows, no label

- [ ] **Step 4: Commit**

```bash
git add resources/views/components/sidebar.blade.php resources/views/components/sidebar-workspace.blade.php
git commit -m "feat: add My Workspace sidebar section with empty state"
```

---

### Task 5: Add right-click context menu to leaf sidebar items

**Files:**
- Modify: `resources/views/components/sidebar-node.blade.php`

Leaf items are the `@else` branch — items with a `route` but no `children`. The `<a>` element is wrapped in a `<div>` with Alpine context menu state. The `<li>` already has `x-data="{ open: ... }"` — do not touch that.

- [ ] **Step 1: Replace the @else block**

In `resources/views/components/sidebar-node.blade.php`, find:

```blade
    @else
        <a href="{{ route($item['route']) }}" class="{{ $linkClass }}" style="padding-left: {{ $indent }}rem;" title="{{ $item['label'] }}">
            <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
            <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
        </a>
    @endif
```

Replace with:

```blade
    @else
        <div x-data="{ ctxOpen: false }" @click.outside="ctxOpen = false" class="relative">
            <a href="{{ route($item['route']) }}"
               class="{{ $linkClass }}"
               style="padding-left: {{ $indent }}rem;"
               title="{{ $item['label'] }}"
               @contextmenu.prevent="ctxOpen = !ctxOpen">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </a>
            <div x-show="ctxOpen"
                 class="absolute left-full top-0 z-50 ml-1 min-w-44 rounded-lg border border-gray-200 bg-white py-1 text-sm shadow-lg">
                <template x-if="!$store.workspace.has('{{ $item['route'] }}')">
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-700 hover:bg-gray-50"
                            @click="$store.workspace.add(@js(['label' => $item['label'], 'route' => $item['route'], 'icon' => $item['icon'] ?? '', 'url' => route($item['route'])])); ctxOpen = false">
                        Add to My Workspace
                    </button>
                </template>
                <template x-if="$store.workspace.has('{{ $item['route'] }}')">
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-700 hover:bg-gray-50"
                            @click="$store.workspace.remove('{{ $item['route'] }}'); ctxOpen = false">
                        Remove from My Workspace
                    </button>
                </template>
            </div>
        </div>
    @endif
```

- [ ] **Step 2: Verify pin flow end-to-end**

In the browser, right-click any leaf sidebar item (e.g. "User" under Administration › User Management). Confirm:
- A white context menu appears to the right of the item labelled "Add to My Workspace"
- Clicking it dismisses the menu and the item appears in My Workspace at the bottom of the sidebar

- [ ] **Step 3: Verify toggle label**

Right-click the same item again. Confirm the menu now shows "Remove from My Workspace" (not "Add").

- [ ] **Step 4: Verify localStorage persistence**

Open DevTools → Application → Local Storage → your origin. Confirm a key `workspace_items` exists containing a JSON array with the pinned item. Refresh the page. Confirm the item is still in My Workspace.

- [ ] **Step 5: Verify removal from My Workspace section**

Right-click the pinned item in the My Workspace section. Confirm "Remove from My Workspace" appears. Click it. Confirm the item disappears from My Workspace and `workspace_items` in localStorage is updated to `[]`.

- [ ] **Step 6: Commit and push**

```bash
git add resources/views/components/sidebar-node.blade.php
git commit -m "feat: right-click context menu on leaf sidebar items to pin/unpin from My Workspace"
git push origin master
```
