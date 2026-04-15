@php
    use App\Support\EquipmentCatalog;

    $equipment = EquipmentCatalog::find(1) ?? [
        'id' => '1',
        'equipment_no' => '1',
        'serial_number' => '31324',
        'item_no' => 'AW139',
        'item_description' => 'AW139',
        'category_part' => '',
        'variant' => 'AW139',
    ];

    $equipmentFields = [
        ['label' => 'Equipment No.', 'name' => 'equipment_no', 'value' => $equipment['equipment_no'] ?? $equipment['id']],
        ['label' => 'Serial Number', 'name' => 'serial_number', 'value' => $equipment['serial_number']],
        ['label' => 'Item Number', 'name' => 'item_no', 'value' => $equipment['item_no']],
        ['label' => 'Item Description', 'name' => 'item_description', 'value' => $equipment['item_description']],
        ['label' => 'Category Part', 'name' => 'category_part', 'value' => $equipment['category_part']],
        ['label' => 'Variant', 'name' => 'variant', 'value' => $equipment['variant']],
    ];

    $currentAtaFields = [
        ['label' => 'Chapter', 'value' => 'AC'],
        ['label' => 'Section', 'value' => '00'],
        ['label' => 'Subject', 'value' => '00'],
        ['label' => 'Sheet', 'value' => '000'],
        ['label' => 'Mark', 'value' => '00'],
    ];

    $newAtaFields = [
        ['label' => 'Chapter', 'value' => 'AC'],
        ['label' => 'Section', 'value' => '00'],
        ['label' => 'Subject', 'value' => '00'],
        ['label' => 'Sheet', 'value' => '000'],
        ['label' => 'Mark', 'value' => '00'],
    ];
@endphp

<div class="space-y-6" x-data="{ step: 1, newItemNumber: true, newSerialNumber: false }">
    <x-page-header
        title="Equipment Reference Evolution"
        description="Two-step equipment reference workflow using the current ATP design system."
    />

    <x-card title="Equipment Reference Evolution" description="Choose the equipment first, then stage the new reference information." padding="p-6">
        <div class="space-y-6">
            <div x-show="step === 1" x-cloak class="space-y-6">
                <p class="text-sm font-semibold text-gray-900">Step 1 : Choose the equipment</p>

                <div class="grid gap-6 xl:grid-cols-[380px_auto] xl:items-start">
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-600">Equipment information</p>

                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach ($equipmentFields as $field)
                                <x-form.input
                                    :label="$field['label']"
                                    :name="'step1_' . $field['name']"
                                    :value="$field['value']"
                                    readonly
                                    class="input-field-filled"
                                />
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-8 xl:pt-9">
                        <a href="{{ route('fleet.equipment.index') }}" class="btn-secondary">Search Equipment</a>
                    </div>
                </div>
            </div>

            <div x-show="step === 2" x-cloak class="space-y-6">
                <p class="text-sm font-semibold text-gray-900">Step 2 : Enter new references information</p>

                <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)] xl:items-start">
                    <div class="space-y-5">
                        <div class="space-y-3">
                            <p class="text-sm font-medium text-gray-600">Equipment information</p>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ($equipmentFields as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="'step2_' . $field['name']"
                                        :value="$field['value']"
                                        readonly
                                        class="input-field-filled"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="grid gap-4 md:grid-cols-2">
                                <x-form.input
                                    label="Date"
                                    name="evolution_date"
                                    value="30.03.26"
                                />
                            </div>

                            <div class="grid grid-cols-[132px_minmax(0,1fr)] items-start gap-3">
                                <label for="evolution_comment" class="pt-2 text-sm font-medium text-gray-600">Comment</label>
                                <textarea
                                    id="evolution_comment"
                                    name="evolution_comment"
                                    rows="5"
                                    class="input-field resize-none"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="space-y-4 rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                        <input type="checkbox" x-model="newItemNumber" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span>New Item Number</span>
                                    </label>

                                    <x-form.input
                                        label="Enter New Item Number"
                                        name="new_item_number"
                                        value=""
                                        x-bind:disabled="!newItemNumber"
                                        class="disabled:bg-gray-100 disabled:text-gray-400"
                                    />
                                </div>

                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                        <input type="checkbox" x-model="newSerialNumber" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span>New Serial Number</span>
                                    </label>

                                    <x-form.input
                                        label="Enter Serial Number"
                                        name="new_serial_number"
                                        value=""
                                        x-bind:disabled="!newSerialNumber"
                                        class="disabled:bg-gray-100 disabled:text-gray-400"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                            <div class="space-y-3">
                                <p class="text-sm font-semibold text-gray-900">Current ATA Code</p>
                                <div class="grid gap-4 md:grid-cols-2">
                                    @foreach ($currentAtaFields as $field)
                                        <x-form.input
                                            :label="$field['label']"
                                            :name="'current_' . strtolower($field['label'])"
                                            :value="$field['value']"
                                            readonly
                                            class="input-field-filled"
                                        />
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-3">
                                <p class="text-sm font-semibold text-gray-900">New ATA Code</p>
                                <div class="grid gap-4 md:grid-cols-2">
                                    @foreach ($newAtaFields as $field)
                                        <x-form.input
                                            :label="$field['label']"
                                            :name="'new_' . strtolower($field['label'])"
                                            :value="$field['value']"
                                            class="input-field"
                                        />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-secondary">Cancel</button>
                <button type="button" class="btn-secondary" x-bind:disabled="step === 1" @click="step = 1">&lt; Back</button>
                <button type="button" class="btn-primary" x-bind:disabled="step === 2" @click="step = 2">Next &gt;</button>
                <button type="button" class="btn-secondary" disabled>Finish</button>
            </div>
        </div>
    </x-card>
</div>
