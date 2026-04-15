@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };
@endphp

<div class="space-y-6">
    <x-page-header
        title="Change Customer Information"
        description="Compact customer-information workspace with the same operational layout as the legacy screen, adapted to the current ATP design system."
    />

    @if ($statusMessage)
        <div class="rounded-xl border px-4 py-3 text-sm font-medium {{ $statusClasses }}">
            {{ $statusMessage }}
        </div>
    @endif

    <section class="attach-workspace-shell max-w-[720px]">
        <div class="space-y-4">
            <x-enterprise.panel muted class="space-y-3">
                <x-enterprise.lookup-row label="ID." for="change_customer_id">
                    <input
                        id="change_customer_id"
                        type="text"
                        wire:model.blur="functionalLocationCode"
                        wire:keydown.enter.prevent="loadFunctionalLocation"
                        class="input-field attach-input attach-input-highlight"
                    />
                    <x-slot name="action">
                        <button type="button" wire:click="loadFunctionalLocation" class="attach-mini-button">Go</button>
                    </x-slot>
                </x-enterprise.lookup-row>

                @foreach ([
                    ['label' => 'Serial no.', 'value' => $serialNo],
                    ['label' => 'Registration', 'value' => $registration],
                    ['label' => 'Type', 'value' => $type],
                ] as $field)
                    <x-enterprise.field-row :label="$field['label']">
                        <input type="text" readonly value="{{ $field['value'] }}" class="input-field attach-input attach-input-readonly" />
                    </x-enterprise.field-row>
                @endforeach
            </x-enterprise.panel>

            @if ($recordLoaded)
                <x-enterprise.panel muted class="space-y-3">
                    @foreach ([
                        ['label' => 'Owner code', 'model' => 'ownerCode', 'with_action' => true],
                        ['label' => 'Owner name', 'model' => 'ownerName'],
                        ['label' => 'Operator code', 'model' => 'operatorCode', 'with_action' => true],
                        ['label' => 'Operator name', 'model' => 'operatorName'],
                    ] as $field)
                        @if (! empty($field['with_action']))
                            <x-enterprise.lookup-row :label="$field['label']">
                                <input type="text" wire:model.live="{{ $field['model'] }}" class="input-field attach-input" />
                                <x-slot name="action">
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </x-slot>
                            </x-enterprise.lookup-row>
                        @else
                            <x-enterprise.field-row :label="$field['label']">
                                <input type="text" wire:model.live="{{ $field['model'] }}" class="input-field attach-input" />
                            </x-enterprise.field-row>
                        @endif
                    @endforeach
                </x-enterprise.panel>

                <x-enterprise.panel muted class="space-y-4">
                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="forceOwnerPropagation" />
                        <span>Force owner propagation</span>
                    </label>

                    <div class="grid grid-cols-[112px_160px] items-center gap-3">
                        <span class="attach-field-label">Date of change</span>
                        <input type="text" wire:model.live="dateOfChange" class="input-field attach-input" />
                    </div>

                    <div class="attach-textarea-row">
                        <span class="attach-field-label">Comment</span>
                        <textarea rows="4" wire:model.live="comment" class="input-field attach-textarea"></textarea>
                    </div>
                </x-enterprise.panel>
            @endif
        </div>

        @if ($recordLoaded)
            <x-enterprise.action-bar>
                <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
                <a href="{{ route('fleet.functional-location.customer') }}" class="btn-secondary">Cancel</a>
            </x-enterprise.action-bar>
        @else
            <x-empty-state
                icon="magnifying-glass"
                label="No functional location selected"
                description="Enter an aircraft ID above and press Go, or open Search Functional Locations to select a record."
            >
                <a href="{{ route('fleet.functional-location.index') }}" class="btn-primary">Go to Search Functional Locations</a>
            </x-empty-state>
        @endif
    </section>
</div>
