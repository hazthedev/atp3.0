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
                    <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                        <label for="change_equipment_id" class="attach-field-label">I.D.</label>
                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                            <input
                                id="change_equipment_id"
                                type="text"
                                wire:model.blur="equipmentId"
                                wire:keydown.enter.prevent="loadEquipment"
                                class="input-field attach-input attach-input-highlight"
                            />
                            <button type="button" wire:click="loadEquipment" class="attach-mini-button" title="Load equipment">...</button>
                        </div>
                    </div>

                    @foreach ([
                        ['label' => 'Serial no.', 'value' => $serialNo],
                        ['label' => 'Item no.', 'value' => $itemNo],
                        ['label' => 'Item Description', 'value' => $itemDescription],
                        ['label' => 'Variant', 'value' => $variant],
                        ['label' => 'Category part', 'value' => $categoryPart],
                    ] as $field)
                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">{{ $field['label'] }}</span>
                            <input type="text" readonly value="{{ $field['value'] }}" class="input-field attach-input attach-input-readonly" />
                        </div>
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
                            <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                                <span class="attach-field-label">{{ $field['label'] }}</span>
                                @if (! empty($field['with_action']))
                                    <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                        <input type="text" wire:model.live="{{ $field['model'] }}" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                @else
                                    <input type="text" wire:model.live="{{ $field['model'] }}" class="input-field attach-input" />
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Extra options block --}}
                    <div class="space-y-3 pt-1">
                        <label class="attach-checkbox-row">
                            <input type="checkbox" wire:model.live="forceOwnerPropagation" />
                            <span>Force owner propagation</span>
                        </label>

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px 148px">
                            <span class="attach-field-label">Date of change</span>
                            <input type="text" wire:model.live="dateOfChange" class="input-field attach-input" />
                        </div>

                        <div class="grid items-start gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label pt-2">Comment</span>
                            <textarea rows="3" wire:model.live="comment" class="input-field attach-textarea"></textarea>
                        </div>
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
