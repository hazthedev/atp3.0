@php
    $mode = $mode ?? 'create';
    $isEdit = $mode !== 'create';
    $startEditing = $mode === 'edit';
    $recordId = (int) ($recordId ?? request()->route('id') ?? 410001);
    $displayId = $recordId > 0 ? $recordId : 410001;

    $item = $isEdit
        ? [
            'item_no' => 'AW139-' . str_pad((string) ($displayId % 1000), 3, '0', STR_PAD_LEFT),
            'item_code_suffix' => 'A',
            'description' => 'Main Rotor Blade Set',
            'item_group' => 'Rotor Components',
            'category_part' => 'Category Part A',
            'manufacturer' => 'Leonardo',
            'manage_item_by' => 'None',
            'linked_to_resource' => 'Rotor Resource Pool',
            'set_gl_accounts_by' => 'Item Group',
            'inventory_uom_name' => 'Each',
            'inventory_weight' => '148',
            'manage_inventory_by_warehouse' => true,
            'inventory_level_required' => '1',
            'inventory_level_minimum' => '2',
            'inventory_level_maximum' => '8',
            'valuation_method' => 'Moving Average',
            'item_cost' => '172450.00',
            'status' => 'active',
            'remarks' => 'Critical rotor item for mission-ready inventory planning and procurement.',
        ]
        : [
            'item_no' => 'ITEM-DRAFT',
            'item_code_suffix' => '',
            'description' => '',
            'item_group' => 'Rotor Components',
            'category_part' => '',
            'manufacturer' => '',
            'manage_item_by' => 'None',
            'linked_to_resource' => '',
            'set_gl_accounts_by' => 'Item Group',
            'inventory_uom_name' => '',
            'inventory_weight' => '',
            'manage_inventory_by_warehouse' => false,
            'inventory_level_required' => '',
            'inventory_level_minimum' => '',
            'inventory_level_maximum' => '',
            'valuation_method' => 'Moving Average',
            'item_cost' => '',
            'status' => 'active',
            'remarks' => '',
        ];

    $dbItem = \App\Models\Item::with(['counters.counterRef', 'calendarCounter'])->find($recordId);
    $dbItemId = $dbItem?->id;

    if ($dbItem) {
        $item['item_no'] = $dbItem->code;
        $item['description'] = $dbItem->description;
    }

    $standardCounters = $dbItem
        ? $dbItem->counters->map(fn ($c) => [
            'counter_desc' => $c->counterRef?->name ?? '',
            'max_value' => $c->max_value_hhmm ?: ($c->max_value_dec ?: ''),
            'tolerance' => $c->tolerance_hhmm ?: ($c->tolerance_dec ?: ''),
            'orange_light' => ($c->orange_light_percent ?? 90) . '% of max.',
            'status' => $c->status,
            'modification_ref' => $c->modif_ref ?? '',
        ])->values()->all()
        : [
            ['counter_desc' => 'FH', 'max_value' => '99999', 'tolerance' => '5', 'orange_light' => '500', 'status' => 'Active', 'modification_ref' => 'MOD-FH-01'],
            ['counter_desc' => 'FC', 'max_value' => '99999', 'tolerance' => '3', 'orange_light' => '300', 'status' => 'Active', 'modification_ref' => 'MOD-FC-01'],
        ];

    $calendarCounters = $dbItem && $dbItem->calendarCounter
        ? [[
            'counter_desc' => $dbItem->calendarCounter->label,
            'limit' => $dbItem->calendarCounter->limit_days ? $dbItem->calendarCounter->limit_days . ' days' : '',
            'orange_light' => ($dbItem->calendarCounter->orange_light_days ?? 90) . ' days from the limit.',
            'status' => $dbItem->calendarCounter->status,
        ]]
        : [
            ['counter_desc' => 'Monthly Inspection', 'limit' => '1 month', 'orange_light' => '5 days', 'status' => 'Active'],
            ['counter_desc' => 'Quarterly Review', 'limit' => '3 months', 'orange_light' => '15 days', 'status' => 'Active'],
        ];

    $warehouseRows = [
        ['code' => 'KUL-MAIN', 'name' => 'Kuala Lumpur Main', 'locked' => 'No', 'first_bin' => 'A1-10', 'default_bin' => 'A1-10', 'enforce' => 'No', 'in_stock' => '4', 'committed' => '1', 'ordered' => '2', 'available' => '3'],
        ['code' => 'SZB-ROT', 'name' => 'Subang Rotor Store', 'locked' => 'No', 'first_bin' => 'R2-04', 'default_bin' => 'R2-04', 'enforce' => 'No', 'in_stock' => '2', 'committed' => '0', 'ordered' => '1', 'available' => '2'],
    ];

    $attachments = [
        ['target_path' => '/spares/aw139/rotor', 'file_name' => 'AW139-MRB-datasheet.pdf', 'attachment_date' => '2026-04-02'],
        ['target_path' => '/spares/aw139/rotor', 'file_name' => 'AW139-install-notes.docx', 'attachment_date' => '2026-04-05'],
    ];

    $pageTitle = match ($mode) {
        'edit'  => 'Edit Item Master Data',
        'show'  => 'Item Master Data',
        default => 'Create Item Master Data',
    };
    $pageDescription = match ($mode) {
        'edit'  => 'Maintain item setup across purchasing, sales, inventory, planning, properties, remarks, and attachments using the current enterprise workspace pattern.',
        'show'  => 'Read-only detail card for the selected item. Click Edit Record to make changes.',
        default => 'Create a new item master data record using the modern tabbed workspace already used in ATP modules.',
    };
    $saveMessage = $isEdit ? 'Item master data preview updated.' : 'Item master data draft prepared.';
    $cancelMessage = $isEdit ? 'Item master-data preview cancelled.' : 'Item master-data draft cancelled.';
@endphp

@if ($isEdit)
<div x-data="editMode({{ $startEditing ? 'true' : 'false' }})" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
@endif
<div
    class="space-y-6"
    x-data="{
        activeTab: 'general',
        statusMessage: '',
        item: @js($item),
        standardCounters: @js($standardCounters),
        calendarCounters: @js($calendarCounters),
        warehouseRows: @js($warehouseRows),
        attachments: @js($attachments),
        saveMessage: @js($saveMessage),
        cancelMessage: @js($cancelMessage),
        saveItem() { this.statusMessage = this.saveMessage; },
        cancelItem() { this.statusMessage = this.cancelMessage; },
    }"
>
    <x-page-header :title="$pageTitle" :description="$pageDescription">
        <x-slot name="actions">
            <a href="{{ route('inventory.item-master-data.index') }}" class="btn-secondary">
                <x-icon name="chevron-right" class="h-4 w-4 rotate-180" />
                Back to List
            </a>
            @if ($isEdit)
                <template x-if="!editing">
                    <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-primary" @click="save()">Save</button>
                </template>
            @else
                <button type="button" class="btn-primary" @click="saveItem()">
                    <x-icon name="document-text" class="h-4 w-4" />
                    Save Preview
                </button>
            @endif
        </x-slot>
    </x-page-header>

    <section class="attach-workspace-shell max-w-[1380px] space-y-5">
        <template x-if="statusMessage">
            <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
        </template>

        @if ($isEdit && $dbItemId)
            <x-card title="Identity" description="Persisted item master fields. Edit Record to change." padding="p-6">
                @livewire('system.item-master-data-form', ['itemId' => $dbItemId], key('item-md-form-'.$dbItemId))
            </x-card>
        @endif

        <x-enterprise.panel muted class="space-y-3">
            <x-enterprise.field-row label="Item No." for="item_master_no" class="grid-cols-[156px_minmax(0,1fr)]">
                <div class="grid gap-2 md:grid-cols-[minmax(0,180px)_40px_minmax(0,1fr)]">
                    <x-enterprise.input id="item_master_no" x-model="item.item_no" class="attach-input input-field-filled" />
                    <button type="button" class="inline-flex h-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-[#9fb2ff] hover:text-[#2f5bff]">
                        <x-icon name="chevron-down" class="h-4 w-4" />
                    </button>
                    <x-enterprise.input x-model="item.item_code_suffix" class="attach-input" />
                </div>
            </x-enterprise.field-row>
            <x-enterprise.field-row label="Description" for="item_master_description" class="grid-cols-[156px_minmax(0,1fr)]">
                <x-enterprise.input id="item_master_description" x-model="item.description" class="attach-input" />
            </x-enterprise.field-row>
            <x-enterprise.field-row label="Item Group" for="item_master_group" class="grid-cols-[156px_minmax(0,1fr)]">
                <div class="grid gap-2 md:grid-cols-[minmax(0,1fr)_minmax(0,180px)]">
                    <x-enterprise.select id="item_master_group" x-model="item.item_group" class="attach-input">
                        <option>Rotor Components</option>
                        <option>Electrical</option>
                        <option>Tooling</option>
                        <option>Consumables</option>
                    </x-enterprise.select>
                    <x-enterprise.input x-model="item.category_part" class="attach-input" placeholder="Category part" />
                </div>
            </x-enterprise.field-row>
        </x-enterprise.panel>

        <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
            <div class="subtab-shell">
                <ul class="subtab-list">
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'general' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'general'">General</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'aero-one' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'aero-one'">Aero One</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'inventory' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'inventory'">Inventory Data</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'remarks' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'remarks'">Remarks</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'attachments' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'attachments'">Attachments</button></li>
                </ul>
            </div>
        </div>
        <div x-cloak x-show="activeTab === 'general'">
            <x-enterprise.panel class="space-y-6">
                <div class="space-y-3">
                    <x-enterprise.field-row label="Manufacturer" for="item_general_manufacturer" class="grid-cols-[176px_minmax(0,1fr)]">
                        <x-enterprise.select id="item_general_manufacturer" x-model="item.manufacturer" class="attach-input">
                            <option value="">Select manufacturer</option>
                            <option>Leonardo</option>
                            <option>Airbus Helicopters</option>
                            <option>Safran</option>
                        </x-enterprise.select>
                    </x-enterprise.field-row>
                    <x-enterprise.field-row label="Manage Item by" for="item_general_manage_by" class="grid-cols-[176px_minmax(0,1fr)]">
                        <x-enterprise.select id="item_general_manage_by" x-model="item.manage_item_by" class="attach-input">
                            <option>None</option>
                            <option>Serial Number</option>
                            <option>Batch Number</option>
                        </x-enterprise.select>
                    </x-enterprise.field-row>
                </div>

                <div class="grid gap-6 xl:grid-cols-[240px_minmax(0,1fr)]">
                    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="attach-field-label">Status</div>
                        <label class="attach-checkbox-inline">
                            <x-enterprise.radio value="active" x-model="item.status" />
                            <span>Active</span>
                        </label>
                        <label class="attach-checkbox-inline">
                            <x-enterprise.radio value="inactive" x-model="item.status" />
                            <span>Inactive</span>
                        </label>
                        <label class="attach-checkbox-inline">
                            <x-enterprise.radio value="advanced" x-model="item.status" />
                            <span>Advanced</span>
                        </label>
                    </div>

                    <x-enterprise.field-row label="Linked to Resource" for="item_general_linked_resource" class="grid-cols-[176px_minmax(0,1fr)]">
                        <x-enterprise.input id="item_general_linked_resource" x-model="item.linked_to_resource" class="attach-input" />
                    </x-enterprise.field-row>
                </div>
            </x-enterprise.panel>
        </div>
        <div x-cloak x-show="activeTab === 'aero-one'"
             x-data="{ ctxOpen: false, ctxX: 0, ctxY: 0 }"
             @contextmenu.prevent="ctxOpen = true; ctxX = $event.clientX; ctxY = $event.clientY">
            <div class="relative">
                <div x-cloak x-show="ctxOpen"
                     @click.outside="ctxOpen = false"
                     @keydown.escape.window="ctxOpen = false"
                     :style="`left: ${ctxX}px; top: ${ctxY}px`"
                     class="fixed z-50 min-w-56 rounded-lg border border-gray-200 bg-white py-1 text-sm shadow-lg">
                    @foreach (['Remove', 'Duplicate', 'New Activity', 'Business Partner Catalog Numbers', 'Bill of Materials', 'Alternative Items'] as $opt)
                        <button type="button" class="w-full cursor-default px-3 py-1.5 text-left text-gray-400">{{ $opt }}</button>
                    @endforeach
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-800 hover:bg-blue-50 hover:text-blue-700"
                            @if ($dbItemId) @click="$dispatch('open-item-counters', { itemId: {{ $dbItemId }} }); ctxOpen = false" @else @click="ctxOpen = false" disabled @endif>
                        Define Counters
                    </button>
                    @foreach (['Define Task Lists', 'Related Activities', 'Inventory Posting List', 'Inventory Audit Report', 'Bin Location Content List', 'Items List', 'Serial Number Transactions Report', 'Inventory Status', 'Create Purchase Quotation', 'Purchase Quotation Comparison Report', 'Purchase Request Report', 'Available-to-Promise', 'Relationship Map…'] as $opt)
                        <button type="button" class="w-full cursor-default px-3 py-1.5 text-left text-gray-400">{{ $opt }}</button>
                    @endforeach
                </div>
            <x-enterprise.panel class="space-y-6">
                <div class="space-y-3">
                    <div class="text-sm font-semibold text-gray-900">Standard Counters</div>
                    <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                        <x-slot name="thead">
                            <tr>
                                <th>Counter Desc</th>
                                <th>Max value</th>
                                <th>Tolerance</th>
                                <th>Orange light</th>
                                <th>Status</th>
                                <th>Modification Ref.</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="(row, index) in standardCounters" :key="`std-${index}`">
                                <tr>
                                    <td x-text="row.counter_desc"></td>
                                    <td x-text="row.max_value"></td>
                                    <td x-text="row.tolerance"></td>
                                    <td x-text="row.orange_light"></td>
                                    <td x-text="row.status"></td>
                                    <td x-text="row.modification_ref"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </div>

                <div class="space-y-3">
                    <div class="text-sm font-semibold text-gray-900">Calendar Counters</div>
                    <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                        <x-slot name="thead">
                            <tr>
                                <th>Counter Desc</th>
                                <th>Limit</th>
                                <th>Orange light</th>
                                <th>Status</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="(row, index) in calendarCounters" :key="`cal-${index}`">
                                <tr>
                                    <td x-text="row.counter_desc"></td>
                                    <td x-text="row.limit"></td>
                                    <td x-text="row.orange_light"></td>
                                    <td x-text="row.status"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </div>
            </x-enterprise.panel>
            </div>
        </div>
        <div x-cloak x-show="activeTab === 'inventory'">
            <x-enterprise.panel class="space-y-6">
                <div class="grid gap-6 xl:grid-cols-2">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Set G/L Accounts By" for="item_inventory_gl_by" class="grid-cols-[176px_minmax(0,1fr)]">
                            <x-enterprise.select id="item_inventory_gl_by" x-model="item.set_gl_accounts_by" class="attach-input">
                                <option>Item Group</option>
                                <option>Warehouse</option>
                            </x-enterprise.select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="UoM Name" for="item_inventory_uom_name" class="grid-cols-[176px_minmax(0,1fr)]"><x-enterprise.input id="item_inventory_uom_name" x-model="item.inventory_uom_name" class="attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Weight" for="item_inventory_weight" class="grid-cols-[176px_minmax(0,1fr)]"><x-enterprise.input id="item_inventory_weight" x-model="item.inventory_weight" class="attach-input input-field-filled" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3">
                        <label class="attach-checkbox-inline">
                            <x-enterprise.checkbox x-model="item.manage_inventory_by_warehouse" />
                            <span>Manage Inventory by Warehouse</span>
                        </label>
                        <x-enterprise.field-row label="Required (Purchasing UoM)" for="item_inventory_required" class="grid-cols-[200px_minmax(0,1fr)]"><x-enterprise.input id="item_inventory_required" x-model="item.inventory_level_required" class="attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Minimum" for="item_inventory_minimum" class="grid-cols-[200px_minmax(0,1fr)]"><x-enterprise.input id="item_inventory_minimum" x-model="item.inventory_level_minimum" class="attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Maximum" for="item_inventory_maximum" class="grid-cols-[200px_minmax(0,1fr)]"><x-enterprise.input id="item_inventory_maximum" x-model="item.inventory_level_maximum" class="attach-input input-field-filled" /></x-enterprise.field-row>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <x-enterprise.field-row label="Valuation Method" for="item_inventory_valuation_method" class="grid-cols-[176px_minmax(0,1fr)]">
                        <x-enterprise.select id="item_inventory_valuation_method" x-model="item.valuation_method" class="attach-input">
                            <option>Moving Average</option>
                            <option>Standard</option>
                        </x-enterprise.select>
                    </x-enterprise.field-row>
                    <x-enterprise.field-row label="Item Cost" for="item_inventory_item_cost" class="grid-cols-[176px_minmax(0,1fr)]">
                        <x-enterprise.input id="item_inventory_item_cost" x-model="item.item_cost" class="attach-input" />
                    </x-enterprise.field-row>
                </div>

                <div class="space-y-3">
                    <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                        <x-slot name="thead">
                            <tr>
                                <th>Whse Code</th>
                                <th>Whse Name</th>
                                <th>Locked</th>
                                <th>First Bin</th>
                                <th>Default Bin</th>
                                <th>Enforce</th>
                                <th>In Stock</th>
                                <th>Committed</th>
                                <th>Ordered</th>
                                <th>Available</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="(row, index) in warehouseRows" :key="`wh-${index}`">
                                <tr>
                                    <td x-text="row.code"></td>
                                    <td x-text="row.name"></td>
                                    <td x-text="row.locked"></td>
                                    <td x-text="row.first_bin"></td>
                                    <td x-text="row.default_bin"></td>
                                    <td x-text="row.enforce"></td>
                                    <td x-text="row.in_stock"></td>
                                    <td x-text="row.committed"></td>
                                    <td x-text="row.ordered"></td>
                                    <td x-text="row.available"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                    <div class="flex justify-end">
                        <button type="button" class="btn-secondary">Set Default Whse</button>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>
        <div x-cloak x-show="activeTab === 'remarks'">
            <x-enterprise.panel class="space-y-4">
                <x-enterprise.textarea x-model="item.remarks" rows="12" class="attach-textarea min-h-[320px]" />
            </x-enterprise.panel>
        </div>
        <div x-cloak x-show="activeTab === 'attachments'">
            <x-enterprise.panel class="space-y-4">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_180px]">
                    <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                        <x-slot name="thead">
                            <tr>
                                <th>#</th>
                                <th>Target Path</th>
                                <th>File Name</th>
                                <th>Attachment Date</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="(row, index) in attachments" :key="`att-${index}`">
                                <tr>
                                    <td x-text="index + 1"></td>
                                    <td x-text="row.target_path"></td>
                                    <td x-text="row.file_name"></td>
                                    <td x-text="row.attachment_date"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>

                    <div class="space-y-3">
                        <button type="button" class="btn-secondary w-full justify-center">Browse</button>
                        <button type="button" class="btn-secondary w-full justify-center">Display</button>
                        <button type="button" class="btn-secondary w-full justify-center">Delete</button>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>

        <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
            <button type="button" class="btn-primary" @click="saveItem()">{{ $isEdit ? 'Update Preview' : 'Create Preview' }}</button>
            <button type="button" class="btn-secondary" @click="cancelItem()">Cancel</button>
        </x-enterprise.action-bar>
    </section>

    @livewire('fleet.item-counters-manager')
</div>
@if ($isEdit)
</div>
@endif
