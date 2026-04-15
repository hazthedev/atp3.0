import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import collapse from '@alpinejs/collapse';
import { initFlowbite } from 'flowbite';
import { DataTable } from 'simple-datatables';

window.Alpine = Alpine;
window.Livewire = Livewire;

Alpine.plugin(collapse);

Alpine.data('appShell', () => ({
    sidebarOpen: false,
    sidebarCollapsed: false,
    sidebarWidth: parseInt(localStorage.getItem('sidebar-width') ?? '256', 10),
    _resizing: false,
    _startX: 0,
    _startWidth: 0,

    toggleMobileSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    },
    closeSidebar() {
        this.sidebarOpen = false;
    },
    toggleDesktopSidebar() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
    },

    startResize(e) {
        this._resizing = true;
        this._startX = e.clientX;
        this._startWidth = this.sidebarWidth;
        document.body.style.cursor = 'col-resize';
        document.body.style.userSelect = 'none';

        const onMove = (ev) => {
            if (!this._resizing) return;
            const delta = ev.clientX - this._startX;
            this.sidebarWidth = Math.min(480, Math.max(160, this._startWidth + delta));
        };
        const onUp = () => {
            this._resizing = false;
            document.body.style.cursor = '';
            document.body.style.userSelect = '';
            localStorage.setItem('sidebar-width', this.sidebarWidth);
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
        };

        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    },
}));

Alpine.data('tabs', (initialTab = 'overview') => ({
    activeTab: initialTab,
    setTab(tab) {
        this.activeTab = tab;
    },
}));

const datatableInstances = new WeakMap();
const datatableResizeObservers = new WeakMap();
const datatableHostSizes = new WeakMap();
let datatableMutationObserverStarted = false;

const collectDatatableTargets = (root = document) => {
    if (!root || typeof root.querySelectorAll !== 'function') {
        return [];
    }

    const tables = [];

    if (root instanceof Element && root.matches('table[data-datatable="true"]')) {
        tables.push(root);
    }

    tables.push(...root.querySelectorAll('table[data-datatable="true"]'));

    return tables;
};

const parseBooleanOption = (value, fallback = false) => {
    if (typeof value === 'undefined') {
        return fallback;
    }

    return value === 'true';
};

const getDatatableHost = (table) => {
    const host = table.closest('.datatable-host') ?? table.parentElement;

    if (host instanceof Element) {
        host.classList.add('datatable-host');
    }

    return host;
};

const isTableVisible = (table) => {
    if (!(table instanceof Element) || !table.isConnected) {
        return false;
    }

    const rect = table.getBoundingClientRect();

    return rect.width > 0 && rect.height > 0;
};

const resolveColumnOptions = (table) =>
    Array.from(table.querySelectorAll('thead th'))
        .map((header, index) => {
            const column = { select: index };
            let hasCustomConfig = false;

            if (header.dataset.sortable === 'false') {
                column.sortable = false;
                hasCustomConfig = true;
            }

            if (header.dataset.type) {
                column.type = header.dataset.type;
                hasCustomConfig = true;
            }

            if (header.dataset.format) {
                column.format = header.dataset.format;
                hasCustomConfig = true;
            }

            return hasCustomConfig ? column : null;
        })
        .filter(Boolean);

const buildSelectableRowRenderer = (row, tr) => {
    if (!tr.attributes) {
        tr.attributes = {};
    }

    const rowClasses = new Set((tr.attributes.class ?? '').split(/\s+/).filter(Boolean));

    if (row.selected) {
        rowClasses.add('selected');
    } else {
        rowClasses.delete('selected');
    }

    tr.attributes.class = Array.from(rowClasses).join(' ');

    return tr;
};

const disconnectDatatableObserver = (table) => {
    const observer = datatableResizeObservers.get(table);

    if (observer) {
        observer.disconnect();
        datatableResizeObservers.delete(table);
    }

    datatableHostSizes.delete(table);
};

const observeDatatableHost = (table) => {
    if (datatableResizeObservers.has(table) || typeof ResizeObserver === 'undefined') {
        return;
    }

    const host = getDatatableHost(table);

    if (!(host instanceof Element)) {
        return;
    }

    const observer = new ResizeObserver((entries) => {
        const entry = entries[0];

        if (!entry) {
            return;
        }

        const { width, height } = entry.contentRect;
        const previousSize = datatableHostSizes.get(table);

        if (previousSize && previousSize.width === width && previousSize.height === height) {
            return;
        }

        datatableHostSizes.set(table, { width, height });

        requestAnimationFrame(() => {
            if (!table.isConnected) {
                disconnectDatatableObserver(table);
                return;
            }

            if (datatableInstances.has(table)) {
                if (isTableVisible(table)) {
                    datatableInstances.get(table)?.update(true);
                }

                return;
            }

            if (table.dataset.datatable === 'true' && isTableVisible(table)) {
                initDataTables(table);
            }
        });
    });

    observer.observe(host);
    datatableResizeObservers.set(table, observer);
};

const syncSelectedRows = (table, instance) => {
    const selectedIndexes = instance.data.data.reduce((indexes, row, index) => {
        if (row.selected) {
            indexes.push(index);
        }

        return indexes;
    }, []);

    table.dataset.datatableSelectedRows = JSON.stringify(selectedIndexes);

    table.dispatchEvent(
        new CustomEvent('datatable:selection-change', {
            detail: {
                selectedIndexes,
                selectedCount: selectedIndexes.length,
            },
        }),
    );
};

const bindSelectableRows = (table, instance, multiSelect) => {
    instance.data.data.forEach((row) => {
        row.selected = false;
    });

    syncSelectedRows(table, instance);

    instance.on('datatable.selectrow', (rowIndex, event) => {
        if (typeof rowIndex !== 'number' || Number.isNaN(rowIndex)) {
            return;
        }

        if (event?.target instanceof Element && event.target.closest('a, button, input, select, textarea, label')) {
            return;
        }

        event?.preventDefault();

        const row = instance.data.data[rowIndex];

        if (!row) {
            return;
        }

        if (row.selected) {
            row.selected = false;
        } else {
            if (!multiSelect) {
                instance.data.data.forEach((dataRow) => {
                    dataRow.selected = false;
                });
            }

            row.selected = true;
        }

        instance.update();
        syncSelectedRows(table, instance);
    });
};

const destroyDataTables = (root = document) => {
    collectDatatableTargets(root).forEach((table) => {
        datatableInstances.get(table)?.destroy();
        datatableInstances.delete(table);
        delete table.dataset.datatableInitialized;
        disconnectDatatableObserver(table);
    });
};

const refreshDataTables = (root = document) => {
    collectDatatableTargets(root).forEach((table) => {
        observeDatatableHost(table);

        if (!isTableVisible(table)) {
            return;
        }

        if (datatableInstances.has(table)) {
            datatableInstances.get(table)?.update(true);
            return;
        }

        initDataTables(table);
    });
};

const queueDatatableRefresh = (() => {
    let queued = false;
    const roots = new Set();

    return (root = document) => {
        roots.add(root);

        if (queued) {
            return;
        }

        queued = true;

        requestAnimationFrame(() => {
            queued = false;
            initFlowbite();
            roots.forEach((refreshRoot) => refreshDataTables(refreshRoot));
            roots.clear();
            window.dispatchEvent(new Event('resize'));
        });
    };
})();

const initDataTables = (root = document) => {
    collectDatatableTargets(root).forEach((table) => {
        observeDatatableHost(table);

        if (!isTableVisible(table)) {
            return;
        }

        if (datatableInstances.has(table) || table.dataset.datatableInitialized === 'true') {
            return;
        }

        let perPageSelect = [5, 10, 25, 50];

        try {
            perPageSelect = JSON.parse(table.dataset.datatablePerPageSelect ?? '[5,10,25,50]');
        } catch {
            perPageSelect = [5, 10, 25, 50];
        }

        getDatatableHost(table);

        const selectable = parseBooleanOption(table.dataset.datatableSelectable, true);
        const multiSelect = parseBooleanOption(table.dataset.datatableMultiSelect, false);
        const rowNavigationRequested = parseBooleanOption(table.dataset.datatableRowNavigation, false);
        const coarsePointer = window.matchMedia('(any-pointer: coarse)').matches;
        const rowNavigation = rowNavigationRequested && !coarsePointer;

        const instance = new DataTable(table, {
            searchable: true,
            sortable: true,
            paging: true,
            perPage: Number.parseInt(table.dataset.datatablePerPage ?? '10', 10),
            perPageSelect,
            fixedHeight: parseBooleanOption(table.dataset.datatableFixedHeight, false),
            columns: resolveColumnOptions(table),
            rowNavigation,
            tabIndex: rowNavigation ? 1 : undefined,
            rowRender: selectable ? buildSelectableRowRenderer : false,
            labels: {
                placeholder: 'Search...',
                searchTitle: 'Search within table',
                perPage: 'entries per page',
                pageTitle: 'Page {page}',
                noRows: 'No records found',
                noResults: 'No matching records',
                info: 'Showing {start} to {end} of {rows} entries',
            },
        });

        if (selectable) {
            bindSelectableRows(table, instance, multiSelect);
        }

        datatableInstances.set(table, instance);
        table.dataset.datatableInitialized = 'true';
    });
};

const bootFlowbite = () => {
    initFlowbite();
    initDataTables();
};

const isDatatableMutationRoot = (element) =>
    element instanceof Element &&
    (element.matches('table[data-datatable="true"]') || element.querySelector('table[data-datatable="true"]'));

const isVisibilityMutationTarget = (element) =>
    element instanceof Element &&
    (element.hasAttribute('x-show') ||
        element.hasAttribute('x-cloak') ||
        element.hasAttribute('hidden') ||
        element.hasAttribute('open') ||
        element.hasAttribute('aria-hidden') ||
        element.hasAttribute('data-modal-target') ||
        element.hasAttribute('data-modal-toggle') ||
        element.hasAttribute('data-drawer-target') ||
        element.hasAttribute('data-drawer-toggle') ||
        element.hasAttribute('data-tabs-toggle') ||
        element.getAttribute('role') === 'dialog');

const startDatatableMutationObserver = () => {
    if (datatableMutationObserverStarted || typeof MutationObserver === 'undefined' || !document.body) {
        return;
    }

    datatableMutationObserverStarted = true;

    const observer = new MutationObserver((mutations) => {
        const refreshRoots = new Set();

        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach((node) => {
                    if (isDatatableMutationRoot(node)) {
                        refreshRoots.add(node);
                    }
                });

                return;
            }

            if (!isVisibilityMutationTarget(mutation.target)) {
                return;
            }

            if (isDatatableMutationRoot(mutation.target)) {
                refreshRoots.add(mutation.target);
            }
        });

        refreshRoots.forEach((root) => queueDatatableRefresh(root));
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['style', 'class', 'hidden', 'open', 'aria-hidden'],
    });
};

window.refreshFlowbiteTables = (root = document, { resetExisting = false } = {}) => {
    requestAnimationFrame(() => {
        if (resetExisting) {
            destroyDataTables(root);
        }

        initFlowbite();
        refreshDataTables(root);
        window.dispatchEvent(new Event('resize'));
    });
};

document.addEventListener('DOMContentLoaded', () => {
    bootFlowbite();
    startDatatableMutationObserver();
});

document.addEventListener('livewire:initialized', () => {
    queueMicrotask(bootFlowbite);

    if (window.Livewire?.hook) {
        window.Livewire.hook('morph.updating', ({ el }) => {
            destroyDataTables(el);
        });

        window.Livewire.hook('morphed', ({ el }) => {
            requestAnimationFrame(() => {
                initFlowbite();
                refreshDataTables(el);
            });
        });
    }
});

document.addEventListener('livewire:navigated', () => {
    requestAnimationFrame(bootFlowbite);
});

Livewire.start();
queueMicrotask(bootFlowbite);
queueMicrotask(startDatatableMutationObserver);
