<div class="space-y-6">
    <x-page-header
        title="Change Customer Information"
        description="Compact equipment customer-information workspace with the same operational layout as the legacy screen, adapted to the current ATP design system."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[620px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="space-y-4">
                {{-- Equipment ID lookup — always visible --}}
                <div class="space-y-2">
                    <x-enterprise.field-row label="I.D." for="change_equipment_id" label-class="attach-field-label">
                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                            <x-enterprise.input
                                id="change_equipment_id"
                                wire:model.blur="equipmentId"
                                wire:keydown.enter.prevent="loadEquipment"
                                class="attach-input attach-input-highlight"
                            />
                            <button type="button" wire:click="loadEquipment" class="attach-mini-button" title="Load equipment">...</button>
                        </div>
                    </x-enterprise.field-row>

                    @foreach ([
                        ['label' => 'Serial no.', 'value' => $serialNo],
                        ['label' => 'Item no.', 'value' => $itemNo],
                        ['label' => 'Item Description', 'value' => $itemDescription],
                        ['label' => 'Variant', 'value' => $variant],
                        ['label' => 'Category part', 'value' => $categoryPart],
                    ] as $field)
                        <x-enterprise.field-row :label="$field['label']" label-class="attach-field-label">
                            <x-enterprise.input variant="disabled" value="{{ $field['value'] }}" class="attach-input attach-input-readonly" />
                        </x-enterprise.field-row>
                    @endforeach
                </div>

                @if ($recordLoaded)
                    {{-- Owner / Operator block --}}
                    <div class="space-y-2">
                        @foreach ([
                            ['label' => 'Owner code', 'model' => 'ownerCode', 'with_action' => true],
                            ['label' => 'Owner name', 'model' => 'ownerName'],
                            ['label' => 'Operator code', 'model' => 'operatorCode', 'with_action' => true],
                            ['label' => 'Operator name', 'model' => 'operatorName'],
                        ] as $field)
                            <x-enterprise.field-row :label="$field['label']" label-class="attach-field-label">
                                @if (! empty($field['with_action']))
                                    <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                        <x-enterprise.input wire:model.live="{{ $field['model'] }}" class="attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                @else
                                    <x-enterprise.input wire:model.live="{{ $field['model'] }}" class="attach-input" />
                                @endif
                            </x-enterprise.field-row>
                        @endforeach
                    </div>

                    {{-- Extra options block --}}
                    <div class="space-y-3 pt-1">
                        <x-enterprise.checkbox
                            label="Force owner propagation"
                            wire:model.live="forceOwnerPropagation"
                        />

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px 148px">
                            <span class="attach-field-label">Date of change</span>
                            <x-enterprise.input wire:model.live="dateOfChange" class="attach-input" />
                        </div>

                        <x-enterprise.textarea-row label="Comment" :rows="3" wire:model.live="comment" class="attach-textarea" />
                    </div>
                @endif
            </div>

            @if ($recordLoaded)
                <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                    <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
                    <a href="{{ route('fleet.equipment.customer-equipment-card') }}" class="btn-secondary">Cancel</a>
                </div>
            @endif
        </div>

        @unless ($recordLoaded)
            <x-empty-state
                icon="magnifying-glass"
                label="No equipment selected"
                description="Enter an equipment ID above and press the lookup button, or open Search Equipments to select a record."
            >
                <a href="{{ route('fleet.equipment.index') }}" class="btn-primary">Go to Search Equipments</a>
            </x-empty-state>
        @endunless
    </section>
</div>
