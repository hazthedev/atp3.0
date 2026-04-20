@php
    $isSelected = (bool) ($selected ?? false);

    $selectedRecord = array_merge([
        'id' => $isSelected ? (string) ($record['id'] ?? '1') : '',
        'code' => $isSelected ? str_pad((string) ($record['id'] ?? '1'), 7, '0', STR_PAD_LEFT) : '',
        'type' => $isSelected ? ($record['type'] ?? 'AW139 SB') : '',
        'reference_prefix' => $isSelected ? ($record['type'] ?? 'AW139 SB') : '',
        'reference' => $isSelected ? ($record['reference'] ?? '139-429') : '',
        'reference_2' => '',
        'reference_3' => '',
        'revision' => $isSelected ? ($record['revision'] ?? 'A') : '',
        'title' => $isSelected ? ($record['title'] ?? 'WEIGHT EXTENSION 7000 KG') : '',
        'status' => $isSelected ? 'Applicable' : '',
        'creation_date' => $isSelected ? '26.05.25' : '',
        'effective_date' => $isSelected ? '26.05.25' : '',
        'chapter' => '',
        'section' => '',
        'subject' => '',
        'sheet' => '',
        'mark' => '',
        'mandatory' => false,
        'reference_change' => false,
        'parts_evolution' => false,
        'description' => $isSelected ? "PERFORM SB {$record['reference']}\n\nREFERENCE:\nEO-25-014-N139 ISSUE A" : '',
        'frequency' => $isSelected ? 'ONE TIME' : '',
        'planning' => '',
        'unit_of_measure' => $isSelected ? 'Months' : '',
        'cut_off_date' => '',
        'whichever_comes_last' => false,
        'url' => '',
        'file' => $isSelected ? '\\\\10.3.5.213\\SAP Attachment\\EO-25-014-N139 ISSUE A SB 139-429 WEIGHT EXTENSION.pdf' : '',
        'properties_check' => '',
    ], $isSelected ? ($record ?? []) : []);

    $statusOptions = ['', 'Applicable', 'Planned', 'Released'];
    $tabs = [
        ['id' => 'general', 'label' => 'General'],
        ['id' => 'effectivity', 'label' => 'Effectivity'],
        ['id' => 'scheduling-criteria', 'label' => 'Scheduling Criteria'],
        ['id' => 'linked-task-list', 'label' => 'Linked Task List'],
        ['id' => 'related-modifications', 'label' => 'Related Modifications'],
        ['id' => 'attachments', 'label' => 'Attachments'],
        ['id' => 'properties', 'label' => 'Properties'],
    ];

    $effectivityTabs = [
        ['id' => 'functional-location-types', 'label' => 'Functional Location Types'],
        ['id' => 'variants', 'label' => 'Variants'],
        ['id' => 'items', 'label' => 'Items'],
    ];

    $variantOptions = [
        ['code' => '0000000', 'name' => 'AW139'],
        ['code' => '0000001', 'name' => 'AW189'],
    ];

    $functionalLocationTypeRows = $isSelected ? ['AW139'] : [''];

    $variantRows = $isSelected
        ? [
            ['index' => '1', 'name' => 'AW139'],
            ['index' => '2', 'name' => ''],
        ]
        : [
            ['index' => '1', 'name' => ''],
            ['index' => '2', 'name' => ''],
        ];

    $itemRows = [
        ['index' => '1', 'item_code' => ''],
    ];

    $primaryScheduleRows = $isSelected
        ? [
            ['description' => 'Calendar Limit', 'relative' => true, 'first_value_dec' => '1.0000', 'first_value_hm' => '', 'interval_dec' => '1.0000', 'interval_hm' => '', 'cut_off' => '0.0000'],
            ['description' => '', 'relative' => false, 'first_value_dec' => '0.0000', 'first_value_hm' => '', 'interval_dec' => '0.0000', 'interval_hm' => '', 'cut_off' => '0.0000'],
        ]
        : [
            ['description' => '', 'relative' => false, 'first_value_dec' => '', 'first_value_hm' => '', 'interval_dec' => '', 'interval_hm' => '', 'cut_off' => ''],
            ['description' => '', 'relative' => false, 'first_value_dec' => '', 'first_value_hm' => '', 'interval_dec' => '', 'interval_hm' => '', 'cut_off' => ''],
        ];

    $secondaryScheduleRows = $isSelected
        ? [
            ['hm' => '', 'cut_off_dec' => '0.0000', 'cut_off_hm' => '', 'tolerance_dec' => '0.0000', 'tolerance_hm' => '', 'alarm_dec' => '3.0000', 'alarm_hm' => ''],
            ['hm' => '', 'cut_off_dec' => '0.0000', 'cut_off_hm' => '', 'tolerance_dec' => '0.0000', 'tolerance_hm' => '', 'alarm_dec' => '0.0000', 'alarm_hm' => ''],
        ]
        : [
            ['hm' => '', 'cut_off_dec' => '', 'cut_off_hm' => '', 'tolerance_dec' => '', 'tolerance_hm' => '', 'alarm_dec' => '', 'alarm_hm' => ''],
            ['hm' => '', 'cut_off_dec' => '', 'cut_off_hm' => '', 'tolerance_dec' => '', 'tolerance_hm' => '', 'alarm_dec' => '', 'alarm_hm' => ''],
        ];

    $linkedTaskListRows = $isSelected
        ? [
            ['task_type' => 'Aircraft AD/SB', 'task_list_ref' => 'AW139 SB 139-429', 'short_description' => 'WEIGHT EXTENSION 7000 KG', 'status' => 'Released', 'item_ata' => '00--------'],
        ]
        : [
            ['task_type' => '', 'task_list_ref' => '', 'short_description' => '', 'status' => '', 'item_ata' => ''],
        ];

    $attachmentRows = [
        ['path' => '', 'file_name' => '', 'file_extension' => '', 'attachment_date' => '', 'type' => ''],
    ];

    $propertyWithoutValueRows = array_fill(0, 6, ['name' => '']);
    $propertyChoiceRows = array_fill(0, 4, ['name' => '']);
@endphp

<div x-data="editMode(false)" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
<div
    class="space-y-6"
    x-data="{
        activeTab: 'general',
        effectivityTab: 'functional-location-types',
        variantModalOpen: false,
        pendingVariantCode: '{{ $variantOptions[0]['code'] }}',
        variantOptions: @js($variantOptions),
        variantRows: @js($variantRows),
        chooseVariant() {
            const selected = this.variantOptions.find((option) => option.code === this.pendingVariantCode);
            if (!selected) return;
            this.variantRows = [
                { index: '1', name: selected.name },
                { index: '2', name: this.variantRows[1]?.name ?? '' },
            ];
            this.variantModalOpen = false;
        }
    }"
>
    <x-page-header
        title="Modification"
        description="Modification workspace using the legacy operational tab structure, adapted into the current ATP design system."
    >
        <x-slot name="actions">
            <template x-if="!editing">
                <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
            </template>
            <template x-if="editing">
                <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
            </template>
            <template x-if="editing">
                <button type="button" class="btn-primary" @click="toggle()">Save</button>
            </template>
        </x-slot>
    </x-page-header>

    <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="space-y-5">
            {{-- Top grid: left = code/reference fields, right = status --}}
            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                <div class="space-y-2">
                    <div class="grid items-center gap-2" style="grid-template-columns: 112px minmax(0,1fr)">
                        <span class="attach-field-label">Code</span>
                        <input type="text" value="{{ $selectedRecord['code'] }}" readonly class="input-field attach-input max-w-[140px]" />
                    </div>

                    <div class="grid items-center gap-2" style="grid-template-columns: 112px 140px minmax(0,1fr)">
                        <span class="attach-field-label">Reference</span>
                        <input type="text" value="{{ $selectedRecord['reference_prefix'] }}" readonly class="input-field attach-input" />
                        <input type="text" value="{{ $selectedRecord['reference'] }}" readonly class="input-field attach-input" />
                    </div>

                    <div class="grid items-center gap-2" style="grid-template-columns: 112px 140px minmax(0,1fr)">
                        <span class="attach-field-label">Reference 2</span>
                        <select class="input-field attach-input">
                            <option value=""></option>
                        </select>
                        <input type="text" value="{{ $selectedRecord['reference_2'] }}" readonly class="input-field attach-input" />
                    </div>

                    <div class="grid items-center gap-2" style="grid-template-columns: 112px 140px minmax(0,1fr)">
                        <span class="attach-field-label">Reference 3</span>
                        <select class="input-field attach-input">
                            <option value=""></option>
                        </select>
                        <input type="text" value="{{ $selectedRecord['reference_3'] }}" readonly class="input-field attach-input" />
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="grid items-center gap-2" style="grid-template-columns: 112px minmax(0,1fr)">
                        <span class="attach-field-label">Status</span>
                        <select class="input-field attach-input">
                            @foreach ($statusOptions as $option)
                                <option value="{{ $option }}" @selected($option === $selectedRecord['status'])>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid items-center gap-2" style="grid-template-columns: 112px minmax(0,1fr)">
                <span class="attach-field-label">Title</span>
                <input type="text" value="{{ $selectedRecord['title'] }}" readonly class="input-field attach-input" />
            </div>

            {{-- Tab bar --}}
            <div class="rounded-xl border border-gray-200 bg-white px-4 pt-3 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach ($tabs as $tab)
                            <li class="subtab-item">
                                <button
                                    type="button"
                                    class="subtab-link"
                                    :class="activeTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                    @click="activeTab = '{{ $tab['id'] }}'"
                                >
                                    {{ $tab['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- General tab --}}
            <div x-cloak x-show="activeTab === 'general'" class="modification-tab-panel">
                <div class="grid gap-6 xl:grid-cols-[260px_minmax(0,1fr)]">
                    <div class="space-y-2">
                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Revision</span>
                            <input type="text" value="{{ $selectedRecord['revision'] }}" readonly class="input-field attach-input max-w-[96px]" />
                        </div>

                        <label class="grid items-center gap-3" style="grid-template-columns: 112px auto">
                            <span class="attach-field-label">Mandatory</span>
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($selectedRecord['mandatory']) />
                        </label>

                        <label class="grid items-center gap-3" style="grid-template-columns: 112px auto">
                            <span class="attach-field-label">Reference Change</span>
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($selectedRecord['reference_change']) />
                        </label>

                        <label class="grid items-center gap-3" style="grid-template-columns: 112px auto">
                            <span class="attach-field-label">Parts Evolution</span>
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($selectedRecord['parts_evolution']) />
                        </label>
                    </div>

                    <div class="space-y-3">
                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                                <span class="attach-field-label">Creation Date</span>
                                <input type="text" value="{{ $selectedRecord['creation_date'] }}" readonly class="input-field attach-input" />
                            </div>

                            <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                                <span class="attach-field-label">Effective Date</span>
                                <input type="text" value="{{ $selectedRecord['effective_date'] }}" readonly class="input-field attach-input" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="attach-field-label">Chapter - Section - Subject - Sheet - Mark</div>
                            <div class="grid grid-cols-5 gap-2">
                                @foreach (['chapter', 'section', 'subject', 'sheet', 'mark'] as $key)
                                    <input type="text" value="{{ $selectedRecord[$key] }}" readonly class="input-field attach-input" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid items-start gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                    <span class="attach-field-label pt-2">Description</span>
                    <textarea rows="7" readonly class="input-field min-h-[180px] resize-none px-3 py-2 text-sm">{{ $selectedRecord['description'] }}</textarea>
                </div>

                <div class="mt-5 grid gap-4 lg:grid-cols-[minmax(0,360px)_auto] lg:items-center">
                    <div class="space-y-3">
                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Frequency</span>
                            <select class="input-field attach-input">
                                <option selected>{{ $selectedRecord['frequency'] }}</option>
                            </select>
                        </div>

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Planning</span>
                            <select class="input-field attach-input">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <label class="inline-flex items-center gap-3 text-sm text-gray-700 lg:justify-self-start">
                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                        <span>Repetitive</span>
                    </label>
                </div>
            </div>

            {{-- Effectivity tab --}}
            <div x-cloak x-show="activeTab === 'effectivity'" class="modification-tab-panel space-y-5">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach ($effectivityTabs as $tab)
                            <li class="subtab-item">
                                <button
                                    type="button"
                                    class="subtab-link"
                                    :class="effectivityTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                    @click="effectivityTab = '{{ $tab['id'] }}'"
                                >
                                    {{ $tab['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div x-cloak x-show="effectivityTab === 'functional-location-types'" class="flex flex-col gap-4 xl:flex-row xl:items-start">
                    <div class="w-full max-w-[260px] overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="pending-base-table">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Functional Location Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $functionalLocationTypeRows[0] }}</td>
                                </tr>
                                @foreach (range(1, 7) as $row)
                                    <tr>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-cloak x-show="effectivityTab === 'variants'" class="flex flex-col gap-4 xl:flex-row xl:items-start">
                    <div class="w-full max-w-[260px] overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="pending-base-table">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="w-12 border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">#</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Variant Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="row in variantRows" :key="row.index">
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700" x-text="row.index"></td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700" x-text="row.name"></td>
                                    </tr>
                                </template>
                                @foreach (range(1, 6) as $row)
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="button" class="btn-secondary" @click="variantModalOpen = true">Add Variant</button>
                    </div>
                </div>

                <div x-cloak x-show="effectivityTab === 'items'" class="flex flex-col gap-4 xl:flex-row xl:items-start">
                    <div class="w-full max-w-[180px] overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="pending-base-table">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="w-12 border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">#</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Item Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemRows as $row)
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['index'] }}</td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['item_code'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach (range(1, 7) as $row)
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Scheduling Criteria tab --}}
            <div x-cloak x-show="activeTab === 'scheduling-criteria'" class="modification-tab-panel space-y-5">
                <div class="flex flex-wrap items-center gap-6">
                    <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($selectedRecord['whichever_comes_last']) />
                        <span>Whichever Comes Last</span>
                    </label>

                    <div class="flex items-center gap-3">
                        <span class="attach-field-label">Unit of Measure</span>
                        <select class="input-field attach-input">
                            <option selected>{{ $selectedRecord['unit_of_measure'] }}</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="attach-field-label">Cut-Off date</span>
                        <input type="text" value="{{ $selectedRecord['cut_off_date'] }}" class="input-field attach-input" />
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="text-sm font-semibold text-gray-900">Default Scheduling Criteria</div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="pending-base-table">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Description</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Relative</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">First Value (dec.)</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">First Value (hh:mm)</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Interval (dec.)</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Interval (hh:mm)</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Cut-Off</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($primaryScheduleRows as $row)
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['description'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-center text-sm text-gray-700">
                                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked($row['relative']) />
                                        </td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['first_value_dec'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['first_value_hm'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['interval_dec'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['interval_hm'] }}</td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['cut_off'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach (range(1, 6) as $row)
                                    <tr>
                                        @foreach (range(1, 6) as $cell)
                                            <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                        @endforeach
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <table class="pending-base-table">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">(h:mm)</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Cut-Off (dec.)</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Cut-Off (hh:mm)</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Tolerance (dec.)</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Tolerance (hh:mm)</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Alarm (dec.)</th>
                                <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Alarm (hh:mm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secondaryScheduleRows as $row)
                                <tr>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['hm'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['cut_off_dec'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['cut_off_hm'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['tolerance_dec'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['tolerance_hm'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['alarm_dec'] }}</td>
                                    <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['alarm_hm'] }}</td>
                                </tr>
                            @endforeach
                            @foreach (range(1, 6) as $row)
                                <tr>
                                    @foreach (range(1, 6) as $cell)
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    @endforeach
                                    <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Linked Task List tab --}}
            <div x-cloak x-show="activeTab === 'linked-task-list'" class="modification-tab-panel space-y-5">
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <table class="pending-base-table">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Task List Type</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Task List Ref</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Short Description</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Status</th>
                                <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Item ATA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($linkedTaskListRows as $row)
                                <tr>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['task_type'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">
                                        <span class="inline-flex items-center gap-2 font-semibold text-gray-900">
                                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                            </span>
                                            <span>{{ $row['task_list_ref'] }}</span>
                                        </span>
                                    </td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['short_description'] }}</td>
                                    <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['status'] }}</td>
                                    <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['item_ata'] }}</td>
                                </tr>
                            @endforeach
                            @foreach (range(1, 3) as $row)
                                <tr>
                                    @foreach (range(1, 4) as $cell)
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    @endforeach
                                    <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <button type="button" class="btn-secondary">Assign Task List</button>
                    <button type="button" class="btn-secondary">Create Task List</button>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">Linked Maintenance Program</div>
                        <div class="min-h-[120px] rounded-xl border border-gray-200 bg-gray-50/30"></div>
                        <button type="button" class="btn-secondary">Assign/Reassign to Maintenance Program</button>
                    </div>

                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">Monitored Items</div>
                        <div class="min-h-[120px] rounded-xl border border-gray-200 bg-gray-50/30"></div>
                        <button type="button" class="btn-secondary">Assign/Reassign to Item Master Data</button>
                    </div>
                </div>
            </div>

            {{-- Related Modifications tab --}}
            <div x-cloak x-show="activeTab === 'related-modifications'" class="modification-tab-panel">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-start">
                    <div class="w-full max-w-[260px] overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="pending-base-table">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Reference</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (range(1, 8) as $row)
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="button" class="btn-secondary">Add Modification</button>
                    </div>
                </div>
            </div>

            {{-- Attachments tab --}}
            <div x-cloak x-show="activeTab === 'attachments'" class="modification-tab-panel space-y-4">
                <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                    <span class="attach-field-label">URL</span>
                    <input type="text" value="{{ $selectedRecord['url'] }}" class="input-field attach-input" />
                </div>

                <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                    <span class="attach-field-label">File</span>
                    <input type="text" value="{{ $selectedRecord['file'] }}" class="input-field attach-input" />
                </div>

                <div class="flex flex-col gap-4 xl:flex-row xl:items-start">
                    <div class="min-w-0 flex-1 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="pending-base-table">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">#</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Path</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">File Name</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">File Extension</th>
                                    <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Attachment Date</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attachmentRows as $index => $row)
                                    <tr>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['path'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['file_name'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['file_extension'] }}</td>
                                        <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['attachment_date'] }}</td>
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['type'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach (range(1, 8) as $row)
                                    <tr>
                                        @foreach (range(1, 5) as $cell)
                                            <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                        @endforeach
                                        <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="button" class="btn-secondary">Browse</button>
                        <button type="button" class="btn-secondary">Display</button>
                        <button type="button" class="btn-secondary">Delete</button>
                    </div>
                </div>
            </div>

            {{-- Properties tab --}}
            <div x-cloak x-show="activeTab === 'properties'" class="modification-tab-panel space-y-5">
                <div class="grid gap-6 xl:grid-cols-[220px_minmax(0,1fr)]">
                    <div class="space-y-2">
                        @foreach (['Group 1', 'Group 2', 'Group 3', 'Group 4'] as $index => $group)
                            <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                                <input type="radio" name="modification_property_group" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" @checked($index === 0) />
                                <span>{{ $group }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                        <span class="attach-field-label">Properties Checks</span>
                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                            <input type="text" value="{{ $selectedRecord['properties_check'] }}" class="input-field attach-input" />
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">Properties without defined value</div>
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                            <table class="pending-base-table">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Property Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($propertyWithoutValueRows as $row)
                                        <tr>
                                            <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['name'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">Properties with several choice</div>
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                            <table class="pending-base-table">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Property Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($propertyChoiceRows as $row)
                                        <tr>
                                            <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['name'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="sticky-form-actions">
        <button type="button" class="btn-secondary">Cancel</button>
        <button type="button" class="btn-primary">OK</button>
    </div>

    <div x-cloak x-show="variantModalOpen" class="fixed inset-0 z-40 overflow-y-auto p-4">
        <div class="flex min-h-full items-center justify-center">
            <div class="relative w-full max-w-2xl">
                <div class="relative flex max-h-[60vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                    <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Choose From List</h3>
                            <p class="mt-1 text-sm text-gray-500">Equipment Variant List</p>
                        </div>

                        <button type="button" class="btn-ghost px-3" @click="variantModalOpen = false" aria-label="Close modal">
                            <x-icon name="x-circle" />
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto px-5 py-4">
                        <div class="space-y-5">
                            <div class="w-full max-w-sm">
                                <x-form.input
                                    label="Find"
                                    name="modification_variant_find"
                                    placeholder="Search variant code or name..."
                                />
                            </div>

                            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                                <table class="pending-base-table">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Equipment Variant Code</th>
                                            <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">Equipment Variant Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="option in variantOptions" :key="option.code">
                                            <tr
                                                class="cursor-pointer transition-colors"
                                                :class="pendingVariantCode === option.code ? 'bg-blue-50/70' : ''"
                                                @click="pendingVariantCode = option.code"
                                            >
                                                <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700" x-text="option.code"></td>
                                                <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700" x-text="option.name"></td>
                                            </tr>
                                        </template>
                                        @foreach (range(1, 6) as $row)
                                            <tr>
                                                <td class="border-r border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                                <td class="border-t border-gray-200 px-3 py-2 text-sm text-gray-700"><span class="invisible">.</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 px-5 py-4">
                        <button type="button" class="btn-primary" @click="chooseVariant()">Choose</button>
                        <button type="button" class="btn-secondary" @click="variantModalOpen = false">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
